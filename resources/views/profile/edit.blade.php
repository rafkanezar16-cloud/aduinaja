@php($title = 'Profil Saya')
@php($subtitle = 'Kelola informasi akun dan kata sandi Anda')
@extends('layouts.app')

@section('content')
<div class="max-w-2xl space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
        <h3 class="font-bold text-slate-800 mb-1">Informasi Akun</h3>
        <p class="text-sm text-slate-500 mb-5">Perbarui nama, email, dan data kontak Anda.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                @if ($user->isSiswa())
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                @endif
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/30">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
        <h3 class="font-bold text-slate-800 mb-1">Ubah Kata Sandi</h3>
        <p class="text-sm text-slate-500 mb-5">Gunakan kata sandi yang kuat dan tidak dipakai di tempat lain.</p>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" required
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" required minlength="8"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/30">
                Perbarui Kata Sandi
            </button>
        </form>
    </div>
</div>
@endsection
