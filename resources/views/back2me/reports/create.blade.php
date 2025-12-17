@extends('back2me.layout')

@section('title','Buat Laporan')

@section('subtitle','Isi detail laporan barang hilang/ditemukan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-semibold text-slate-900">Buat Laporan</h1>
        <p class="text-sm text-slate-600">Tambahkan informasi jelas agar petugas dan pelapor lain dapat memverifikasi lebih cepat.</p>
    </div>
    <a href="{{ route('back2me.reports.index') }}" class="btn-ghost inline-flex items-center gap-2 text-slate-700 hover:text-slate-900">
        <i class='bx bx-arrow-back'></i>Kembali ke daftar
    </a>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">
        <div class="card card-hover p-6 space-y-5">
            <form method="post" action="{{ route('back2me.reports.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Judul Laporan</label>
                    <input name="judul" value="{{ old('judul') }}" required class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Dompet coklat hilang di parkiran kampus">
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Kategori</label>
                        <select name="category_id" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Lokasi</label>
                        <input name="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Misal: Perpustakaan lantai 2">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full rounded-lg border-slate-200 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jelaskan ciri-ciri, waktu, dan detail penting lainnya">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Foto (opsional)</label>
                    <input type="file" name="foto[]" multiple accept="image/*" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-slate-500">Maks 5 file, 5MB per foto. Unggah bukti yang jelas.</p>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="btn-primary inline-flex items-center gap-2">
                        <i class='bx bx-send'></i>Kirim Laporan
                    </button>
                    <a href="{{ route('back2me.reports.index') }}" class="btn-secondary inline-flex items-center gap-2">
                        <i class='bx bx-x-circle'></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-4">
        <div class="card p-5 space-y-3">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2"><i class='bx bx-bulb'></i>Tips laporan jelas</h3>
            <ul class="text-sm text-slate-600 space-y-2 list-disc list-inside">
                <li>Gunakan judul singkat dan spesifik.</li>
                <li>Sertakan ciri unik (warna, merek, stiker).</li>
                <li>Tulis lokasi dan waktu selengkap mungkin.</li>
                <li>Unggah foto terang dan fokus.</li>
            </ul>
        </div>
        <div class="card p-5 space-y-2 text-sm text-slate-600">
            <div class="flex items-center gap-2 text-slate-900 font-semibold"><i class='bx bx-info-circle'></i>Aturan unggahan</div>
            <p>Maks 5 foto, ukuran masing-masing 5MB. Format gambar umum (JPG/PNG/WebP) disarankan.</p>
        </div>
    </div>
</div>
@endsection
