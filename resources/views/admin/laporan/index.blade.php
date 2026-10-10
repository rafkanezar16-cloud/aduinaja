@php($title = 'Laporan')
@php($subtitle = 'Rekapitulasi data pengaduan sarana sekolah')
@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h3 class="font-bold text-slate-800">Rekap Pengaduan</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.laporan.print', request()->query()) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50">
                    <x-icon name="print" class="w-4 h-4" /> Print / PDF
                </a>
                <a href="{{ route('admin.laporan.export', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">
                    <x-icon name="download" class="w-4 h-4" /> Export Excel (CSV)
                </a>
            </div>
        </div>

        <form method="GET" class="flex flex-wrap gap-2 items-end">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Dari tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Sampai tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                <select name="status" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua</option>
                    @foreach (['diajukan' => 'Diajukan', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Kategori</label>
                <select name="kategori_kerusakan_id" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Semua</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected((string) request('kategori_kerusakan_id') === (string) $kategori->id)>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                <x-icon name="filter" class="w-4 h-4" /> Filter
            </button>
        </form>
    </div>

    @if ($pengaduans->isEmpty())
        <div class="px-6 py-14 text-center text-slate-400 text-sm">Tidak ada data untuk filter yang dipilih.</div>
    @else
        {{-- Mobile: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach ($pengaduans as $item)
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-3">
                        <p class="font-semibold text-slate-800">{{ $item->kategori->nama }}</p>
                        <x-status-badge :status="$item->status" :label="$item->statusLabel()" />
                    </div>
                    <p class="text-sm text-slate-600">{{ $item->lokasi->nama }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $item->tanggal_kejadian->translatedFormat('d M Y') }} &middot; {{ $item->user->name }}</p>
                </div>
            @endforeach
        </div>

        <div class="hidden md:block overflow-x-auto"><table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left font-medium px-6 py-3">Tanggal</th>
                    <th class="text-left font-medium px-6 py-3">Kategori</th>
                    <th class="text-left font-medium px-6 py-3">Lokasi</th>
                    <th class="text-left font-medium px-6 py-3">Pelapor</th>
                    <th class="text-right font-medium px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($pengaduans as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-slate-600">{{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-4 text-slate-800 font-medium">{{ $item->kategori->nama }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->lokasi->nama }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 text-right"><x-status-badge :status="$item->status" :label="$item->statusLabel()" /></td>
                    </tr>
                @endforeach
            </tbody>
        </table></div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $pengaduans->links() }}
        </div>
    @endif
</div>
@endsection
