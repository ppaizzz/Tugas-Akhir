<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserCabangSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan Data User Lama
        DB::table('users')->delete();

        // 2. Setup 5 Cabang
        $namaCabang = ['Solok', 'Padang', 'Bukittinggi', 'Payakumbuh', 'Pariaman'];
        $cabangIds = [];

        foreach ($namaCabang as $index => $nama) {
            $cabang = DB::table('cabang')->where('nama', 'like', "%$nama%")->first();
            if (!$cabang) {
                $id = DB::table('cabang')->insertGetId([
                    'nama' => "Cabang $nama",
                    'alamat' => "Jl. Raya $nama No. " . ($index + 1),
                    'telepon' => "0812000000" . $index,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $cabangIds[$nama] = $id;
            } else {
                $cabangIds[$nama] = $cabang->id;
            }
        }

        $password = Hash::make('password123'); // Password seragam

        // 3. Buat 1 Admin Pusat
        User::create([
            'name' => 'Admin Pusat',
            'email' => 'adminpusat@grandcitra.com',
            'password' => $password,
            'role' => 'admin_pusat',
        ]);

        // 4. Buat 1 Manager
        User::create([
            'name' => 'Manager Utama',
            'email' => 'manager@grandcitra.com',
            'password' => $password,
            'role' => 'manager',
        ]);

        // 5. Buat Akun Kepala Cabang & Kasir untuk 5 Cabang
        foreach ($namaCabang as $nama) {
            $slug = strtolower($nama);
            $cabangId = $cabangIds[$nama];

            // Kepala Cabang
            User::create([
                'name' => "Kepala Cabang $nama",
                'email' => "kepala{$slug}@grandcitra.com",
                'password' => $password,
                'role' => 'kepala_cabang',
                'cabang_id' => $cabangId,
            ]);

            // Kasir
            User::create([
                'name' => "Kasir Cabang $nama",
                'email' => "kasir{$slug}@grandcitra.com",
                'password' => $password,
                'role' => 'kasir',
                'cabang_id' => $cabangId,
            ]);
        }
    }
}
