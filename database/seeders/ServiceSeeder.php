<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'nama_layanan' => 'Cuci Reguler 2 Hari',
                'kategori' => 'cuci_reguler',
                'harga_per_kg' => 7000,
                'harga_satuan' => null,
                'estimasi_waktu' => '2 hari',
                'deskripsi' => 'Cuci dan setrika reguler selesai dalam 2 hari',
            ],
            [
                'nama_layanan' => 'Cuci Express 1 Hari',
                'kategori' => 'cuci_express',
                'harga_per_kg' => 10000,
                'harga_satuan' => null,
                'estimasi_waktu' => '1 hari',
                'deskripsi' => 'Layanan kilat selesai dalam 1 hari atau 24 jam',
            ],
            [
                'nama_layanan' => 'Cuci Kering Saja',
                'kategori' => 'cuci_kering',
                'harga_per_kg' => 5000,
                'harga_satuan' => null,
                'estimasi_waktu' => '1 hari',
                'deskripsi' => 'Hanya cuci dan keringkan tanpa setrika',
            ],
            [
                'nama_layanan' => 'Setrika Saja',
                'kategori' => 'setrika_saja',
                'harga_per_kg' => 5000,
                'harga_satuan' => null,
                'estimasi_waktu' => '1 hari',
                'deskripsi' => 'Hanya jasa setrika pakaian',
            ],
            [
                'nama_layanan' => 'Cuci Sepatu Premium',
                'kategori' => 'cuci_sepatu',
                'harga_per_kg' => null,
                'harga_satuan' => 35000,
                'estimasi_waktu' => '3 hari',
                'deskripsi' => 'Cuci bersih sepatu bahan kanvas, kulit, suede dll',
            ],
            [
                'nama_layanan' => 'Cuci Bedcover/Selimut',
                'kategori' => 'cuci_reguler',
                'harga_per_kg' => null,
                'harga_satuan' => 25000,
                'estimasi_waktu' => '3 hari',
                'deskripsi' => 'Layanan khusus cuci bedcover',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
