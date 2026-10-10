<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AduinAja!!</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float1 { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(30px,-40px) scale(1.1); } }
        @keyframes float2 { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(-40px,30px) scale(1.15); } }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
        @keyframes bob { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        .blob1 { animation: float1 12s ease-in-out infinite; }
        .blob2 { animation: float2 15s ease-in-out infinite; }
        .rise { opacity: 0; animation: fadeUp .7s ease-out forwards; }
        .bob { animation: bob 3.2s ease-in-out infinite; }
        @media (prefers-reduced-motion: reduce) {
            .blob1,.blob2,.bob { animation: none; } .rise { opacity: 1; animation: none; }
        }
    </style>
</head>
<body class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 min-h-screen flex items-center justify-center p-4">

    {{-- latar animasi --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="blob1 absolute -top-24 -left-24 w-80 h-80 rounded-full bg-blue-500/30 blur-3xl"></div>
        <div class="blob2 absolute -bottom-28 -right-20 w-96 h-96 rounded-full bg-amber-400/20 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <div class="text-center mb-6 sm:mb-8 rise">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo AduinAja" class="bob w-20 h-20 mx-auto mb-3">
            <h1 class="text-3xl font-extrabold text-white">Aduin<span class="text-amber-400">Aja!!</span></h1>
            <p class="text-blue-200 text-sm mt-1">Sistem Pengaduan Sarana Sekolah</p>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 rise" style="animation-delay:.15s">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Masuk ke akun Anda</h2>
            <p class="text-sm text-slate-500 mb-6">Gunakan email dan kata sandi yang terdaftar.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-xl px-4 py-3 text-sm font-medium bg-red-50 text-red-700 border border-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Kata sandi</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full rounded-xl border border-slate-200 pl-4 pr-16 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <button type="button" id="toggle-pw" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-blue-600 hover:underline">Lihat</button>
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Ingat saya
                </label>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[.98] transition text-white font-semibold py-2.5 rounded-xl shadow-lg shadow-blue-600/30">
                    Masuk
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-xs text-slate-400 space-y-1">
                <p class="font-semibold text-slate-500">Akun demo:</p>
                <p>Admin : admin@aduinaja.sch.id / password</p>
                <p>Siswa : andi@siswa.sch.id / password</p>
            </div>
        </div>

        <p class="text-center text-blue-300 text-xs mt-6">SMK Negeri 5 Surakarta &copy; {{ date('Y') }}</p>
    </div>

<script>
    document.getElementById('toggle-pw').addEventListener('click', function () {
        var i = document.getElementById('password');
        var show = i.type === 'password';
        i.type = show ? 'text' : 'password';
        this.textContent = show ? 'Sembunyi' : 'Lihat';
    });
</script>
</body>
</html>
