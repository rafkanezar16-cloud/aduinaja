@php($title = 'Detail Pengaduan')
@php($subtitle = $pengaduan->kode)
@extends('layouts.app')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="anim-up bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8">
        <div class="flex items-start justify-between gap-3 mb-6">
            <div class="min-w-0">
                <p class="text-xs text-slate-400 mb-1">Kode Pengaduan</p>
                <p class="text-lg font-bold text-slate-800 break-all">{{ $pengaduan->kode }}</p>
            </div>
            <x-status-badge :status="$pengaduan->status" :label="$pengaduan->statusLabel()" />
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
            <div><dt class="text-slate-400 mb-1">Kategori Kerusakan</dt><dd class="font-semibold text-slate-800">{{ $pengaduan->kategori->nama }}</dd></div>
            <div><dt class="text-slate-400 mb-1">Lokasi</dt><dd class="font-semibold text-slate-800">{{ $pengaduan->lokasi->nama }}</dd></div>
            <div><dt class="text-slate-400 mb-1">Tanggal Kejadian</dt><dd class="font-semibold text-slate-800">{{ $pengaduan->tanggal_kejadian->translatedFormat('d F Y') }}</dd></div>
            <div><dt class="text-slate-400 mb-1">Ditangani oleh</dt><dd class="font-semibold text-slate-800">{{ $pengaduan->petugas->name ?? '-' }}</dd></div>
            <div class="sm:col-span-2"><dt class="text-slate-400 mb-1">Deskripsi</dt><dd class="text-slate-700 whitespace-pre-line">{{ $pengaduan->deskripsi }}</dd></div>
            <div class="sm:col-span-2">
                <dt class="text-slate-400 mb-2">Bukti Foto / Video</dt>
                <dd><x-media-evidence :pengaduan="$pengaduan" /></dd>
            </div>
            @if ($pengaduan->catatan_admin)
                <div class="sm:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <dt class="text-slate-400 mb-1">Catatan Admin</dt>
                    <dd class="text-slate-700">{{ $pengaduan->catatan_admin }}</dd>
                </div>
            @endif
        </dl>
    </div>

    <a href="{{ route('siswa.pengaduan.index') }}" class="inline-block text-sm font-semibold text-blue-600 hover:underline">&larr; Kembali ke riwayat</a>
</div>
@endsection
