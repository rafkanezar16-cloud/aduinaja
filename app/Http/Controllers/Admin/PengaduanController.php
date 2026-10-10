<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengaduan::with(['user', 'kategori', 'lokasi']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('q')) {
            $keyword = $request->string('q');
            $query->where(function ($sub) use ($keyword) {
                $sub->where('kode', 'like', "%{$keyword}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$keyword}%"));
            });
        }

        $pengaduans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function show(Pengaduan $pengaduan): View
    {
        $pengaduan->load(['user', 'kategori', 'lokasi', 'petugas']);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:diproses,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $pengaduan->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? $pengaduan->catatan_admin,
            'ditangani_oleh' => auth()->id(),
            'selesai_at' => $validated['status'] === 'selesai' ? now() : $pengaduan->selesai_at,
        ]);

        return back()->with('status', 'status-updated');
    }
}
