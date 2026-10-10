<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sarpras',
            'nis_nip' => '198501012010011001',
            'email' => 'admin@aduinaja.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $siswa = [
            ['name' => 'Andi Pratama', 'email' => 'andi@siswa.sch.id', 'nis' => '2425001', 'kelas' => 'XII RPL A'],
            ['name' => 'Siti Rahma', 'email' => 'siti@siswa.sch.id', 'nis' => '2425002', 'kelas' => 'XII RPL A'],
            ['name' => 'Budi Santoso', 'email' => 'budi@siswa.sch.id', 'nis' => '2425003', 'kelas' => 'XII RPL B'],
            ['name' => 'Rina Agustina', 'email' => 'rina@siswa.sch.id', 'nis' => '2425004', 'kelas' => 'XII RPL B'],
            ['name' => 'Fajar Kurniawan', 'email' => 'fajar@siswa.sch.id', 'nis' => '2425005', 'kelas' => 'XII RPL A'],
            ['name' => 'Rafka Nezar Azriel Ghibran', 'email' => 'rafka@siswa.sch.id', 'nis' => '2425027', 'kelas' => 'XII RPL A'],
        ];

        foreach ($siswa as $s) {
            User::create([
                'name' => $s['name'],
                'nis_nip' => $s['nis'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'kelas' => $s['kelas'],
            ]);
        }
    }
}
