<?php

namespace Database\Seeders;

use App\Models\KategoriKerusakan;
use Illuminate\Database\Seeder;

class KategoriKerusakanSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Elektronik', 'Meja & Kursi', 'Bangunan', 'ATK', 'Lainnya'] as $nama) {
            KategoriKerusakan::create(['nama' => $nama]);
        }
    }
}
