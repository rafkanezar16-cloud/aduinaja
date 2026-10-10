@php($title = 'Tambah Kategori')
@extends('layouts.app')

@section('content')
<div class="max-w-md bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
    <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Kategori</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required autofocus placeholder="mis. Elektronik, Meja & Kursi, Bangunan"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.kategori.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 font-semibold py-2.5 rounded-xl hover:bg-slate-50">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-lg shadow-blue-600/30">Simpan</button>
        </div>
    </form>
</div>
@endsection
