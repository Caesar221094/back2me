@extends('back2me.layout')

@section('title','Lihat Laporan')

@section('subtitle','Detail laporan dan status klaim')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="space-y-1">
        <p class="text-xs text-slate-500">ID #{{ $report->id }}</p>
        <h1 class="text-xl font-semibold text-slate-900">{{ $report->judul }}</h1>
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold
                @if($report->status === 'pending') bg-amber-100 text-amber-800
                @elseif($report->status === 'diproses') bg-blue-100 text-blue-800
                @elseif($report->status === 'selesai') bg-emerald-100 text-emerald-800
                @else bg-rose-100 text-rose-700 @endif">
                <i class='bx bxs-circle-three-quarter'></i>{{ ucfirst($report->status) }}</span>
            @if($report->category)
            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                <i class='bx bx-folder'></i>{{ $report->category->nama }}
            </span>
            @endif
        </div>
    </div>
    <a href="{{ route('back2me.reports.index') }}" class="btn-ghost inline-flex items-center gap-2 text-slate-700 hover:text-slate-900">
        <i class='bx bx-arrow-back'></i>Kembali
    </a>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-4">
        <div class="card card-hover p-6 space-y-4">
            <div class="grid gap-4 md:grid-cols-2 text-sm text-slate-700">
                <div class="space-y-1">
                    <p class="text-slate-500">Pelapor</p>
                    <p class="font-semibold text-slate-900">{{ $report->user->name ?? 'Tidak diketahui' }}</p>
                    <p class="text-xs text-slate-500">{{ $report->created_at?->format('d M Y H:i') }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-slate-500">Lokasi</p>
                    <p class="font-semibold text-slate-900">{{ $report->lokasi ?? '-' }}</p>
                </div>
            </div>
            <div class="space-y-2">
                <p class="text-slate-500 text-sm">Deskripsi</p>
                <p class="text-slate-800 leading-relaxed whitespace-pre-line">{{ $report->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        @if($report->foto)
        <div class="card p-6 space-y-3">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2"><i class='bx bx-image'></i>Galeri Foto</h3>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach($report->foto as $f)
                    <div class="overflow-hidden rounded-lg border border-slate-100 bg-slate-50">
                        <img src="{{ asset('storage/'.$f) }}" alt="Foto laporan" class="w-full h-48 object-cover">
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-4">
        <div class="card p-5 space-y-3">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2"><i class='bx bx-info-circle'></i>Status & Aksi</h3>
            <div class="text-sm text-slate-700 space-y-2">
                <div class="flex items-center justify-between">
                    <span>Status klaim</span>
                    @if($report->claimed_by)
                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                            <i class='bx bx-user-check'></i>Sudah diklaim
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            <i class='bx bx-time'></i>Belum diklaim
                        </span>
                    @endif
                </div>
                @if($report->claimed_by)
                    <p class="text-xs text-slate-500">Pengklaim: {{ \App\Models\User::find($report->claimed_by)?->name ?? 'Tidak diketahui' }} @if($report->claimed_at) · {{ $report->claimed_at->format('d M Y H:i') }} @endif</p>
                @endif
            </div>

            @if(auth()->id() !== $report->user_id && !$report->claimed_by)
                <form method="post" action="{{ route('back2me.reports.claim', $report) }}" class="space-y-2">
                    @csrf
                    <button type="submit" class="btn-primary w-full inline-flex items-center justify-center gap-2">
                        <i class='bx bx-hand'></i>Klaim barang ini
                    </button>
                    <p class="text-xs text-slate-500 text-center">Dengan mengklaim, laporan akan berstatus diproses oleh petugas.</p>
                </form>
            @endif

            @if($report->status === 'selesai' && $report->claimed_by === auth()->id() && ! $report->confirmed_at)
                <form method="post" action="{{ route('back2me.reports.confirm', $report) }}" class="space-y-2">
                    @csrf
                    <button type="submit" class="btn-secondary w-full inline-flex items-center justify-center gap-2">
                        <i class='bx bx-check-shield'></i>Konfirmasi barang diterima
                    </button>
                    <p class="text-xs text-slate-500 text-center">Konfirmasi untuk menutup proses klaim.</p>
                </form>
            @endif
        </div>

        @if(in_array(auth()->user()->role, ['petugas','superadmin']))
        <div class="card p-5 space-y-3">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2"><i class='bx bx-slider-alt'></i>Verifikasi Petugas</h3>
            <form method="post" action="{{ route('back2me.reports.verify', $report) }}" class="space-y-3">
                @csrf
                <div class="space-y-1 text-sm">
                    <label class="text-slate-700 font-semibold">Status laporan</label>
                    <select name="status" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="diproses" {{ $report->status=='diproses'?'selected':'' }}>Diproses</option>
                        <option value="selesai" {{ $report->status=='selesai'?'selected':'' }}>Selesai</option>
                        <option value="ditolak" {{ $report->status=='ditolak'?'selected':'' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full inline-flex items-center justify-center gap-2">
                    <i class='bx bx-save'></i>Perbarui Status
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
