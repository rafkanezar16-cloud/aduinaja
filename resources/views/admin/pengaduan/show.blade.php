@php($title = 'Detail Pengaduan')
@php($subtitle = $pengaduan->kode)
@extends('layouts.app')

@section('content')
<div class="anim-up max-w-3xl space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <p class="text-xs text-slate-400 mb-1">Kode Pengaduan</p>
                <p class="text-lg font-bold text-slate-800">{{ $pengaduan->kode }}</p>
            </div>
            <x-status-badge :status="$pengaduan->status" :label="$pengaduan->statusLabel()" />
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
            <div>
                <dt class="text-slate-400 mb-1">Pelapor</dt>
                <dd class="font-semibold text-slate-800">{{ $pengaduan->user->name }} @if($pengaduan->user->kelas) &middot; {{ $pengaduan->user->kelas }} @endif</dd>
            </div>
            <div>
                <dt class="text-slate-400 mb-1">Kategori Kerusakan</dt>
                <dd class="font-semibold text-slate-800">{{ $pengaduan->kategori->nama }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 mb-1">Lokasi</dt>
                <dd class="font-semibold text-slate-800">{{ $pengaduan->lokasi->nama }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 mb-1">Tanggal Kejadian</dt>
                <dd class="font-semibold text-slate-800">{{ $pengaduan->tanggal_kejadian->translatedFormat('d F Y') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-slate-400 mb-1">Deskripsi</dt>
                <dd class="text-slate-700 whitespace-pre-line">{{ $pengaduan->deskripsi }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-slate-400 mb-2">Bukti Foto / Video</dt>
                <dd><x-media-evidence :pengaduan="$pengaduan" /></dd>
            </div>
        </dl>
    </div>

    @if ($pengaduan->status !== 'ditolak')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8">
            <h3 class="font-bold text-slate-800 mb-4">Perbarui Status Penanganan</h3>
            <form method="POST" action="{{ route('admin.pengaduan.status', $pengaduan) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Baru</label>
                    <select name="status" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        @if ($pengaduan->status === 'diajukan')
                            <option value="diproses">Diproses</option>
                            <option value="ditolak">Ditolak</option>
                        @elseif ($pengaduan->status === 'diproses')
                            <option value="selesai">Selesai</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan (opsional)</label>
                    <textarea name="catatan_admin" rows="3" placeholder="Catatan tindak lanjut / alasan penolakan..."
                              class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ $pengaduan->catatan_admin }}</textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/30">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    @elseif ($pengaduan->catatan_admin)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8">
            <h3 class="font-bold text-slate-800 mb-2">Catatan Admin</h3>
            <p class="text-slate-700 text-sm">{{ $pengaduan->catatan_admin }}</p>
        </div>
    @endif

    <a href="{{ route('admin.pengaduan.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">&larr; Kembali ke daftar</a>
</div>
@endsection
