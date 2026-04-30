<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Branch;
use App\Models\Cabang; // Pastikan menggunakan nama model yang benar. Kita pakai DB langsung untuk aman jika model belum di load.
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// 1. Bersihkan Data User Lama (Agar rapi sesuai request)
DB::table('users')->delete();

// 2. Setup 5 Cabang (Jika belum ada)
$namaCabang = ['Solok', 'Padang', 'Bukittinggi', 'Payakumbuh', 'Pariaman'];
$cabangIds = [];

foreach ($namaCabang as $index => $nama) {
    // Karena saya tidak yakin apakah modelnya Branch atau Cabang, saya pakai query builder
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

$password = Hash::make('password123'); // Password default seragam

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

echo "Berhasil membuat 1 Admin Pusat, 1 Manager, dan masing-masing Kepala Cabang & Kasir untuk 5 Cabang!\n";
