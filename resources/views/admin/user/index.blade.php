@php($title = 'Master Data')
@php($subtitle = 'Kelola kategori kerusakan, lokasi, dan data pengguna')
@extends('layouts.app')

@section('content')
@include('admin.partials.master-tabs', ['active' => 'user'])

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <h3 class="font-bold text-slate-800">Data Pengguna</h3>
        <div class="flex items-center gap-2">
            <form method="GET">
                <select name="role" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua role</option>
                    <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                    <option value="siswa" @selected(request('role') === 'siswa')>Siswa</option>
                </select>
            </form>
            <a href="{{ route('admin.user.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white text-sm font-semibold px-4 py-2 rounded-xl whitespace-nowrap">
                <x-icon name="plus" class="w-4 h-4" /> Tambah Pengguna
            </a>
        </div>
    </div>

    @if ($users->isEmpty())
        <div class="px-6 py-14 text-center text-slate-400 text-sm">Belum ada data pengguna.</div>
    @else
        <div class="overflow-x-auto"><table class="w-full text-sm min-w-[640px]">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left font-medium px-6 py-3">Nama</th>
                    <th class="text-left font-medium px-6 py-3">NIS / NIP</th>
                    <th class="text-left font-medium px-6 py-3">Email</th>
                    <th class="text-left font-medium px-6 py-3">Role</th>
                    <th class="text-right font-medium px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->nis_nip ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $user->isAdmin() ? 'Admin' : 'Siswa' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.user.edit', $user) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Ubah</a>
                                <form method="POST" action="{{ route('admin.user.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 text-xs font-semibold hover:bg-red-50">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table></div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
