<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Branch;
use App\Models\User;
use App\Models\Product;
use App\Models\Stok;
use App\Models\Pelanggan;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Cabang
        $cabang1 = Branch::firstOrCreate(
            ['nama' => 'Cabang Sudirman'],
            ['alamat' => 'Jl. Jendral Sudirman No. 1', 'telepon' => '0811111111']
        );

        $cabang2 = Branch::firstOrCreate(
            ['nama' => 'Cabang Thamrin'],
            ['alamat' => 'Jl. MH Thamrin No. 2', 'telepon' => '0822222222']
        );

        // 2. Buat Users
        // Admin Pusat
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Pusat', 'password' => Hash::make('password'), 'role' => 'admin_pusat']
        );

        // Manager
        User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            ['name' => 'Manager Operasional', 'password' => Hash::make('12345678'), 'role' => 'manager']
        );

        // Kepala Cabang
        User::updateOrCreate(
            ['email' => 'kepala@gmail.com'],
            ['name' => 'Kepala Cabang Sudirman', 'password' => Hash::make('password'), 'role' => 'kepala_cabang', 'cabang_id' => $cabang1->id]
        );

        // Kasir
        User::updateOrCreate(
            ['email' => 'kasir@gmail.com'],
            ['name' => 'Kasir Cabang Sudirman', 'password' => Hash::make('password'), 'role' => 'kasir', 'cabang_id' => $cabang1->id]
        );

        // 3. Buat Barang Master
        $barang1 = Product::firstOrCreate(
            ['kode' => 'BRG-001'],
            ['nama' => 'Pakaian Dinas Pria', 'kategori' => 'Pakaian', 'harga' => 150000, 'deskripsi' => 'Pakaian dinas lengan panjang']
        );

        $barang2 = Product::firstOrCreate(
            ['kode' => 'BRG-002'],
            ['nama' => 'Sepatu Pantofel', 'kategori' => 'Sepatu', 'harga' => 350000, 'deskripsi' => 'Sepatu pantofel kulit asli']
        );
        
        $barang3 = Product::firstOrCreate(
            ['kode' => 'BRG-003'],
            ['nama' => 'Tas Kerja', 'kategori' => 'Aksesoris', 'harga' => 250000, 'deskripsi' => 'Tas selempang pria']
        );

        // 4. Buat Stok untuk Cabang 1
        Stok::firstOrCreate(
            ['barang_id' => $barang1->id, 'cabang_id' => $cabang1->id],
            ['jumlah' => 10, 'stok_minimum' => 5]
        );

        Stok::firstOrCreate(
            ['barang_id' => $barang2->id, 'cabang_id' => $cabang1->id],
            ['jumlah' => 3, 'stok_minimum' => 5] // Stok menipis
        );

        // 5. Buat Pelanggan
        Pelanggan::firstOrCreate(
            ['telepon' => '08123456789'],
            ['nama' => 'Budi Santoso', 'alamat' => 'Jl. Kebon Kacang No. 3', 'is_member' => true]
        );
    }
}
