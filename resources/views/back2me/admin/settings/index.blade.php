@extends('back2me.layout')

@section('title','Pengaturan Sistem')
@section('subtitle','Atur batas upload, jumlah file, dan SLA klaim')

@section('content')
<div class="card card-hover p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Konfigurasi Back2Me</h3>
            <p class="text-sm text-slate-600">Nilai disimpan di cache (forever). Sesuaikan sesuai kebutuhan operasional.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('back2me.admin.settings.update') }}" class="space-y-4">
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-700">Maksimal ukuran upload (KB)</label>
                <input type="number" name="max_upload_size" value="{{ old('max_upload_size', $settings['max_upload_size']) }}" min="1024" max="10240" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                <p class="text-xs text-slate-500 mt-1">Rentang 1024 - 10240 (1MB - 10MB).</p>
                @error('max_upload_size')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Maksimal jumlah file</label>
                <input type="number" name="max_upload_files" value="{{ old('max_upload_files', $settings['max_upload_files']) }}" min="1" max="10" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                <p class="text-xs text-slate-500 mt-1">Rentang 1 - 10 file.</p>
                @error('max_upload_files')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-700">Timeout klaim (hari)</label>
                <input type="number" name="claim_timeout_days" value="{{ old('claim_timeout_days', $settings['claim_timeout_days']) }}" min="1" max="365" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                <p class="text-xs text-slate-500 mt-1">Durasi maksimal menunggu verifikasi klaim.</p>
                @error('claim_timeout_days')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Auto close laporan (hari)</label>
                <input type="number" name="auto_close_days" value="{{ old('auto_close_days', $settings['auto_close_days']) }}" min="30" max="365" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                <p class="text-xs text-slate-500 mt-1">Tutup otomatis jika tidak ada aktivitas.</p>
                @error('auto_close_days')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button class="btn-primary" type="submit"><i class='bx bxs-save'></i> Simpan Pengaturan</button>
            <a href="{{ route('back2me.admin.settings.index') }}" class="btn-ghost">Reset</a>
        </div>
    </form>
</div>
@endsection
