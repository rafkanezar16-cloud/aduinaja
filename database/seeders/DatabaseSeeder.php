<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriKerusakanSeeder::class,
            LokasiSeeder::class,
            PengaduanSeeder::class,
        ]);
    }
}
