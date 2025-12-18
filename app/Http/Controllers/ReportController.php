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

        if ($tipe = $request->get('tipe')) {
            $query->where('tipe', $tipe);
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
            'tipe' => 'required|in:hilang,ditemukan',
            'category_id' => 'nullable|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'foto.*' => 'nullable|image|max:5120', // 5MB per file
        ]);

        $data = $request->only(['judul','tipe','category_id','deskripsi','lokasi']);
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
            'tipe' => 'required|in:hilang,ditemukan',
            'category_id' => 'nullable|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'foto.*' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['judul','tipe','category_id','deskripsi','lokasi']);

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

        // Validasi bukti kepemilikan
        $request->validate([
            'bukti.*' => 'required|image|max:5120',
            'catatan_klaim' => 'required|string|min:20|max:500',
        ], [
            'bukti.*.required' => 'Upload minimal 1 foto bukti kepemilikan',
            'catatan_klaim.required' => 'Catatan wajib diisi',
            'catatan_klaim.min' => 'Catatan minimal 20 karakter (jelaskan ciri-ciri barang)',
        ]);

        // Upload bukti
        $buktiPaths = [];
        foreach ($request->file('bukti', []) as $file) {
            $buktiPaths[] = $file->store('claims', 'public');
        }

        $report->update([
            'claimed_by' => $request->user()->id,
            'claimed_at' => now(),
            'bukti_klaim' => $buktiPaths,
            'catatan_klaim' => $request->catatan_klaim,
            'pelapor_approval' => 'pending',
            'status' => 'diproses',
        ]);

        // create notification for petugas (in-app)
        $request->user()->notify(new \App\Notifications\ReportClaimed($report));

        return redirect()->back()->with('success','Klaim terkirim dengan bukti kepemilikan. Menunggu approval dari pelapor');
    }

    // Pelapor approve klaim
    public function approveClaim(Request $request, Report $report)
    {
        if ($report->user_id !== $request->user()->id) {
            return redirect()->back()->with('error', 'Anda bukan pelapor laporan ini');
        }

        if ($report->pelapor_approval !== 'pending') {
            return redirect()->back()->with('error', 'Klaim sudah diproses');
        }

        $report->update([
            'pelapor_approval' => 'approved',
            'pelapor_approved_at' => now(),
        ]);

        // Notify petugas untuk verifikasi
        return redirect()->back()->with('success', 'Klaim disetujui. Menunggu verifikasi petugas');
    }

    // Pelapor reject klaim
    public function rejectClaim(Request $request, Report $report)
    {
        if ($report->user_id !== $request->user()->id) {
            return redirect()->back()->with('error', 'Anda bukan pelapor laporan ini');
        }

        if ($report->pelapor_approval !== 'pending') {
            return redirect()->back()->with('error', 'Klaim sudah diproses');
        }

        $report->update([
            'pelapor_approval' => 'rejected',
            'pelapor_approved_at' => now(),
            'status' => 'pending',
            'claimed_by' => null,
            'claimed_at' => null,
            'bukti_klaim' => null,
            'catatan_klaim' => null,
        ]);

        return redirect()->back()->with('success', 'Klaim ditolak. Laporan kembali terbuka');
    }

    // Petugas verifikasi / ubah status
    public function verify(Request $request, Report $report)
    {
        // Petugas hanya bisa verify jika pelapor sudah approve
        if ($report->pelapor_approval !== 'approved') {
            return redirect()->back()->with('error', 'Pelapor belum menyetujui klaim ini');
        }

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

