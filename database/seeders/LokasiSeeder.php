<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasis = [
            ['nama' => 'Lab RPL', 'gedung' => 'Gedung A'],
            ['nama' => 'Ruang Kelas XII RPL A', 'gedung' => 'Gedung A'],
            ['nama' => 'Ruang Kelas XII RPL B', 'gedung' => 'Gedung A'],
            ['nama' => 'Ruang Guru', 'gedung' => 'Gedung B'],
            ['nama' => 'Perpustakaan', 'gedung' => 'Gedung B'],
            ['nama' => 'Aula Sekolah', 'gedung' => 'Gedung C'],
        ];

        foreach ($lokasis as $l) {
            Lokasi::create($l);
        }
    }
}
