<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'max_upload_size' => Cache::get('back2me.max_upload_size', 5120), // KB
            'max_upload_files' => Cache::get('back2me.max_upload_files', 5),
            'claim_timeout_days' => Cache::get('back2me.claim_timeout_days', 30),
            'auto_close_days' => Cache::get('back2me.auto_close_days', 90),
        ];

        return view('back2me.admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_upload_size' => 'required|integer|min:1024|max:10240', // 1MB - 10MB
            'max_upload_files' => 'required|integer|min:1|max:10',
            'claim_timeout_days' => 'required|integer|min:1|max:365',
            'auto_close_days' => 'required|integer|min:30|max:365',
        ]);

        // Store settings in cache
        Cache::forever('back2me.max_upload_size', $request->max_upload_size);
        Cache::forever('back2me.max_upload_files', $request->max_upload_files);
        Cache::forever('back2me.claim_timeout_days', $request->claim_timeout_days);
        Cache::forever('back2me.auto_close_days', $request->auto_close_days);

        return redirect()->route('back2me.admin.settings.index')->with('success', 'Pengaturan berhasil disimpan');
    }
}
