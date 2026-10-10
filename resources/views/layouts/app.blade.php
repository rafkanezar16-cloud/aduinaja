<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'AduinAja!!' }} - AduinAja!!</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }

        /* ---- Animasi ringan ---- */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes popIn  { from { opacity: 0; transform: scale(.94); } to { opacity: 1; transform: none; } }
        .anim-up   { opacity: 0; animation: fadeUp .5s ease-out forwards; }
        .anim-pop  { animation: popIn .25s ease-out; }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .12s; } .d3 { animation-delay: .19s; }
        .d4 { animation-delay: .26s; } .d5 { animation-delay: .33s; }
        .lift { transition: transform .2s ease, box-shadow .2s ease; }
        .lift:hover { transform: translateY(-3px); box-shadow: 0 10px 25px -10px rgba(30,64,175,.25); }
        @media (prefers-reduced-motion: reduce) {
            .anim-up { opacity: 1; animation: none; }
            .lift:hover { transform: none; }
        }
    </style>
    @stack('head')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

@php
    $isAdmin = auth()->user()->isAdmin();
    $menu = $isAdmin ? [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'admin.pengaduan.index', 'label' => 'Verifikasi Pengaduan', 'icon' => 'clipboard'],
        ['route' => 'admin.kategori.index', 'label' => 'Master Data', 'icon' => 'database', 'alsoActive' => ['admin.lokasi.*', 'admin.user.*']],
        ['route' => 'admin.laporan.index', 'label' => 'Laporan', 'icon' => 'chart'],
    ] : [
        ['route' => 'siswa.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'siswa.pengaduan.create', 'label' => 'Ajukan Pengaduan', 'icon' => 'plus'],
        ['route' => 'siswa.pengaduan.index', 'label' => 'Riwayat Pengaduan', 'icon' => 'clock', 'alsoActive' => ['siswa.pengaduan.show']],
    ];

    $flashMessages = [
        'pengaduan-created' => 'Pengaduan berhasil dikirim. Pantau statusnya di Riwayat Pengaduan.',
        'status-updated' => 'Status pengaduan berhasil diperbarui.',
        'kategori-created' => 'Kategori berhasil ditambahkan.',
        'kategori-updated' => 'Kategori berhasil diperbarui.',
        'kategori-deleted' => 'Kategori berhasil dihapus.',
        'lokasi-created' => 'Lokasi berhasil ditambahkan.',
        'lokasi-updated' => 'Lokasi berhasil diperbarui.',
        'lokasi-deleted' => 'Lokasi berhasil dihapus.',
        'user-created' => 'Pengguna berhasil ditambahkan.',
        'user-updated' => 'Data pengguna berhasil diperbarui.',
        'user-deleted' => 'Pengguna berhasil dihapus.',
        'profile-updated' => 'Profil berhasil diperbarui.',
        'password-updated' => 'Kata sandi berhasil diperbarui.',
    ];
    $flashKey = session('status');
    $flashText = session('error') ?: ($flashMessages[$flashKey] ?? $flashKey);
@endphp

<div class="flex min-h-screen">

    {{-- overlay (mobile) --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/60 z-30 hidden lg:hidden" style="animation: fadeIn .2s"></div>

    {{-- ===================== SIDEBAR (desktop tetap, mobile = drawer) ===================== --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full transition-transform duration-300 ease-out
                  lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen lg:z-auto
                  shrink-0 flex flex-col bg-gradient-to-b from-blue-950 via-blue-900 to-indigo-950 text-white overflow-y-auto">
        <div class="px-6 py-6 flex items-center gap-3 border-b border-white/10">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo AduinAja" class="w-11 h-11 shrink-0">
            <div class="flex-1">
                <p class="text-xl font-extrabold leading-tight">Aduin<span class="text-amber-400">Aja!!</span></p>
                <p class="text-[11px] text-blue-200 leading-tight">Sistem Pengaduan Sekolah</p>
            </div>
            <button type="button" id="sidebar-close" class="lg:hidden p-1.5 rounded-lg hover:bg-white/10" aria-label="Tutup menu">
                <x-icon name="x" class="w-5 h-5" />
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            @foreach ($menu as $item)
                @php
                    $active = request()->routeIs($item['route'].'*') || request()->routeIs(...($item['alsoActive'] ?? ['__none__']));
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                          {{ $active ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/40' : 'text-blue-100 hover:bg-white/10' }}">
                    <x-icon :name="$item['icon']" class="w-5 h-5 shrink-0" />
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="px-4 pb-4">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-white/10' }}">
                <x-icon name="user" class="w-5 h-5 shrink-0" />
                <span>Profil Saya</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-blue-100 hover:bg-white/10 transition">
                    <x-icon name="logout" class="w-5 h-5 shrink-0" />
                    <span>Keluar</span>
                </button>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-white/10 flex items-center gap-2 text-blue-300">
            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[10px] font-bold">SMK</div>
            <div class="text-[11px] leading-tight">
                <p class="font-semibold text-white">AduinAja!!</p>
                <p>SMK Negeri 5 Surakarta</p>
            </div>
        </div>
    </aside>

    {{-- ===================== MAIN ===================== --}}
    <div class="flex-1 flex flex-col min-w-0">

        <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-100 px-4 sm:px-8 py-3 sm:py-5 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button" id="sidebar-open" class="lg:hidden p-2 -ml-2 rounded-lg text-slate-600 hover:bg-slate-100" aria-label="Buka menu">
                    <x-icon name="menu" class="w-6 h-6" />
                </button>
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-2xl font-extrabold text-slate-900 truncate">{{ $title ?? 'Dashboard' }}</h1>
                    @if (!empty($subtitle))
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 truncate">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-full pl-1.5 sm:pl-2 pr-1.5 sm:pr-4 py-1.5 shrink-0 hover:bg-slate-100 transition">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="text-sm leading-tight hidden sm:block">
                    <p class="font-semibold text-slate-800 max-w-[160px] truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-400 text-xs">{{ $isAdmin ? 'Administrator' : 'Siswa' }}</p>
                </div>
            </a>
        </header>

        <main class="flex-1 p-4 sm:p-8">
            @if ($flashText)
                <div id="flash" class="anim-pop mb-6 rounded-xl px-4 py-3 text-sm font-medium flex items-start justify-between gap-3
                    {{ session('error') ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-green-50 text-green-700 border border-green-200' }}">
                    <span>{{ $flashText }}</span>
                    <button type="button" onclick="document.getElementById('flash').remove()" class="opacity-60 hover:opacity-100" aria-label="Tutup">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="anim-pop mb-6 rounded-xl px-4 py-3 text-sm font-medium bg-red-50 text-red-700 border border-red-200">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- ===================== LIGHTBOX (foto & video) ===================== --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/90 p-4" role="dialog" aria-modal="true">
    <button type="button" id="lightbox-close" class="absolute top-4 right-4 text-white/80 hover:text-white p-2" aria-label="Tutup">
        <x-icon name="x" class="w-8 h-8" />
    </button>
    <div id="lightbox-body" class="anim-pop max-w-5xl w-full max-h-full flex items-center justify-center"></div>
</div>

<script>
(function () {
    // ----- Drawer sidebar (mobile) -----
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebar-overlay');
    function openMenu()  { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeMenu() { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); document.body.style.overflow = ''; }
    document.getElementById('sidebar-open').addEventListener('click', openMenu);
    document.getElementById('sidebar-close').addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);

    // ----- Lightbox: elemen dengan data-lightbox="url" & data-type="image|video" -----
    var box = document.getElementById('lightbox');
    var body = document.getElementById('lightbox-body');
    function closeBox() { box.classList.add('hidden'); box.classList.remove('flex'); body.innerHTML = ''; document.body.style.overflow = ''; }
    document.addEventListener('click', function (e) {
        var el = e.target.closest('[data-lightbox]');
        if (!el) return;
        e.preventDefault();
        var url = el.getAttribute('data-lightbox');
        var type = el.getAttribute('data-type') || 'image';
        body.innerHTML = type === 'video'
            ? '<video src="' + url + '" controls autoplay playsinline class="max-h-[85vh] max-w-full rounded-xl bg-black"></video>'
            : '<img src="' + url + '" alt="Foto bukti" class="max-h-[85vh] max-w-full rounded-xl object-contain">';
        box.classList.remove('hidden'); box.classList.add('flex'); document.body.style.overflow = 'hidden';
    });
    box.addEventListener('click', function (e) { if (e.target === box) closeBox(); });
    document.getElementById('lightbox-close').addEventListener('click', closeBox);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeBox(); closeMenu(); } });

    // ----- Count-up angka statistik: <span data-count="24">0</span> -----
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    document.querySelectorAll('[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (reduce || target === 0) { el.textContent = target; return; }
        var start = null, dur = 800;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });
})();
</script>
@stack('scripts')
</body>
</html>
