<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('category','user');

        if ($q = $request->get('q')) {
            $query->where('judul','like',"%{$q}%")->orWhere('deskripsi','like',"%{$q}%");
        }

        if ($kategori = $request->get('category')) {
            $query->where('category_id', $kategori);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $reports = $query->orderBy('id','desc')->paginate(10)->withQueryString();

        $categories = Category::orderBy('nama')->get();

        return view('back2me.reports.index', compact('reports','categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('back2me.reports.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'foto.*' => 'nullable|image|max:5120', // 5MB per file
        ]);

        $data = $request->only(['judul','category_id','deskripsi','lokasi']);
        $data['user_id'] = $request->user()->id;

        $files = $request->file('foto', []);
        $paths = [];
        foreach ($files as $f) {
            $paths[] = $f->store('reports','public');
        }

        if ($paths) $data['foto'] = $paths;

        Report::create($data);

        return redirect()->route('back2me.reports.index')->with('success','Laporan dibuat');
    }

    public function show(Report $report)
    {
        return view('back2me.reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        if ($report->status !== 'pending') {
            return redirect()->back()->with('error','Tidak dapat edit setelah diverifikasi');
        }

        $categories = Category::orderBy('nama')->get();
        return view('back2me.reports.edit', compact('report','categories'));
    }

    public function update(Request $request, Report $report)
    {
        if ($report->status !== 'pending') {
            return redirect()->back()->with('error','Tidak dapat edit setelah diverifikasi');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'foto.*' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['judul','category_id','deskripsi','lokasi']);

        $files = $request->file('foto', []);
        $paths = $report->foto ?? [];
        foreach ($files as $f) {
            $paths[] = $f->store('reports','public');
        }
        if ($paths) $data['foto'] = $paths;

        $report->update($data);

        return redirect()->route('back2me.reports.show', $report)->with('success','Laporan diperbarui');
    }

    // User klaim barang
    public function claim(Request $request, Report $report)
    {
        // Hanya role user yang boleh klaim dan tidak boleh klaim laporan sendiri
        if ($request->user()->role !== 'user') {
            return redirect()->back()->with('error', 'Hanya pengguna biasa yang dapat melakukan klaim');
        }

        if ($report->user_id === $request->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengklaim laporan yang Anda buat sendiri');
        }

        if ($report->claimed_by) {
            return redirect()->back()->with('error','Sudah ada klaim');
        }

        $report->update([
            'claimed_by' => $request->user()->id,
            'claimed_at' => now(),
            'status' => 'diproses',
        ]);

        // create notification for petugas (in-app)
        $request->user()->notify(new \App\Notifications\ReportClaimed($report));

        return redirect()->back()->with('success','Klaim terkirim, menunggu verifikasi petugas');
    }

    // Petugas verifikasi / ubah status
    public function verify(Request $request, Report $report)
    {
        $request->validate(['status' => 'required|in:diproses,selesai,ditolak']);

        $report->update(['status' => $request->status]);

        return redirect()->back()->with('success','Status diperbarui');
    }

    // User konfirmasi penerimaan barang
    public function confirmReceipt(Request $request, Report $report)
    {
        if ($report->claimed_by !== $request->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak konfirmasi laporan ini');
        }

        if ($report->status !== 'selesai') {
            return redirect()->back()->with('error', 'Laporan belum disetujui petugas');
        }

        $report->update([
            'confirmed_at' => now(),
            'confirmed_by' => $request->user()->id,
        ]);

        // Notify petugas
        $report->user->notify(new \App\Notifications\ReportConfirmed($report));

        return redirect()->back()->with('success', 'Terima kasih! Konfirmasi penerimaan barang berhasil');
    }
}

