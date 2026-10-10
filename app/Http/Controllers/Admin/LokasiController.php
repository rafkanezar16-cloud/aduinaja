<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LokasiController extends Controller
{
    public function index(): View
    {
        $lokasis = Lokasi::withCount('pengaduans')->orderBy('nama')->paginate(10);

        return view('admin.lokasi.index', compact('lokasis'));
    }

    public function create(): View
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'gedung' => ['nullable', 'string', 'max:100'],
        ]);

        Lokasi::create($validated);

        return redirect()->route('admin.lokasi.index')->with('status', 'lokasi-created');
    }

    public function edit(Lokasi $lokasi): View
    {
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'gedung' => ['nullable', 'string', 'max:100'],
        ]);

        $lokasi->update($validated);

        return redirect()->route('admin.lokasi.index')->with('status', 'lokasi-updated');
    }

    public function destroy(Lokasi $lokasi): RedirectResponse
    {
        if ($lokasi->pengaduans()->exists()) {
            return back()->with('error', 'Lokasi tidak bisa dihapus karena masih dipakai pada data pengaduan.');
        }

        $lokasi->delete();

        return back()->with('status', 'lokasi-deleted');
    }
}
