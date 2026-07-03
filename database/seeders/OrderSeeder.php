<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        $services = Service::all();
        if ($services->isEmpty()) return;

        $statuses = ['diterima', 'diproses', 'selesai', 'diambil'];
        
        $customerNames = ['Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Dewi Lestari', 'Agus Pratama', 'Rina Melati', 'Joko Susanto', 'Maya Sari'];

        // Create 20 random orders
        for ($i = 0; $i < 20; $i++) {
            $service = $services->random();
            $status = $statuses[array_rand($statuses)];
            
            // Random date between 7 days ago and today
            $daysAgo = rand(0, 7);
            $tanggalMasuk = Carbon::today()->subDays($daysAgo);
            
            $estimasiSelesai = clone $tanggalMasuk;
            // Parse estimasi waktu string like "2 hari" to get number
            $daysToAdd = (int) filter_var($service->estimasi_waktu, FILTER_SANITIZE_NUMBER_INT);
            if ($daysToAdd > 0) {
                $estimasiSelesai->addDays($daysToAdd);
            } else {
                $estimasiSelesai->addDays(2);
            }

            $order = [
                'user_id' => $admin->id,
                'layanan_id' => $service->id,
                'nama_pelanggan' => $customerNames[array_rand($customerNames)],
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'status' => $status,
                'tanggal_masuk' => $tanggalMasuk,
                'estimasi_selesai' => $estimasiSelesai,
                'catatan' => rand(0, 1) ? 'Mohon jangan dicampur pakaian putih' : null,
            ];

            if ($service->harga_per_kg) {
                $berat = rand(20, 105) / 10; // 2.0 to 10.5 kg
                $order['berat_kg'] = $berat;
                $order['jumlah'] = null;
                $order['total_harga'] = $berat * $service->harga_per_kg;
            } else {
                $jumlah = rand(1, 5);
                $order['berat_kg'] = null;
                $order['jumlah'] = $jumlah;
                $order['total_harga'] = $jumlah * $service->harga_satuan;
            }

            Order::create($order);
        }
    }
}
