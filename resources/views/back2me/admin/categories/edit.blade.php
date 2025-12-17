@extends('back2me.layout')

@section('title','Edit Kategori')
@section('subtitle','Perbarui nama atau deskripsi kategori')

@section('content')
<div class="card card-hover p-6 space-y-6">
    <h3 class="text-lg font-semibold text-slate-900">Edit Kategori</h3>
    <form method="POST" action="{{ route('back2me.admin.categories.update', $category) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="text-sm font-semibold text-slate-700">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $category->nama) }}" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('nama')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Deskripsi (opsional)</label>
            <textarea name="deskripsi" rows="3" class="mt-1 w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $category->deskripsi) }}</textarea>
            @error('deskripsi')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3">
            <button class="btn-primary" type="submit"><i class='bx bxs-save'></i> Simpan</button>
            <a href="{{ route('back2me.admin.categories.index') }}" class="btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection
