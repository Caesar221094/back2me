<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $role = $user->role;

        // Stats berdasarkan role
        if ($role === 'user') {
            // User: Statistik laporan pribadi
            $stats = [
                'total' => Report::where('user_id', $user->id)->count(),
                'pending' => Report::where('user_id', $user->id)->where('status', 'pending')->count(),
                'diproses' => Report::where('user_id', $user->id)->where('status', 'diproses')->count(),
                'selesai' => Report::where('user_id', $user->id)->where('status', 'selesai')->count(),
                'ditolak' => Report::where('user_id', $user->id)->where('status', 'ditolak')->count(),
                'claimed_by_me' => Report::where('claimed_by', $user->id)->count(), // Item yang saya klaim
            ];

            // Recent reports: Laporan saya + laporan yang saya klaim
            $recentReports = Report::with(['category','user'])
                ->where(function($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('claimed_by', $user->id);
                })
                ->orderBy('created_at','desc')
                ->limit(5)
                ->get();
        } else {
            // Petugas & SuperAdmin: Statistik semua laporan
            $stats = [
                'total' => Report::count(),
                'pending' => Report::where('status', 'pending')->count(),
                'diproses' => Report::where('status', 'diproses')->count(),
                'selesai' => Report::where('status', 'selesai')->count(),
                'ditolak' => Report::where('status', 'ditolak')->count(),
                'claimed' => Report::whereNotNull('claimed_by')->count(),
            ];

            // SuperAdmin: tambah stats user
            if ($role === 'superadmin') {
                $stats['total_users'] = User::count();
                $stats['banned_users'] = User::where('is_banned', true)->count();
            }

            $recentReports = Report::with(['category','user'])
                ->orderBy('created_at','desc')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact('stats', 'recentReports', 'role'));
    }
}
