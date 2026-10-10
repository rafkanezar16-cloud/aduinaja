<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    public function index(Request $request): View
    {
        $pengaduans = $request->user()
            ->pengaduans()
            ->with(['kategori', 'lokasi'])
            ->latest()
            ->paginate(10);

        return view('siswa.pengaduan.index', compact('pengaduans'));
    }

    public function create(): View
    {
        $kategoris = KategoriKerusakan::orderBy('nama')->get();
        $lokasis = Lokasi::orderBy('nama')->get();

        return view('siswa.pengaduan.create', compact('kategoris', 'lokasis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kerusakan_id' => ['required', 'exists:kategori_kerusakans,id'],
            'lokasi_id' => ['required', 'exists:lokasis,id'],
            'tanggal_kejadian' => ['required', 'date', 'before_or_equal:today'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:10240'],
        ]);

        $validated['user_id'] = $request->user()->id;
        $validated['kode'] = 'ADN-'.now()->format('ymd').'-'.strtoupper(Str::random(4));
        $validated['status'] = 'diajukan';

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $name = time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti'), $name);
            $validated['foto'] = 'uploads/bukti/'.$name;
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'mp4');
            $name = time().'_'.Str::random(8).'.'.$ext;
            $file->move(public_path('uploads/video'), $name);
            $validated['video'] = 'uploads/video/'.$name;
        }

        Pengaduan::create($validated);

        return redirect()->route('siswa.pengaduan.index')->with('status', 'pengaduan-created');
    }

    public function show(Pengaduan $pengaduan): View
    {
        abort_unless($pengaduan->user_id === auth()->id(), 403);

        $pengaduan->load(['kategori', 'lokasi', 'petugas']);

        return view('siswa.pengaduan.show', compact('pengaduan'));
    }
}
