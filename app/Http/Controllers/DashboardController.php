<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponse;

    public function stats(Request $request)
    {
        $today = Carbon::today();

        $totalPesanan = Order::count();
        $totalPendapatan = Order::whereIn('status', ['selesai', 'diambil'])->sum('total_harga');
        
        $pesananHariIni = Order::whereDate('tanggal_masuk', $today)->count();

        // Pesanan per status
        $statusCounts = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return $this->successResponse([
            'total_pesanan' => $totalPesanan,
            'total_pendapatan' => $totalPendapatan,
            'pesanan_hari_ini' => $pesananHariIni,
            'pesanan_per_status' => [
                'diterima' => $statusCounts['diterima'] ?? 0,
                'diproses' => $statusCounts['diproses'] ?? 0,
                'selesai' => $statusCounts['selesai'] ?? 0,
                'diambil' => $statusCounts['diambil'] ?? 0,
            ],
        ], 'Statistik dashboard berhasil diambil');
    }
}
