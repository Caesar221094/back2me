@extends('back2me.layout')

@section('title','Kategori Barang')
@section('subtitle','Kelola kategori untuk klasifikasi laporan')

@section('content')
<x-delete-confirmation-modal />

<div class="card card-hover p-6 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Daftar Kategori</h3>
            <p class="text-sm text-slate-600">Tambah, ubah, atau hapus kategori.</p>
        </div>
        <a class="btn-primary" href="{{ route('back2me.admin.categories.create') }}">
            <i class='bx bxs-plus-circle'></i> Tambah Kategori
        </a>
    </div>

    <div class="overflow-hidden border border-slate-200 rounded-xl bg-white">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold text-slate-600">Deskripsi</th>
                    <th class="px-4 py-3 text-right font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-indigo-50/40">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $category->nama }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $category->deskripsi ?? '-' }}</td>
                        <td class="px-4 py-3 text-right flex justify-end gap-2">
                            <a href="{{ route('back2me.admin.categories.edit', $category) }}" class="btn-ghost">
                                <i class='bx bxs-edit-alt'></i> Edit
                            </a>
                            <form action="{{ route('back2me.admin.categories.destroy', $category) }}" method="POST" class="inline delete-form" onsubmit="event.preventDefault(); showConfirmation(this, 'Hapus Kategori', 'Hapus kategori {{ $category->nama }}? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700">
                                    <i class='bx bx-trash'></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-slate-600">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $categories->links() }}
    </div>
</div>
@endsection
