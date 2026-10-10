@php
$tabs = [
    'kategori' => ['label' => 'Kategori Kerusakan', 'route' => 'admin.kategori.index'],
    'lokasi' => ['label' => 'Lokasi / Ruangan', 'route' => 'admin.lokasi.index'],
    'user' => ['label' => 'Data Pengguna', 'route' => 'admin.user.index'],
];
@endphp
<div class="flex gap-5 sm:gap-6 border-b border-slate-200 mb-6 overflow-x-auto whitespace-nowrap">
    @foreach ($tabs as $key => $tab)
        <a href="{{ route($tab['route']) }}"
           class="pb-3 text-sm font-semibold border-b-2 -mb-px transition
                  {{ $active === $key ? 'border-blue-600 text-slate-900' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
            {{ $tab['label'] }}
        </a>
    @endforeach
</div>
