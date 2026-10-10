<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'diajukan' => $user->pengaduans()->where('status', 'diajukan')->count(),
            'diproses' => $user->pengaduans()->where('status', 'diproses')->count(),
            'selesai' => $user->pengaduans()->where('status', 'selesai')->count(),
        ];

        $recent = $user->pengaduans()
            ->with(['kategori', 'lokasi'])
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('stats', 'recent'));
    }
}
