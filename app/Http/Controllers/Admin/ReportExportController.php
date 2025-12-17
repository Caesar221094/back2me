<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportExportController extends Controller
{
    public function index()
    {
        return view('back2me.admin.reports.export');
    }

    public function exportMonthly(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'month' => 'required|integer|min:1|max:12',
        ]);

        $year = $request->year;
        $month = $request->month;

        $reports = Report::with(['user', 'category'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $reports->count(),
            'pending' => $reports->where('status', 'pending')->count(),
            'diproses' => $reports->where('status', 'diproses')->count(),
            'selesai' => $reports->where('status', 'selesai')->count(),
            'ditolak' => $reports->where('status', 'ditolak')->count(),
        ];

        return $this->generateCSV($reports, $stats, "Laporan_Bulanan_{$year}_{$month}.csv");
    }

    public function exportYearly(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1),
        ]);

        $year = $request->year;

        $reports = Report::with(['user', 'category'])
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $reports->count(),
            'pending' => $reports->where('status', 'pending')->count(),
            'diproses' => $reports->where('status', 'diproses')->count(),
            'selesai' => $reports->where('status', 'selesai')->count(),
            'ditolak' => $reports->where('status', 'ditolak')->count(),
        ];

        // Monthly breakdown
        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthly[$m] = $reports->filter(fn($r) => $r->created_at->month == $m)->count();
        }

        return $this->generateCSV($reports, $stats, "Laporan_Tahunan_{$year}.csv", $monthly);
    }

    private function generateCSV($reports, $stats, $filename, $monthly = null)
    {
        $output = fopen('php://temp', 'w');

        // Header
        fputcsv($output, ['LAPORAN REKAP BACK2ME']);
        fputcsv($output, ['Tanggal Export', date('Y-m-d H:i:s')]);
        fputcsv($output, []);

        // Statistics
        fputcsv($output, ['STATISTIK']);
        fputcsv($output, ['Total Laporan', $stats['total']]);
        fputcsv($output, ['Pending', $stats['pending']]);
        fputcsv($output, ['Diproses', $stats['diproses']]);
        fputcsv($output, ['Selesai', $stats['selesai']]);
        fputcsv($output, ['Ditolak', $stats['ditolak']]);
        fputcsv($output, []);

        // Monthly breakdown if yearly report
        if ($monthly) {
            fputcsv($output, ['BREAKDOWN BULANAN']);
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            foreach ($monthly as $m => $count) {
                fputcsv($output, [$months[$m - 1], $count]);
            }
            fputcsv($output, []);
        }

        // Detail data
        fputcsv($output, ['DETAIL LAPORAN']);
        fputcsv($output, ['ID', 'Judul', 'Pelapor', 'Kategori', 'Lokasi', 'Status', 'Tanggal', 'Diklaim Oleh', 'Tanggal Klaim']);

        foreach ($reports as $report) {
            fputcsv($output, [
                $report->id,
                $report->judul,
                $report->user->name,
                $report->category ? $report->category->nama : '-',
                $report->lokasi ?? '-',
                ucfirst($report->status),
                $report->created_at->format('Y-m-d H:i'),
                $report->claimed_by ? \App\Models\User::find($report->claimed_by)?->name : '-',
                $report->claimed_at ? $report->claimed_at->format('Y-m-d H:i') : '-',
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
