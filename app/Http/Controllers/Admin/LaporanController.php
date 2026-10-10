<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    private function filtered(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'lokasi']);

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_kejadian', '>=', $request->date('dari'));
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_kejadian', '<=', $request->date('sampai'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('kategori_kerusakan_id')) {
            $query->where('kategori_kerusakan_id', $request->integer('kategori_kerusakan_id'));
        }

        return $query->latest('tanggal_kejadian');
    }

    public function index(Request $request): View
    {
        $pengaduans = $this->filtered($request)->paginate(15)->withQueryString();
        $kategoris = KategoriKerusakan::orderBy('nama')->get();
        $lokasis = Lokasi::orderBy('nama')->get();

        return view('admin.laporan.index', compact('pengaduans', 'kategoris', 'lokasis'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $rows = $this->filtered($request)->get();

        $filename = 'laporan-pengaduan-'.now()->format('Ymd-His').'.csv';

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Kode', 'Tanggal', 'Kategori', 'Lokasi', 'Pelapor', 'Status', 'Catatan Admin']);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->kode,
                    $row->tanggal_kejadian->format('d-m-Y'),
                    $row->kategori->nama,
                    $row->lokasi->nama,
                    $row->user->name,
                    $row->statusLabel(),
                    $row->catatan_admin,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function print(Request $request): View
    {
        $rows = $this->filtered($request)->get();

        return view('admin.laporan.print', ['rows' => $rows, 'generatedAt' => now()]);
    }
}
