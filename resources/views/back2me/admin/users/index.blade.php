@extends('back2me.layout')

@section('title','Manajemen Pengguna')

@section('subtitle','Kelola akun, role, dan status ban')

@section('content')
<x-delete-confirmation-modal />

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-slate-900">Manajemen Pengguna</h1>
        <p class="text-sm text-slate-600">Atur role, status ban, dan reset password akun.</p>
    </div>
    <a href="{{ route('back2me.admin.users.create') }}" class="btn-primary inline-flex items-center gap-2">
        <i class='bx bx-user-plus text-lg'></i>
        Tambah Pengguna
    </a>
</div>

<div class="card card-hover p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $u)
                <tr class="hover:bg-slate-50/60">
                    <td class="px-4 py-3 font-semibold text-slate-900">#{{ $u->id }}</td>
                    <td class="px-4 py-3 text-slate-900">{{ $u->name }}</td>
                    <td class="px-4 py-3 text-slate-700">{{ $u->email }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold
                            {{ $u->role === 'superadmin' ? 'bg-amber-100 text-amber-800' : ($u->role === 'petugas' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}">
                            <i class='bx bxs-shield'></i>{{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($u->is_banned)
                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                <i class='bx bx-block'></i>Diblokir
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                <i class='bx bx-check-circle'></i>Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('back2me.admin.users.edit', $u) }}" class="btn-secondary btn-xs inline-flex items-center gap-1">
                                <i class='bx bx-edit-alt'></i>Edit
                            </a>
                            <form method="post" action="{{ route('back2me.admin.users.reset_password', $u) }}" class="inline delete-form" onsubmit="event.preventDefault(); showConfirmation(this, 'Reset Password', 'Reset password akun {{ $u->name }} ke password123?', 'reset');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700">
                                    <i class='bx bx-reset'></i>Reset PW
                                </button>
                            </form>
                            <form method="post" action="{{ route('back2me.admin.users.destroy', $u) }}" class="inline delete-form" onsubmit="event.preventDefault(); showConfirmation(this, 'Hapus Pengguna', 'Hapus akun {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700">
                                    <i class='bx bx-trash'></i>Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 border-t border-slate-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
