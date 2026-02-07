<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gudang;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Admin Utama
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@stok.com',
            'password' => bcrypt('admin123'),
            // Kamu bisa tambah kolom 'role' jika nanti ada pemisahan wewenang
        ]);

        // 2. Buat Contoh Gudang
        Gudang::create(['nama_gudang' => 'Gudang Pusat']);
        Gudang::create(['nama_gudang' => 'Gudang Toko']);

        // 3. Buat Contoh Item
        Item::create([
            'item_code' => 'BRG001',
            'item_name' => 'F BL Item',
            'item_type' => 'Bahan',
            'unit' => 'pcs'
        ]);

        $this->command->info('Seed data berhasil masuk!');
    }
}