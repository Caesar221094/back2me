<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="badge-soft w-fit">Back2Me</p>
            <h2 class="text-2xl font-semibold text-slate-900">@yield('title')</h2>
            @hasSection('subtitle')
                <p class="text-sm text-slate-600">@yield('subtitle')</p>
            @endif
        </div>
    </x-slot>

    <div class="space-y-4">
        @if(session('success')) <div class="card p-4 text-sm text-green-700 bg-green-50 border border-green-200">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="card p-4 text-sm text-red-700 bg-red-50 border border-red-200">{{ session('error') }}</div> @endif

        @yield('content')
    </div>
</x-app-layout>
