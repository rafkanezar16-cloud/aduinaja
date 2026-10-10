@php($title = 'Ubah Lokasi')
@extends('layouts.app')

@section('content')
<div class="max-w-md bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
    <form method="POST" action="{{ route('admin.lokasi.update', $lokasi) }}" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lokasi / Ruangan</label>
            <input type="text" name="nama" value="{{ old('nama', $lokasi->nama) }}" required autofocus
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gedung (opsional)</label>
            <input type="text" name="gedung" value="{{ old('gedung', $lokasi->gedung) }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.lokasi.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 font-semibold py-2.5 rounded-xl hover:bg-slate-50">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-lg shadow-blue-600/30">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
