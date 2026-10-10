@props(['pengaduan'])

@if ($pengaduan->foto || $pengaduan->video)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @if ($pengaduan->foto)
            <button type="button" data-lightbox="{{ asset($pengaduan->foto) }}" data-type="image"
                    class="group relative block rounded-xl overflow-hidden border border-slate-200 bg-slate-100 text-left">
                <img src="{{ asset($pengaduan->foto) }}" alt="Foto bukti kerusakan" loading="lazy"
                     class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                <span class="absolute bottom-2 left-2 inline-flex items-center gap-1.5 bg-slate-900/70 text-white text-xs font-semibold px-2.5 py-1 rounded-full">
                    <x-icon name="eye" class="w-3.5 h-3.5" /> Perbesar foto
                </span>
            </button>
        @endif

        @if ($pengaduan->video)
            <div class="rounded-xl overflow-hidden border border-slate-200 bg-black">
                <video src="{{ asset($pengaduan->video) }}#t=0.1" controls preload="metadata" playsinline class="w-full h-48 object-contain"></video>
            </div>
        @endif
    </div>
@else
    <p class="text-sm text-slate-400">Tidak ada foto atau video bukti.</p>
@endif
