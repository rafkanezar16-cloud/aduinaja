<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan - AduinAja!!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body class="p-8 text-slate-800">
    <div class="no-print mb-6 flex justify-end">
        <button onclick="window.print()" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold">Cetak / Simpan sebagai PDF</button>
    </div>

    <div class="text-center mb-6">
        <h1 class="text-xl font-extrabold">LAPORAN REKAP PENGADUAN SARANA SEKOLAH</h1>
        <p class="text-sm text-slate-500">AduinAja!! &mdash; SMK Negeri 5 Surakarta</p>
        <p class="text-xs text-slate-400 mt-1">Dicetak pada {{ $generatedAt->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="bg-slate-100">
                <th class="border border-slate-300 px-3 py-2 text-left">No</th>
                <th class="border border-slate-300 px-3 py-2 text-left">Kode</th>
                <th class="border border-slate-300 px-3 py-2 text-left">Tanggal</th>
                <th class="border border-slate-300 px-3 py-2 text-left">Kategori</th>
                <th class="border border-slate-300 px-3 py-2 text-left">Lokasi</th>
                <th class="border border-slate-300 px-3 py-2 text-left">Pelapor</th>
                <th class="border border-slate-300 px-3 py-2 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $i => $row)
                <tr>
                    <td class="border border-slate-300 px-3 py-2">{{ $i + 1 }}</td>
                    <td class="border border-slate-300 px-3 py-2">{{ $row->kode }}</td>
                    <td class="border border-slate-300 px-3 py-2">{{ $row->tanggal_kejadian->translatedFormat('d M Y') }}</td>
                    <td class="border border-slate-300 px-3 py-2">{{ $row->kategori->nama }}</td>
                    <td class="border border-slate-300 px-3 py-2">{{ $row->lokasi->nama }}</td>
                    <td class="border border-slate-300 px-3 py-2">{{ $row->user->name }}</td>
                    <td class="border border-slate-300 px-3 py-2">{{ $row->statusLabel() }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="border border-slate-300 px-3 py-6 text-center text-slate-400">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="text-xs text-slate-400 mt-6">Total data: {{ $rows->count() }} pengaduan.</p>
</body>
</html>
