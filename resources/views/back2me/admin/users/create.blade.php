@extends('back2me.layout')

@section('title','Buat Pengguna')

@section('subtitle','Tambah akun baru dengan role yang sesuai')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-slate-900">Buat Pengguna</h1>
        <p class="text-sm text-slate-600">Isi identitas, email, dan role. Password awal wajib diisi.</p>
    </div>
    <a href="{{ route('back2me.admin.users.index') }}" class="btn-ghost inline-flex items-center gap-2 text-slate-700 hover:text-slate-900">
        <i class='bx bx-arrow-back'></i>Kembali
    </a>
</div>

<div class="card card-hover p-6 space-y-5 max-w-2xl">
    @if ($errors->any())
        <div class="rounded-lg border border-rose-200 bg-rose-50 p-3 text-rose-700 text-sm">
            <p class="font-semibold mb-1">Gagal menyimpan. Periksa isian berikut:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="post" action="{{ route('back2me.admin.users.store') }}" class="space-y-4">@csrf
        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Nama</label>
            <input name="name" value="{{ old('name') }}" required class="w-full rounded-lg border {{ $errors->has('name') ? 'border-rose-300 focus:border-rose-400 focus:ring-rose-500' : 'border-slate-200 focus:ring-indigo-500 focus:border-indigo-500' }}" placeholder="Nama lengkap">
            @error('name')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" inputmode="email" class="w-full rounded-lg border {{ $errors->has('email') ? 'border-rose-300 focus:border-rose-400 focus:ring-rose-500' : 'border-slate-200 focus:ring-indigo-500 focus:border-indigo-500' }}" placeholder="email@contoh.com">
            <p class="text-xs text-slate-500">Gunakan email yang unik (belum ada di tabel pengguna).</p>
            @error('email')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Role</label>
            <select name="role" class="w-full rounded-lg border {{ $errors->has('role') ? 'border-rose-300 focus:border-rose-400 focus:ring-rose-500' : 'border-slate-200 focus:ring-indigo-500 focus:border-indigo-500' }}">
                <option value="user" {{ old('role')==='user'?'selected':'' }}>User</option>
                <option value="petugas" {{ old('role')==='petugas'?'selected':'' }}>Petugas</option>
                <option value="superadmin" {{ old('role')==='superadmin'?'selected':'' }}>Superadmin</option>
            </select>
            <p class="text-xs text-slate-500">Pilih salah satu: user, petugas, superadmin.</p>
            @error('role')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Password</label>
            <input type="password" name="password" required minlength="8" autocomplete="new-password" class="w-full rounded-lg border {{ $errors->has('password') ? 'border-rose-300 focus:border-rose-400 focus:ring-rose-500' : 'border-slate-200 focus:ring-indigo-500 focus:border-indigo-500' }}" placeholder="Minimal 8 karakter (contoh: password123)">
            <p class="text-xs text-slate-500">Password minimal 8 karakter (contoh: password123).</p>
            @error('password')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2 flex items-center gap-3">
            <button type="submit" class="btn-primary inline-flex items-center gap-2">
                <i class='bx bx-user-plus'></i>Simpan Pengguna
            </button>
            <a href="{{ route('back2me.admin.users.index') }}" class="btn-secondary inline-flex items-center gap-2">
                <i class='bx bx-x-circle'></i>Batal
            </a>
        </div>
    </form>

    <div class="text-xs text-slate-500">
        <p class="mt-2">Catatan: Aturan di atas juga dijaga oleh validasi server:</p>
        <ul class="list-disc list-inside">
            <li>Email harus unik dan format valid.</li>
            <li>Role hanya: user, petugas, superadmin.</li>
            <li>Password minimal 8 karakter.</li>
        </ul>
    </div>
</div>
@endsection
