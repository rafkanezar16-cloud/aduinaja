<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = KategoriKerusakan::withCount('pengaduans')->orderBy('nama')->paginate(10);

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create(): View
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategori_kerusakans,nama'],
        ]);

        KategoriKerusakan::create($validated);

        return redirect()->route('admin.kategori.index')->with('status', 'kategori-created');
    }

    public function edit(KategoriKerusakan $kategori): View
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriKerusakan $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategori_kerusakans,nama,'.$kategori->id],
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('status', 'kategori-updated');
    }

    public function destroy(KategoriKerusakan $kategori): RedirectResponse
    {
        if ($kategori->pengaduans()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai pada data pengaduan.');
        }

        $kategori->delete();

        return back()->with('status', 'kategori-deleted');
    }
}
