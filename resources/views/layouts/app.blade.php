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
    <body class="font-sans antialiased bg-slate-50" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col lg:ml-64">
                <!-- Top Header Bar -->
                <header class="sticky top-0 z-10 bg-white border-b border-slate-200 shadow-sm">
                    <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                        <!-- Toggle Button (Mobile Only) -->
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 lg:hidden">
                            <i class='bx bx-menu text-2xl'></i>
                        </button>

                        <!-- Page Heading -->
                        @isset($header)
                            <div class="flex-1 lg:ml-0">
                                {{ $header }}
                            </div>
                        @endisset

                        <!-- User Dropdown -->
                        <div class="flex items-center ml-4">
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
                </header>

                <!-- Page Content -->
                <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 overflow-y-auto max-w-full">
                    <div class="max-w-7xl mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
