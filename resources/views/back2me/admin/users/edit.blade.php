@extends('back2me.layout')

@section('title','Edit Pengguna')

@section('subtitle','Perbarui identitas, role, dan status ban pengguna')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-slate-900">Edit Pengguna</h1>
        <p class="text-sm text-slate-600">Sesuaikan data akun, role, dan status blokir.</p>
    </div>
    <a href="{{ route('back2me.admin.users.index') }}" class="btn-ghost inline-flex items-center gap-2 text-slate-700 hover:text-slate-900">
        <i class='bx bx-arrow-back'></i>Kembali
    </a>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="card card-hover p-6 lg:col-span-2 space-y-5">
        <form method="post" action="{{ route('back2me.admin.users.update', $user) }}" class="space-y-5">@csrf @method('put')
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Nama</label>
                <input name="name" value="{{ $user->name }}" required class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Role</label>
                <select name="role" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="user" {{ $user->role=='user'?'selected':'' }}>User</option>
                    <option value="petugas" {{ $user->role=='petugas'?'selected':'' }}>Petugas</option>
                    <option value="superadmin" {{ $user->role=='superadmin'?'selected':'' }}>Superadmin</option>
                </select>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_banned" value="1" id="is_banned" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500" {{ $user->is_banned ? 'checked' : '' }}>
                <label for="is_banned" class="text-sm font-semibold text-slate-700">Blokir pengguna ini</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary inline-flex items-center gap-2">
                    <i class='bx bx-save'></i>Simpan Perubahan
                </button>
                <a href="{{ route('back2me.admin.users.index') }}" class="btn-secondary inline-flex items-center gap-2">
                    <i class='bx bx-x-circle'></i>Batal
                </a>
            </div>
        </form>
    </div>

    <div class="card p-6 space-y-3">
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl font-semibold">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <div>
                <p class="text-sm text-slate-600">ID #{{ $user->id }}</p>
                <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                <p class="text-sm text-slate-600">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold
                {{ $user->role === 'superadmin' ? 'bg-amber-100 text-amber-800' : ($user->role === 'petugas' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}">
                <i class='bx bxs-shield'></i>{{ ucfirst($user->role) }}
            </span>
            @if($user->is_banned)
                <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                    <i class='bx bx-block'></i>Diblokir
                </span>
            @else
                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <i class='bx bx-check-circle'></i>Aktif
                </span>
            @endif
        </div>
        <p class="text-xs text-slate-500">Gunakan kotak centang untuk memblokir atau aktifkan kembali akun.</p>
    </div>
</div>
@endsection
