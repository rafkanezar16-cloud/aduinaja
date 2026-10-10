@php($title = 'Dashboard')
@php($subtitle = 'Selamat datang, ' . auth()->user()->name . '!')
@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 mb-6 sm:mb-8">
    @foreach ([
        ['label' => 'Diajukan', 'key' => 'diajukan', 'icon' => 'clock', 'box' => 'bg-blue-50 text-blue-600'],
        ['label' => 'Diproses', 'key' => 'diproses', 'icon' => 'cog', 'box' => 'bg-amber-50 text-amber-600'],
        ['label' => 'Selesai', 'key' => 'selesai', 'icon' => 'check', 'box' => 'bg-green-50 text-green-600'],
    ] as $i => $card)
        <div class="anim-up d{{ $i + 1 }} lift bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 flex sm:block items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $card['box'] }} flex items-center justify-center sm:mb-4 shrink-0">
                <x-icon :name="$card['icon']" class="w-6 h-6" />
            </div>
            <div>
                <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                <p class="text-3xl font-extrabold text-slate-900 sm:mt-1"><span data-count="{{ $stats[$card['key']] }}">{{ $stats[$card['key']] }}</span></p>
            </div>
        </div>
    @endforeach
</div>

<a href="{{ route('siswa.pengaduan.create') }}"
   class="anim-up d4 inline-flex w-full sm:w-auto justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-5 py-3 rounded-xl shadow-lg shadow-blue-600/30 mb-6 sm:mb-8">
    <x-icon name="plus" class="w-5 h-5" />
    Ajukan Pengaduan Baru
</a>

<div class="anim-up d5 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-2">
        <h3 class="font-bold text-slate-800">Pengaduan Terbaru Anda</h3>
        <a href="{{ route('siswa.pengaduan.index') }}" class="text-sm font-semibold text-blue-600 hover:underline whitespace-nowrap">Lihat semua &rarr;</a>
    </div>

    @if ($recent->isEmpty())
        <div class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada pengaduan yang diajukan.</div>
    @else
        {{-- Mobile: kartu --}}
        <div class="md:hidden divide-y divide-slate-100">
            @foreach ($recent as $item)
                <a href="{{ route('siswa.pengaduan.show', $item) }}" class="block px-4 py-4 hover:bg-slate-50">
                    <div class="flex items-start justify-between gap-3">
                        <p class="font-semibold text-slate-800">{{ $item->kategori->nama }}</p>
                        <x-status-badge :status="$item->status" :label="$item->statusLabel()" />
                    </div>
                    <p class="text-sm text-slate-500 mt-1">{{ $item->lokasi->nama }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</p>
                </a>
            @endforeach
        </div>

        {{-- Desktop: tabel --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="text-left font-medium px-6 py-3">Tanggal</th>
                        <th class="text-left font-medium px-6 py-3">Kategori / Lokasi</th>
                        <th class="text-right font-medium px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($recent as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-600">
                                <a href="{{ route('siswa.pengaduan.show', $item) }}" class="hover:text-blue-600">{{ $item->tanggal_kejadian->translatedFormat('d M Y') }}</a>
                            </td>
                            <td class="px-6 py-4 text-slate-800 font-medium">
                                {{ $item->kategori->nama }} <span class="text-slate-400 font-normal">&middot; {{ $item->lokasi->nama }}</span>
                            </td>
                            <td class="px-6 py-4 text-right"><x-status-badge :status="$item->status" :label="$item->statusLabel()" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
