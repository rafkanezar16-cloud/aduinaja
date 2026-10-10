<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $periode = in_array($request->query('periode'), ['7', '30', 'semua'], true)
            ? $request->query('periode')
            : '7';

        $stats = [
            'total' => Pengaduan::count(),
            'diajukan' => Pengaduan::where('status', 'diajukan')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'hari_ini' => Pengaduan::whereDate('created_at', today())->count(),
        ];

        $chartData = KategoriKerusakan::withCount(['pengaduans' => function ($q) use ($periode) {
            if ($periode !== 'semua') {
                $q->where('tanggal_kejadian', '>=', now()->subDays((int) $periode)->toDateString());
            }
        }])
            ->orderBy('nama')
            ->get()
            ->map(fn ($k) => ['label' => $k->nama, 'total' => $k->pengaduans_count]);

        $recent = Pengaduan::with(['user', 'kategori', 'lokasi'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'chartData', 'recent', 'periode'));
    }
}
