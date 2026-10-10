@php($title = 'Master Data')
@php($subtitle = 'Kelola kategori kerusakan, lokasi, dan data pengguna')
@extends('layouts.app')

@section('content')
@include('admin.partials.master-tabs', ['active' => 'kategori'])

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800">Kategori Kerusakan</h3>
        <a href="{{ route('admin.kategori.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white text-sm font-semibold px-4 py-2 rounded-xl">
            <x-icon name="plus" class="w-4 h-4" /> Tambah Kategori
        </a>
    </div>

    @if ($kategoris->isEmpty())
        <div class="px-6 py-14 text-center text-slate-400 text-sm">Belum ada kategori kerusakan.</div>
    @else
        <div class="overflow-x-auto"><table class="w-full text-sm min-w-[640px]">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left font-medium px-6 py-3 w-16">No</th>
                    <th class="text-left font-medium px-6 py-3">Nama Kategori</th>
                    <th class="text-left font-medium px-6 py-3">Jumlah Pengaduan</th>
                    <th class="text-right font-medium px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($kategoris as $i => $kategori)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-slate-500">{{ $kategoris->firstItem() + $i }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $kategori->nama }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $kategori->pengaduans_count }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.kategori.edit', $kategori) }}" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50">Ubah</a>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
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
            {{ $kategoris->links() }}
        </div>
    @endif
</div>
@endsection
