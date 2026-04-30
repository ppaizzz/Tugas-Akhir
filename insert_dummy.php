<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;

// 1. Tambah Supplier Dummy
$suppliers = [
    ['nama' => 'PT Makmur Jaya Abadi', 'kontak' => '081234567890 (Bpk. Budi)', 'alamat' => 'Jl. Industri Raya No. 12, Jakarta'],
    ['nama' => 'CV Sejahtera Sentosa', 'kontak' => '085678901234 (Ibu Susi)', 'alamat' => 'Kawasan Industri Cikarang, Bekasi'],
    ['nama' => 'Global Indo Elektronik', 'kontak' => '089876543210 (Toko Utama)', 'alamat' => 'Harco Mangga Dua, Jakarta Pusat'],
];

foreach ($suppliers as $s) {
    Supplier::firstOrCreate(['nama' => $s['nama']], $s);
}
echo "Supplier dummy berhasil ditambahkan.\n";

// 2. Pastikan ada Produk
if (Product::count() == 0) {
    $products = [
        ['kode' => 'BRG-001', 'nama' => 'Laptop ASUS ROG', 'kategori' => 'Elektronik', 'harga' => 15000000, 'deskripsi' => 'Laptop gaming asus'],
        ['kode' => 'BRG-002', 'nama' => 'Mouse Logitech Wireless', 'kategori' => 'Aksesoris', 'harga' => 150000, 'deskripsi' => 'Mouse tanpa kabel'],
        ['kode' => 'BRG-003', 'nama' => 'Keyboard Mechanical', 'kategori' => 'Aksesoris', 'harga' => 450000, 'deskripsi' => 'Keyboard bunyi cetek'],
    ];
    foreach ($products as $p) {
        Product::create($p);
    }
    echo "Produk dummy berhasil ditambahkan.\n";
} else {
    echo "Produk sudah ada, melewati penambahan produk.\n";
}

// 3. Pastikan ada akun admin pusat
$admin = User::where('role', 'admin_pusat')->first();
if (!$admin) {
    $admin = User::create([
        'name' => 'Admin Gudang Pusat',
        'email' => 'adminpusat@gcm.com',
        'password' => bcrypt('password123'),
        'role' => 'admin_pusat',
    ]);
    echo "User Admin Pusat berhasil dibuat (Email: adminpusat@gcm.com, Password: password123).\n";
} else {
    echo "User Admin Pusat sudah ada: " . $admin->email . "\n";
}

echo "\nSemua data dummy selesai dimasukkan!\n";
