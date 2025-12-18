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
        @if(auth()->user()->role !== 'petugas')
            <a href="{{ route('back2me.reports.create') }}" class="btn-primary">
                <i class='bx bxs-plus-circle'></i> Buat Laporan
            </a>
        @endif
    </div>

    <form method="get" class="grid gap-3 md:grid-cols-5 bg-indigo-50/60 border border-indigo-100 rounded-xl p-4">
        <div class="md:col-span-2">
            <label class="text-xs font-semibold text-slate-600">Kata kunci</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau deskripsi" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="text-xs font-semibold text-slate-600">Tipe</label>
            <select name="tipe" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua</option>
                <option value="hilang" {{ request('tipe')=='hilang'?'selected':'' }}>Hilang</option>
                <option value="ditemukan" {{ request('tipe')=='ditemukan'?'selected':'' }}>Ditemukan</option>
            </select>
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
        <div class="md:col-span-5 flex gap-3">
            <button class="btn-primary" type="submit"><i class='bx bx-search'></i> Filter</button>
            <a href="{{ route('back2me.reports.index') }}" class="btn-ghost">Reset</a>
        </div>
    </form>

    <div class="grid gap-3">
        @forelse($reports as $r)
            <a href="{{ route('back2me.reports.show', $r) }}" class="card card-hover p-5 block">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 space-y-3">
                        <!-- Header with ID, Type, Status -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">#{{ $r->id }}</p>
                            @if($r->tipe === 'hilang')
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">
                                    <i class='bx bx-search'></i>Hilang
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">
                                    <i class='bx bx-check-circle'></i>Ditemukan
                                </span>
                            @endif
                            
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold
                                @if($r->status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                                @elseif($r->status === 'diproses') bg-blue-50 text-blue-700 border border-blue-200
                                @elseif($r->status === 'selesai') bg-emerald-50 text-emerald-700 border border-emerald-200
                                @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                {{ ucfirst($r->status) }}
                            </span>
                        </div>
                        
                        <!-- Title & Description -->
                        <div class="space-y-1">
                            <p class="text-base font-semibold text-slate-900">{{ $r->judul }}</p>
                            <p class="text-sm text-slate-600 line-clamp-2">{{ $r->deskripsi }}</p>
                        </div>
                        
                        <!-- People Info & Category -->
                        <div class="flex flex-wrap gap-3 text-xs">
                            <!-- Pelapor (siapa yang buat laporan) -->
                            <div class="flex items-center gap-1.5 text-slate-600">
                                <i class='bx bxs-user-circle text-base text-indigo-600'></i>
                                <span class="font-medium">
                                    @if($r->tipe === 'hilang')
                                        Pemilik:
                                    @else
                                        Penemu:
                                    @endif
                                </span>
                                <span class="font-semibold text-slate-800">{{ $r->user->name }}</span>
                            </div>
                            
                            <!-- Responden (siapa yang merespon/klaim) -->
                            @if($r->claimed_by)
                                @php
                                    $responden = \App\Models\User::find($r->claimed_by);
                                @endphp
                                <div class="flex items-center gap-1.5 text-blue-700">
                                    <i class='bx bxs-hand text-base'></i>
                                    <span class="font-medium">
                                        @if($r->tipe === 'hilang')
                                            Penemu:
                                        @else
                                            Pemilik:
                                        @endif
                                    </span>
                                    <span class="font-semibold">{{ $responden?->name ?? 'User' }}</span>
                                </div>
                            @endif
                            
                            <!-- Category -->
                            @if($r->category)
                                <div class="flex items-center gap-1.5 text-slate-600">
                                    <i class='bx bx-folder text-base text-slate-500'></i>
                                    <span>{{ $r->category->nama }}</span>
                                </div>
                            @endif
                            
                            <!-- Location -->
                            @if($r->lokasi)
                                <div class="flex items-center gap-1.5 text-slate-600">
                                    <i class='bx bx-map text-base text-slate-500'></i>
                                    <span>{{ Str::limit($r->lokasi, 30) }}</span>
                                </div>
                            @endif
                            
                            <!-- Created Time -->
                            <div class="flex items-center gap-1.5 text-slate-500">
                                <i class='bx bx-time-five text-base'></i>
                                <span>{{ $r->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Arrow Icon -->
                    <i class='bx bx-chevron-right text-2xl text-slate-400 flex-shrink-0'></i>
                </div>
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
