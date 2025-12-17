@php
    $user = auth()->user();
    $role = $user->role ?? 'user';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <span class="badge-soft">Role: {{ ucfirst($role) }}</span>
                <span class="badge-soft">Welcome back, {{ $user->name }}</span>
            </div>
            <h2 class="text-2xl font-semibold text-slate-900">Back2Me Dashboard</h2>
            <p class="text-sm text-slate-600">Rangkuman cepat laporan, klaim, dan tindakan yang perlu kamu cek.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="card card-hover p-4">
                    <p class="text-sm text-slate-500">Total Laporan</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                        <span class="text-indigo-600 text-sm font-semibold">Semua</span>
                    </div>
                </div>
                <div class="card card-hover p-4">
                    <p class="text-sm text-slate-500">Pending</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-amber-700">{{ $stats['pending'] }}</p>
                        <span class="text-amber-700 text-sm font-semibold">Menunggu</span>
                    </div>
                </div>
                <div class="card card-hover p-4">
                    <p class="text-sm text-slate-500">Diproses</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['diproses'] }}</p>
                        <span class="text-blue-700 text-sm font-semibold">On progress</span>
                    </div>
                </div>
                <div class="card card-hover p-4">
                    <p class="text-sm text-slate-500">Selesai</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-emerald-700">{{ $stats['selesai'] }}</p>
                        <span class="text-emerald-700 text-sm font-semibold">Closed</span>
                    </div>
                </div>
                <div class="card card-hover p-4">
                    <p class="text-sm text-slate-500">Ditolak</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-rose-700">{{ $stats['ditolak'] }}</p>
                        <span class="text-rose-700 text-sm font-semibold">Rejected</span>
                    </div>
                </div>
                <div class="card card-hover p-4">
                    <p class="text-sm text-slate-500">Sudah Diklaim</p>
                    <div class="flex items-end justify-between">
                        <p class="text-2xl font-bold text-blue-800">{{ $stats['claimed'] }}</p>
                        <span class="text-blue-800 text-sm font-semibold">Claimed</span>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="card card-hover p-6 lg:col-span-2 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Aktivitas Terbaru</h3>
                            <p class="text-sm text-slate-600">5 laporan terakhir masuk sistem.</p>
                        </div>
                        <a class="btn-primary" href="{{ route('back2me.reports.create') }}"><i class='bx bx-plus-circle'></i> Buat laporan</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($recentReports as $r)
                            <div class="py-3 flex items-start justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span>ID #{{ $r->id }}</span>
                                        <span>·</span>
                                        <span>{{ $r->created_at?->format('d M Y H:i') }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $r->judul }}</p>
                                    <div class="flex flex-wrap items-center gap-2 text-xs">
                                        <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 font-semibold
                                            @if($r->status === 'pending') bg-amber-100 text-amber-800
                                            @elseif($r->status === 'diproses') bg-blue-100 text-blue-800
                                            @elseif($r->status === 'selesai') bg-emerald-100 text-emerald-800
                                            @else bg-rose-100 text-rose-700 @endif">
                                            <i class='bx bxs-circle-three-quarter'></i>{{ ucfirst($r->status) }}</span>
                                        @if($r->category)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-700">
                                                <i class='bx bx-folder'></i>{{ $r->category->nama }}
                                            </span>
                                        @endif
                                        <span class="text-slate-500">oleh {{ $r->user->name ?? 'User' }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('back2me.reports.show', $r) }}" class="btn-ghost btn-xs">Lihat</a>
                            </div>
                        @empty
                            <p class="py-4 text-sm text-slate-600 text-center">Belum ada laporan.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card card-hover p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900">Aksi Cepat</h3>
                    <div class="grid gap-3">
                        <a href="{{ route('back2me.reports.index') }}" class="btn-secondary w-full justify-between">
                            <span>Lihat semua laporan</span>
                            <i class='bx bx-right-arrow-alt'></i>
                        </a>
                        <a href="{{ route('back2me.reports.index', ['status' => 'pending']) }}" class="btn-ghost w-full justify-between">
                            <span>Pending ({{ $stats['pending'] }})</span>
                            <i class='bx bx-time-five'></i>
                        </a>
                        <a href="{{ route('back2me.reports.index', ['status' => 'diproses']) }}" class="btn-ghost w-full justify-between">
                            <span>Diproses ({{ $stats['diproses'] }})</span>
                            <i class='bx bx-loader-circle'></i>
                        </a>
                        <a href="{{ route('back2me.reports.index', ['status' => 'selesai']) }}" class="btn-ghost w-full justify-between">
                            <span>Selesai ({{ $stats['selesai'] }})</span>
                            <i class='bx bx-badge-check'></i>
                        </a>
                        @if($role === 'superadmin')
                            <a href="{{ route('back2me.admin.users.index') }}" class="btn-ghost w-full justify-between">
                                <span>Kelola Pengguna</span>
                                <i class='bx bx-user'></i>
                            </a>
                            <a href="{{ route('back2me.admin.categories.index') }}" class="btn-ghost w-full justify-between">
                                <span>Kelola Kategori</span>
                                <i class='bx bx-category-alt'></i>
                            </a>
                            <a href="{{ route('back2me.admin.settings.index') }}" class="btn-ghost w-full justify-between">
                                <span>Pengaturan Sistem</span>
                                <i class='bx bx-cog'></i>
                            </a>
                            <a href="{{ route('back2me.admin.reports.export') }}" class="btn-ghost w-full justify-between">
                                <span>Export Laporan</span>
                                <i class='bx bx-download'></i>
                            </a>
                        @elseif($role === 'petugas')
                            <a href="{{ route('back2me.reports.index', ['status' => 'diproses']) }}" class="btn-ghost w-full justify-between">
                                <span>Verifikasi Klaim</span>
                                <i class='bx bx-shield-quarter'></i>
                            </a>
                        @else
                            <a href="{{ route('back2me.reports.create') }}" class="btn-primary w-full justify-between">
                                <span>Buat Laporan</span>
                                <i class='bx bx-plus-circle'></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
