<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons (Boxicons for Sneat-like feel) -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50" x-data="{ sidebarOpen: true }">
        <!-- Layout Wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Sidebar -->
                @include('layouts.sidebar')

                <!-- Layout Content -->
                <div class="layout-page">
                    <!-- Navbar / Header -->
                    <nav class="layout-navbar bg-white border-b border-slate-200">
                        <div class="flex items-center justify-between w-full px-4 py-3">
                            <!-- Toggle Sidebar (Mobile) -->
                            <button @click="sidebarOpen = !sidebarOpen" class="xl:hidden text-slate-700 hover:text-indigo-600">
                                <i class='bx bx-menu text-2xl'></i>
                            </button>

                            <!-- Page Header -->
                            @isset($header)
                                <div class="flex-1 ml-4">
                                    {{ $header }}
                                </div>
                            @endisset

                            <!-- User Dropdown -->
                            <div class="ml-auto">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-lg text-slate-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150 shadow-sm">
                                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 font-semibold">{{ strtoupper(Auth::user()->name[0]) }}</span>
                                                    <div class="text-left hidden sm:block">
                                                        <div>{{ Auth::user()->name }}</div>
                                                        <div class="text-xs text-slate-500">{{ ucfirst(Auth::user()->role ?? 'user') }}</div>
                                                    </div>
                                                    <i class='bx bx-chevron-down'></i>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('profile.edit')">
                                                    <i class='bx bxs-user'></i> {{ __('Profile') }}
                                                </x-dropdown-link>

                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('logout')"
                                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                                        <i class='bx bx-power-off'></i> {{ __('Log Out') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </nav>

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        @if(isset($slot))
                            <div class="container-xxl flex-grow-1 container-p-y">
                                {{ $slot }}
                            </div>
                        @else
                            @yield('content')
                        @endif

                        <!-- Footer (optional) -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    © {{ date('Y') }} Back2Me. All rights reserved.
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>

            <!-- Overlay -->
            <div 
                x-show="sidebarOpen" 
                @click="sidebarOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="layout-overlay layout-menu-toggle d-xl-none"
            ></div>
        </div>
    </body>
</html>
