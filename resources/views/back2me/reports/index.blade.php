@extends('back2me.layout')

@section('title','Daftar Laporan')
@section('subtitle','Cari, filter, dan kelola laporan hilang/temuan')

@section('content')
<div class="card card-hover p-6 flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Semua Laporan</h3>
            <p class="text-sm text-slate-600">Gunakan filter untuk mempersempit pencarian.</p>
        </div>
        <a href="{{ route('back2me.reports.create') }}" class="btn-primary">
            <i class='bx bxs-plus-circle'></i> Buat Laporan
        </a>
    </div>

    <form method="get" class="grid gap-3 md:grid-cols-4 bg-indigo-50/60 border border-indigo-100 rounded-xl p-4">
        <div class="md:col-span-2">
            <label class="text-xs font-semibold text-slate-600">Kata kunci</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau deskripsi" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-xs font-semibold text-slate-600">Kategori</label>
            <select name="category" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-semibold text-slate-600">Status</label>
            <select name="status" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
                <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
                <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            </select>
        </div>
        <div class="md:col-span-4 flex gap-3">
            <button class="btn-primary" type="submit"><i class='bx bx-search'></i> Filter</button>
            <a href="{{ route('back2me.reports.index') }}" class="btn-ghost">Reset</a>
        </div>
    </form>

    <div class="grid gap-3">
        @forelse($reports as $r)
            <a href="{{ route('back2me.reports.show', $r) }}" class="card card-hover p-4 flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-xs uppercase tracking-wide text-slate-500">#{{ $r->id }}</p>
                    <p class="text-base font-semibold text-slate-900">{{ $r->judul }}</p>
                    <p class="text-sm text-slate-600 line-clamp-2">{{ $r->deskripsi }}</p>
                    <div class="flex flex-wrap gap-2 text-xs text-slate-600">
                        @if($r->category)
                            <span class="badge-soft">{{ $r->category->nama }}</span>
                        @endif
                        <span class="badge-soft">Status: {{ ucfirst($r->status) }}</span>
                        @if($r->claimed_by)
                            <span class="badge-soft bg-blue-100 text-blue-800">Diklaim: {{ \App\Models\User::find($r->claimed_by)?->name ?? 'User' }}</span>
                        @endif
                    </div>
                </div>
                <i class='bx bx-chevron-right text-2xl text-slate-400'></i>
            </a>
        @empty
            <div class="text-center text-slate-600 py-6">Belum ada laporan.</div>
        @endforelse
    </div>

    <div>
        {{ $reports->links() }}
    </div>
</div>
@endsection
