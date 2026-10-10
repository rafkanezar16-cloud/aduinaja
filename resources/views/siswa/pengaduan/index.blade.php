@php($title = 'Riwayat Pengaduan')
@php($subtitle = 'Daftar seluruh pengaduan yang pernah Anda ajukan')
@extends('layouts.app')

@section('content')
<div class="anim-up bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    @if ($pengaduans->isEmpty())
        <div class="px-6 py-14 text-center text-slate-400 text-sm">
            Belum ada riwayat pengaduan.
            <a href="{{ route('siswa.pengaduan.create') }}" class="text-blue-600 font-semibold hover:underline">Ajukan sekarang &rarr;</a>
        </div>
    @else
        {{-- Mobile: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach ($pengaduans as $item)
                <a href="{{ route('siswa.pengaduan.show', $item) }}" class="block px-4 py-4 hover:bg-slate-50">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-xs font-semibold text-blue-600">{{ $item->kode }}</p>
                        <x-status-badge :status="$item->status" :label="$item->statusLabel()" />
                    </div>
                    <p class="font-semibold text-slate-800 mt-1.5">{{ $item->kategori->nama }}</p>
                    <p class="text-sm text-slate-500">{{ $item->lokasi->nama }} &middot; {{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</p>
                    @if ($item->foto || $item->video)
                        <p class="text-xs text-slate-400 mt-1.5 inline-flex items-center gap-1">
                            <x-icon name="photo" class="w-3.5 h-3.5" /> {{ $item->foto ? 'Foto' : '' }}{{ $item->foto && $item->video ? ' + ' : '' }}{{ $item->video ? 'Video' : '' }}
                        </p>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Desktop: tabel --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left font-medium px-6 py-3">Kode</th>
                        <th class="text-left font-medium px-6 py-3">Tanggal</th>
                        <th class="text-left font-medium px-6 py-3">Kategori / Lokasi</th>
                        <th class="text-left font-medium px-6 py-3">Bukti</th>
                        <th class="text-right font-medium px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($pengaduans as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4"><a href="{{ route('siswa.pengaduan.show', $item) }}" class="font-semibold text-blue-600 hover:underline">{{ $item->kode }}</a></td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-slate-800 font-medium">{{ $item->kategori->nama }} <span class="text-slate-400 font-normal">&middot; {{ $item->lokasi->nama }}</span></td>
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
                            <td class="px-6 py-4 text-right"><x-status-badge :status="$item->status" :label="$item->statusLabel()" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 sm:px-6 py-4 border-t border-slate-100">{{ $pengaduans->links() }}</div>
    @endif
</div>
@endsection
