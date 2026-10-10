@php($title = 'Tambah Pengguna')
@extends('layouts.app')

@section('content')
<div class="max-w-lg bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
    <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role</label>
                <select name="role" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="siswa" @selected(old('role') === 'siswa')>Siswa</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">NIS / NIP</label>
                <input type="text" name="nis_nip" value="{{ old('nis_nip') }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kelas (opsional)</label>
                <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="XII RPL A"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP (opsional)</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
            <input type="password" name="password" required minlength="8"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <p class="text-xs text-slate-400 mt-1">Minimal 8 karakter.</p>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.user.index') }}" class="flex-1 text-center border border-slate-200 text-slate-600 font-semibold py-2.5 rounded-xl hover:bg-slate-50">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl shadow-lg shadow-blue-600/30">Simpan</button>
        </div>
    </form>
</div>
@endsection
