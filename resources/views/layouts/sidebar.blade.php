@php
    $role = Auth::user()->role ?? null;
@endphp

<!-- Sidebar -->
<aside 
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-200 shadow-lg overflow-y-auto transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <!-- Logo/Brand -->
    <div class="sticky top-0 bg-white z-10 px-6 py-5 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-lg">
                <i class='bx bxs-package text-2xl'></i>
            </div>
            <div class="leading-tight">
                <a href="{{ route('dashboard') }}" class="block text-base font-semibold text-slate-900">Back2Me</a>
                <span class="text-xs text-slate-500">Lost & Found Console</span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="px-3 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class='bx bxs-dashboard text-lg'></i>
            <span>Dashboard</span>
        </a>

        <!-- Laporan Section -->
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan</p>
        </div>

        <a href="{{ route('back2me.reports.index') }}" class="sidebar-link {{ request()->routeIs('back2me.reports.index') ? 'active' : '' }}">
            <i class='bx bxs-report text-lg'></i>
            <span>Semua Laporan</span>
        </a>

        <a href="{{ route('back2me.reports.create') }}" class="sidebar-link {{ request()->routeIs('back2me.reports.create') ? 'active' : '' }}">
            <i class='bx bxs-plus-circle text-lg'></i>
            <span>Buat Laporan</span>
        </a>

        @if(in_array($role, ['petugas','superadmin']))
            <a href="{{ route('back2me.reports.index', ['status' => 'diproses']) }}" class="sidebar-link {{ request()->routeIs('back2me.reports.index') && request('status') === 'diproses' ? 'active' : '' }}">
                <i class='bx bxs-check-shield text-lg'></i>
                <span>Verifikasi</span>
                @php
                    $pendingCount = \App\Models\Report::where('status', 'diproses')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center h-5 w-5 text-xs font-semibold text-white bg-red-500 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>
        @endif

        @if($role === 'superadmin')
            <!-- Admin Section -->
            <div class="pt-4 pb-2">
                <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin</p>
            </div>

            <a href="{{ route('back2me.admin.users.index') }}" class="sidebar-link {{ request()->routeIs('back2me.admin.users.*') ? 'active' : '' }}">
                <i class='bx bxs-user-detail text-lg'></i>
                <span>Pengguna</span>
            </a>

            <a href="{{ route('back2me.admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('back2me.admin.categories.*') ? 'active' : '' }}">
                <i class='bx bxs-category-alt text-lg'></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('back2me.admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('back2me.admin.settings.*') ? 'active' : '' }}">
                <i class='bx bxs-cog text-lg'></i>
                <span>Pengaturan</span>
            </a>

            <a href="{{ route('back2me.admin.reports.export') }}" class="sidebar-link {{ request()->routeIs('back2me.admin.reports.export*') ? 'active' : '' }}">
                <i class='bx bxs-file-export text-lg'></i>
                <span>Export Laporan</span>
            </a>
        @endif
    </nav>

    <!-- Footer Info -->
    <div class="absolute bottom-0 left-0 right-0 px-6 py-4 border-t border-slate-100 bg-slate-50">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <i class='bx bx-info-circle'></i>
            <span>v1.0.0 - {{ ucfirst($role ?? 'User') }} Mode</span>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-20 lg:hidden"
></div>

<style>
.sidebar-link {
    @apply flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-700 rounded-lg transition-all duration-150 ease-in-out hover:bg-indigo-50 hover:text-indigo-700;
}
.sidebar-link.active {
    @apply bg-indigo-100 text-indigo-700 shadow-sm;
}
</style>
