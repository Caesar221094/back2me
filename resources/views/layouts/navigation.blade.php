<nav x-data="{ open: false }" class="glass-nav sticky top-0 z-20">
    @php
        $role = Auth::user()->role ?? null;
    @endphp
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-sm">
                        <i class='bx bxs-package text-2xl'></i>
                    </div>
                    <div class="leading-tight">
                        <a href="{{ route('dashboard') }}" class="block text-base font-semibold text-slate-900">Back2Me</a>
                        <span class="text-xs text-slate-500">Lost & Found Console</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex text-sm">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class='bx bxs-home'></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('back2me.reports.index')" :active="request()->routeIs('back2me.reports.*')">
                        <i class='bx bxs-report'></i>
                        {{ __('Laporan') }}
                    </x-nav-link>

                    <x-nav-link :href="route('back2me.reports.create')" :active="request()->routeIs('back2me.reports.create')">
                        <i class='bx bxs-plus-circle'></i>
                        {{ __('Buat Laporan') }}
                    </x-nav-link>

                    @if(in_array($role, ['petugas','superadmin']))
                        <x-nav-link :href="route('back2me.reports.index', ['status' => 'diproses'])" :active="request()->routeIs('back2me.reports.index') && request('status') === 'diproses'">
                            <i class='bx bxs-check-shield'></i>
                            {{ __('Verifikasi') }}
                        </x-nav-link>
                    @endif

                    @if($role === 'superadmin')
                        <x-nav-link :href="route('back2me.admin.users.index')" :active="request()->routeIs('back2me.admin.users.*')">
                            <i class='bx bxs-user-detail'></i>
                            {{ __('Pengguna') }}
                        </x-nav-link>
                        <x-nav-link :href="route('back2me.admin.categories.index')" :active="request()->routeIs('back2me.admin.categories.*')">
                            <i class='bx bxs-category-alt'></i>
                            {{ __('Kategori') }}
                        </x-nav-link>
                        <x-nav-link :href="route('back2me.admin.settings.index')" :active="request()->routeIs('back2me.admin.settings.*')">
                            <i class='bx bxs-cog'></i>
                            {{ __('Pengaturan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('back2me.admin.reports.export')" :active="request()->routeIs('back2me.admin.reports.export*')">
                            <i class='bx bxs-file-export'></i>
                            {{ __('Export') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-lg text-slate-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150 shadow-sm">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 font-semibold">{{ strtoupper(Auth::user()->name[0]) }}</span>
                                <div class="text-left">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-slate-500">{{ ucfirst($role ?? 'user') }}</div>
                                </div>
                            </div>
                            <div class="ms-1">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class='bx bxs-user'></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class='bx bx-power-off'></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('back2me.reports.index')" :active="request()->routeIs('back2me.reports.*')">
                {{ __('Laporan') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('back2me.reports.create')" :active="request()->routeIs('back2me.reports.create')">
                {{ __('Buat Laporan') }}
            </x-responsive-nav-link>

            @if(in_array($role, ['petugas','superadmin']))
                <x-responsive-nav-link :href="route('back2me.reports.index', ['status' => 'diproses'])" :active="request()->routeIs('back2me.reports.index') && request('status') === 'diproses'">
                    {{ __('Verifikasi') }}
                </x-responsive-nav-link>
            @endif

            @if($role === 'superadmin')
                <x-responsive-nav-link :href="route('back2me.admin.users.index')" :active="request()->routeIs('back2me.admin.users.*')">
                    {{ __('Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('back2me.admin.categories.index')" :active="request()->routeIs('back2me.admin.categories.*')">
                    {{ __('Kategori') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('back2me.admin.settings.index')" :active="request()->routeIs('back2me.admin.settings.*')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('back2me.admin.reports.export')" :active="request()->routeIs('back2me.admin.reports.export*')">
                    {{ __('Export') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
