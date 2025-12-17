<?php

namespace App\Http\Controllers;

use App\Models\Report;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'diproses' => Report::where('status', 'diproses')->count(),
            'selesai' => Report::where('status', 'selesai')->count(),
            'ditolak' => Report::where('status', 'ditolak')->count(),
            'claimed' => Report::whereNotNull('claimed_by')->count(),
        ];

        $recentReports = Report::with(['category','user'])
            ->orderBy('created_at','desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentReports'));
    }
}
