@extends('back2me.layout')

@section('title','Export Laporan')
@section('subtitle','Unduh rekap laporan bulanan atau tahunan')

@section('content')
<div class="card card-hover p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Export Data</h3>
            <p class="text-sm text-slate-600">Pilih periode lalu unduh CSV berisi statistik dan detail laporan.</p>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="card p-5 space-y-4">
            <h4 class="text-base font-semibold text-slate-900">Export Bulanan</h4>
            <form method="POST" action="{{ route('back2me.admin.reports.export.monthly') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ now()->year }}" min="2020" max="{{ now()->year + 1 }}" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Bulan</label>
                    <select name="month" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn-primary" type="submit"><i class='bx bxs-download'></i> Unduh CSV Bulanan</button>
            </form>
        </div>

        <div class="card p-5 space-y-4">
            <h4 class="text-base font-semibold text-slate-900">Export Tahunan</h4>
            <form method="POST" action="{{ route('back2me.admin.reports.export.yearly') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ now()->year }}" min="2020" max="{{ now()->year + 1 }}" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <button class="btn-primary" type="submit"><i class='bx bxs-download'></i> Unduh CSV Tahunan</button>
            </form>
        </div>
    </div>
</div>
@endsection
