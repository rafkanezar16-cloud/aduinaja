@php($title = 'Verifikasi Pengaduan')
@php($subtitle = 'Kelola dan tindak lanjuti laporan pengaduan siswa')
@extends('layouts.app')

@section('content')
<div class="anim-up bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-slate-100">
        <form method="GET" class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1 sm:max-w-xs">
                <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode / nama siswa..."
                       class="w-full pl-9 pr-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">Semua status</option>
                @foreach (['diajukan' => 'Diajukan', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                    <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">Cari</button>
        </form>
    </div>


    @if ($pengaduans->isEmpty())
        <div class="px-6 py-14 text-center text-slate-400 text-sm">Tidak ada data pengaduan yang cocok.</div>
    @else
        {{-- Mobile: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach ($pengaduans as $item)
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-3">
                        <a href="{{ route('admin.pengaduan.show', $item) }}" class="font-semibold text-slate-800 hover:text-blue-600">{{ $item->user->name }}</a>
                        <x-status-badge :status="$item->status" :label="$item->statusLabel()" />
                    </div>
                    <p class="text-xs text-slate-400">{{ $item->kode }}</p>
                    <p class="text-sm text-slate-600 mt-1">{{ $item->kategori->nama }} &middot; {{ $item->lokasi->nama }}</p>
                    <p class="text-xs text-slate-400">{{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @include('admin.pengaduan._actions', ['item' => $item])
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop: tabel --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left font-medium px-6 py-3">Pelapor</th>
                        <th class="text-left font-medium px-6 py-3">Kategori / Lokasi</th>
                        <th class="text-left font-medium px-6 py-3">Bukti</th>
                        <th class="text-left font-medium px-6 py-3">Status</th>
                        <th class="text-right font-medium px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($pengaduans as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pengaduan.show', $item) }}" class="font-semibold text-slate-800 hover:text-blue-600">{{ $item->user->name }}</a>
                                <p class="text-xs text-slate-400">{{ $item->kode }} &middot; {{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->kategori->nama }} &middot; {{ $item->lokasi->nama }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if ($item->foto)
                                        <button type="button" data-lightbox="{{ asset($item->foto) }}" data-type="image" aria-label="Perbesar foto">
                                            <img src="{{ asset($item->foto) }}" alt="" loading="lazy" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                        </button>
                                    @endif
                                    @if ($item->video)
                                        <button type="button" data-lightbox="{{ asset($item->video) }}" data-type="video" aria-label="Putar video"
                                                class="w-10 h-10 rounded-lg bg-slate-100 text-slate-500 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center">
                                            <x-icon name="video" class="w-5 h-5" />
                                        </button>
                                    @endif
                                    @unless ($item->foto || $item->video) <span class="text-slate-300">-</span> @endunless
                                </div>
                            </td>
                            <td class="px-6 py-4"><x-status-badge :status="$item->status" :label="$item->statusLabel()" /></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    @include('admin.pengaduan._actions', ['item' => $item])
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 sm:px-6 py-4 border-t border-slate-100">{{ $pengaduans->links() }}</div>
    @endif
</div>
@endsection
