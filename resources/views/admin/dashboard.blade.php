@php($title = 'Dashboard Admin')
@php($subtitle = 'Selamat datang di panel admin AduinAja!!')
@extends('layouts.app')

@section('content')
<div class="grid grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-5 mb-6 sm:mb-8">
    @foreach ([
        ['label' => 'Total Pengaduan', 'val' => $stats['total'], 'icon' => 'clipboard', 'box' => 'bg-blue-50 text-blue-600', 'sub' => '+'.$stats['hari_ini'].' hari ini'],
        ['label' => 'Diajukan', 'val' => $stats['diajukan'], 'icon' => 'clock', 'box' => 'bg-violet-50 text-violet-600', 'sub' => 'menunggu verifikasi'],
        ['label' => 'Diproses', 'val' => $stats['diproses'], 'icon' => 'cog', 'box' => 'bg-amber-50 text-amber-600', 'sub' => 'sedang ditangani'],
        ['label' => 'Selesai', 'val' => $stats['selesai'], 'icon' => 'check', 'box' => 'bg-green-50 text-green-600', 'sub' => 'sudah diperbaiki'],
    ] as $i => $c)
        <div class="anim-up d{{ $i + 1 }} lift bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl {{ $c['box'] }} flex items-center justify-center mb-3 sm:mb-4">
                <x-icon :name="$c['icon']" class="w-5 h-5 sm:w-6 sm:h-6" />
            </div>
            <p class="text-xs sm:text-sm text-slate-500">{{ $c['label'] }}</p>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1"><span data-count="{{ $c['val'] }}">{{ $c['val'] }}</span></p>
            <p class="text-[11px] sm:text-xs text-slate-400 mt-1">{{ $c['sub'] }}</p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-5 gap-4 sm:gap-5">
    <div class="anim-up d3 xl:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-2">
                <x-icon name="chart" class="w-5 h-5 text-blue-600" />
                <h3 class="font-bold text-slate-800">Statistik Kerusakan per Kategori</h3>
            </div>
            <form method="GET">
                <select name="periode" onchange="this.form.submit()" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-600 focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="7" @selected($periode === '7')>7 Hari Terakhir</option>
                    <option value="30" @selected($periode === '30')>30 Hari Terakhir</option>
                    <option value="semua" @selected($periode === 'semua')>Semua Waktu</option>
                </select>
            </form>
        </div>
        <div class="relative h-64 sm:h-72"><canvas id="kategoriChart"></canvas></div>
    </div>

    <div class="anim-up d4 xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <x-icon name="bell" class="w-5 h-5 text-blue-600" />
                <h3 class="font-bold text-slate-800">Aktivitas Terbaru</h3>
            </div>
            <a href="{{ route('admin.pengaduan.index') }}" class="text-xs font-semibold text-blue-600 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-4">
            @forelse ($recent as $item)
                <a href="{{ route('admin.pengaduan.show', $item) }}" class="flex items-center gap-3 group">
                    @if ($item->foto)
                        <img src="{{ asset($item->foto) }}" alt="" loading="lazy" class="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center shrink-0">
                            <x-icon name="clipboard" class="w-5 h-5" />
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-blue-600">{{ $item->kategori->nama }} - {{ $item->lokasi->nama }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $item->user->name }} &middot; {{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    <x-status-badge :status="$item->status" :label="$item->statusLabel()" />
                </a>
            @empty
                <p class="text-sm text-slate-400 text-center py-6">Belum ada aktivitas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
@endpush

@push('scripts')
<script>
    if (window.Chart) {
        new Chart(document.getElementById('kategoriChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData->pluck('label')) !!},
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: {!! json_encode($chartData->pluck('total')) !!},
                    backgroundColor: ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899', '#84cc16'],
                    borderRadius: 8,
                    maxBarThickness: 56,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 900, easing: 'easeOutQuart' },
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false }, ticks: { maxRotation: 40, minRotation: 0, autoSkip: false, font: { size: 11 } } },
                }
            }
        });
    }
</script>
@endpush
