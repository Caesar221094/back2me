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
            
            @if($report->pelapor_approval === 'pending')
            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 animate-pulse">
                <i class='bx bx-time-five'></i>Menunggu Approval Pelapor
            </span>
            @endif

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
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2"><i class='bx bx-image'></i>Galeri Foto Laporan</h3>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach($report->foto as $f)
                    <div class="overflow-hidden rounded-lg border border-slate-100 bg-slate-50">
                        <img src="{{ asset('storage/'.$f) }}" alt="Foto laporan" class="w-full h-48 object-cover">
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($report->bukti_klaim)
        <div class="card p-6 space-y-3 bg-blue-50 border border-blue-200">
            <h3 class="text-sm font-semibold text-blue-900 flex items-center gap-2"><i class='bx bx-shield-alt-2'></i>Bukti Kepemilikan (dari Pengklaim)</h3>
            @if($report->catatan_klaim)
                <div class="p-3 bg-white rounded-lg border border-blue-100">
                    <p class="text-xs text-blue-700 font-semibold mb-1">Catatan Pengklaim:</p>
                    <p class="text-sm text-slate-700">{{ $report->catatan_klaim }}</p>
                </div>
            @endif
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach($report->bukti_klaim as $bukti)
                    <div class="overflow-hidden rounded-lg border border-blue-200 bg-white">
                        <img src="{{ asset('storage/'.$bukti) }}" alt="Bukti kepemilikan" class="w-full h-48 object-cover">
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($report->pelapor_approval === 'pending' && $report->user_id === auth()->id())
        <div class="card p-6 space-y-4 bg-amber-50 border border-amber-200">
            <div class="flex items-start gap-3">
                <i class='bx bx-error text-2xl text-amber-600'></i>
                <div class="flex-1 space-y-2">
                    <h3 class="text-sm font-semibold text-amber-900">⚠️ Approval Diperlukan</h3>
                    @if($report->tipe === 'hilang')
                        <p class="text-sm text-amber-800">
                            <span class="font-semibold">{{ \App\Models\User::find($report->claimed_by)?->name }}</span> mengaku menemukan barang Anda. 
                            Silakan cocokkan foto dan catatan di atas dengan ciri-ciri barang asli sebelum menyetujui.
                        </p>
                    @else
                        <p class="text-sm text-amber-800">
                            <span class="font-semibold">{{ \App\Models\User::find($report->claimed_by)?->name }}</span> mengaku sebagai pemilik barang ini. 
                            Silakan cocokkan bukti kepemilikan di atas sebelum menyetujui.
                        </p>
                    @endif
                    <div class="flex gap-3 pt-2">
                        <form method="post" action="{{ route('back2me.reports.approve_claim', $report) }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-primary inline-flex items-center gap-2">
                                <i class='bx bx-check-circle'></i>
                                @if($report->tipe === 'hilang')
                                    Ya, Ini Penemu yang Benar
                                @else
                                    Ya, Ini Pemilik yang Benar
                                @endif
                            </button>
                        </form>
                        <form method="post" action="{{ route('back2me.reports.reject_claim', $report) }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-secondary inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white">
                                <i class='bx bx-x-circle'></i>Tolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($report->pelapor_approval === 'approved' && $report->status === 'selesai')
        <div class="card p-6 space-y-4 bg-green-50 border border-green-200">
            <div class="flex items-center gap-2 text-green-900 font-semibold text-lg">
                <i class='bx bx-check-shield text-2xl'></i>
                Klaim Disetujui!
            </div>
            <p class="text-sm text-green-800">
                Status: <span class="font-semibold">Selesai</span> (Approved: {{ $report->pelapor_approved_at?->format('d M Y H:i') }})
            </p>
            
            <div class="border-t border-green-200 pt-4 space-y-3">
                <p class="text-sm font-semibold text-green-900">📞 Kontak untuk Koordinasi:</p>
                
                @php
                    $penemu = \App\Models\User::find($report->claimed_by);
                    $pemilik = $report->user;
                @endphp
                
                @if(auth()->id() === $report->user_id)
                    {{-- Tampilkan kontak PENEMU untuk pemilik barang --}}
                    <div class="bg-white rounded-lg p-4 space-y-2">
                        <p class="text-xs text-slate-600">Hubungi Penemu:</p>
                        <p class="font-semibold text-slate-900">{{ $penemu->name }}</p>
                        @if($penemu->phone)
                            <a href="tel:{{ $penemu->phone }}" class="flex items-center gap-2 text-sm text-blue-700 hover:text-blue-900">
                                <i class='bx bxs-phone'></i>{{ $penemu->phone }}
                            </a>
                        @endif
                        @if($penemu->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $penemu->whatsapp) }}" target="_blank" class="flex items-center gap-2 text-sm text-green-700 hover:text-green-900">
                                <i class='bx bxl-whatsapp'></i>{{ $penemu->whatsapp }}
                            </a>
                        @endif
                        <a href="mailto:{{ $penemu->email }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900">
                            <i class='bx bx-envelope'></i>{{ $penemu->email }}
                        </a>
                    </div>
                @elseif(auth()->id() === $report->claimed_by)
                    {{-- Tampilkan kontak PEMILIK untuk penemu --}}
                    <div class="bg-white rounded-lg p-4 space-y-2">
                        <p class="text-xs text-slate-600">Hubungi Pemilik Barang:</p>
                        <p class="font-semibold text-slate-900">{{ $pemilik->name }}</p>
                        @if($pemilik->phone)
                            <a href="tel:{{ $pemilik->phone }}" class="flex items-center gap-2 text-sm text-blue-700 hover:text-blue-900">
                                <i class='bx bxs-phone'></i>{{ $pemilik->phone }}
                            </a>
                        @endif
                        @if($pemilik->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pemilik->whatsapp) }}" target="_blank" class="flex items-center gap-2 text-sm text-green-700 hover:text-green-900">
                                <i class='bx bxl-whatsapp'></i>{{ $pemilik->whatsapp }}
                            </a>
                        @endif
                        <a href="mailto:{{ $pemilik->email }}" class="flex items-center gap-2 text-sm text-indigo-700 hover:text-indigo-900">
                            <i class='bx bx-envelope'></i>{{ $pemilik->email }}
                        </a>
                    </div>
                @endif
                
                <p class="text-xs text-green-700 italic">
                    💡 Silakan hubungi untuk koordinasi lokasi dan waktu pengambilan barang
                </p>
            </div>
        </div>
        @endif

        @if($report->pelapor_approval === 'rejected')
        <div class="card p-6 space-y-2 bg-rose-50 border border-rose-200">
            <div class="flex items-center gap-2 text-rose-900 font-semibold">
                <i class='bx bx-x-circle text-xl'></i>
                Klaim ditolak oleh pelapor
            </div>
            <p class="text-sm text-rose-700">Rejected at: {{ $report->pelapor_approved_at?->format('d M Y H:i') }}</p>
        </div>
        @endif
    </div>

    <div class="space-y-4">
        <div class="card p-5 space-y-3">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2"><i class='bx bx-info-circle'></i>Status & Aksi</h3>
            <div class="text-sm text-slate-700 space-y-2">
                <div class="flex items-center justify-between">
                    <span>Tipe</span>
                    @if($report->tipe === 'hilang')
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                            <i class='bx bx-search'></i>Hilang
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                            <i class='bx bx-check-circle'></i>Ditemukan
                        </span>
                    @endif
                </div>
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

            @if(auth()->user()->role === 'user' && auth()->id() !== $report->user_id && !$report->claimed_by)
                <div class="space-y-3 pt-2 border-t border-slate-100">
                    @if($report->tipe === 'hilang')
                        {{-- Untuk laporan HILANG: User adalah Penemu --}}
                        <p class="text-xs text-slate-600 font-semibold">📍 Anda Menemukan Barang Ini?</p>
                        <form method="post" action="{{ route('back2me.reports.claim', $report) }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div class="space-y-1">
                                <label class="text-xs text-slate-600">Foto Barang yang Ditemukan (min 1) <span class="text-red-500">*</span></label>
                                <input type="file" name="bukti[]" multiple required accept="image/*" class="block w-full text-xs text-slate-600 file:mr-2 file:rounded file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs text-slate-600">Catatan Penemuan (min 20 karakter) <span class="text-red-500">*</span></label>
                                <textarea name="catatan_klaim" rows="3" required minlength="20" maxlength="500" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-xs" placeholder="Jelaskan di mana & kapan Anda menemukan barang ini (ciri-ciri, kondisi, dll)"></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full inline-flex items-center justify-center gap-2 text-sm">
                                <i class='bx bx-check-circle'></i>Ya, Saya Menemukan Barang Ini
                            </button>
                            <p class="text-xs text-slate-500 text-center">Bukti akan direview oleh pemilik barang</p>
                        </form>
                    @else
                        {{-- Untuk laporan DITEMUKAN: User adalah Pemilik --}}
                        <p class="text-xs text-slate-600 font-semibold">🔑 Ini Barang Anda?</p>
                        <form method="post" action="{{ route('back2me.reports.claim', $report) }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div class="space-y-1">
                                <label class="text-xs text-slate-600">Bukti Kepemilikan (min 1 foto) <span class="text-red-500">*</span></label>
                                <input type="file" name="bukti[]" multiple required accept="image/*" class="block w-full text-xs text-slate-600 file:mr-2 file:rounded file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="text-xs text-slate-500 mt-1">Contoh: KTP, struk pembelian, foto saat memiliki barang</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs text-slate-600">Jelaskan Bukti Kepemilikan (min 20 karakter) <span class="text-red-500">*</span></label>
                                <textarea name="catatan_klaim" rows="3" required minlength="20" maxlength="500" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-xs" placeholder="Jelaskan mengapa ini barang Anda (ciri-ciri unik, waktu kehilangan, bukti pembelian, dll)"></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full inline-flex items-center justify-center gap-2 text-sm">
                                <i class='bx bx-check-shield'></i>Ya, Ini Barang Saya
                            </button>
                            <p class="text-xs text-slate-500 text-center">Bukti akan direview oleh penemu</p>
                        </form>
                    @endif
                </div>
            @endif

            @if(auth()->id() === $report->user_id && $report->status === 'pending' && auth()->user()->role !== 'petugas')
                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <a href="{{ route('back2me.reports.edit', $report) }}" class="btn-secondary w-full inline-flex items-center justify-center gap-2 text-sm">
                        <i class='bx bx-edit'></i>Edit Laporan
                    </a>
                    <p class="text-xs text-slate-500 text-center">Hanya bisa edit saat status pending.</p>
                </div>
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
        <div class="card p-5 space-y-3 bg-slate-50 border-slate-200">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                <i class='bx bx-shield-alt-2'></i>Moderasi Petugas (Optional)
            </h3>
            <p class="text-xs text-slate-600">
                Gunakan untuk moderasi jika ada fraud/abuse. Status sudah otomatis berubah setelah pelapor approve.
            </p>
            <form method="post" action="{{ route('back2me.reports.verify', $report) }}" class="space-y-3">
                @csrf
                <div class="space-y-1 text-sm">
                    <label class="text-slate-700 font-semibold">Paksa ubah status</label>
                    <select name="status" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="ditolak" {{ $report->status=='ditolak'?'selected':'' }}>Ditolak (Fraud/Abuse)</option>
                        <option value="expired" {{ $report->status=='expired'?'selected':'' }}>Expired</option>
                    </select>
                </div>
                <button type="submit" class="btn-secondary w-full inline-flex items-center justify-center gap-2">
                    <i class='bx bx-save'></i>Override Status
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
