@php
    $role = Auth::user()->role ?? null;
@endphp

<!-- Menu -->
<aside 
    id="layout-menu" 
    class="layout-menu menu-vertical menu bg-menu-theme"
    :class="sidebarOpen ? '' : 'closed'"
>
    <!-- App Brand -->
    <div class="app-brand demo px-4 py-5">
        <a href="{{ route('dashboard') }}" class="app-brand-link flex items-center gap-3">
            <span class="app-brand-logo demo">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-lg">
                    <i class='bx bxs-package text-2xl'></i>
                </div>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                <div class="leading-tight">
                    <div class="text-base font-semibold text-slate-900">Back2Me</div>
                    <div class="text-xs text-slate-500">Lost & Found</div>
                </div>
            </span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <!-- Menu Items -->
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Laporan Section -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Laporan</span>
        </li>

        <li class="menu-item {{ request()->routeIs('back2me.reports.index') && !request('status') ? 'active' : '' }}">
            <a href="{{ route('back2me.reports.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div>Semua Laporan</div>
            </a>
        </li>

        @if($role !== 'petugas')
            <li class="menu-item {{ request()->routeIs('back2me.reports.create') ? 'active' : '' }}">
                <a href="{{ route('back2me.reports.create') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-plus-circle"></i>
                    <div>Buat Laporan</div>
                </a>
            </li>
        @endif

        @if(in_array($role, ['petugas','superadmin']))
            <li class="menu-item {{ request()->routeIs('back2me.reports.index') && request('status') === 'diproses' ? 'active' : '' }}">
                <a href="{{ route('back2me.reports.index', ['status' => 'diproses']) }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-check-shield"></i>
                    <div>Verifikasi</div>
                    @php
                        $pendingCount = \App\Models\Report::where('status', 'diproses')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
        @endif

        @if($role === 'superadmin')
            <!-- Admin Section -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Admin</span>
            </li>

            <li class="menu-item {{ request()->routeIs('back2me.admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('back2me.admin.users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                    <div>Pengguna</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('back2me.admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('back2me.admin.categories.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-category-alt"></i>
                    <div>Kategori</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('back2me.admin.settings.*') ? 'active' : '' }}">
                <a href="{{ route('back2me.admin.settings.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-cog"></i>
                    <div>Pengaturan</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('back2me.admin.reports.export*') ? 'active' : '' }}">
                <a href="{{ route('back2me.admin.reports.export') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-file-export"></i>
                    <div>Export Laporan</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
