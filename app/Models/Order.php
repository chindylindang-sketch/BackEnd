<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'layanan_id',
        'nama_pelanggan',
        'no_hp',
        'berat_kg',
        'jumlah',
        'total_harga',
        'status',
        'tanggal_masuk',
        'estimasi_selesai',
        'catatan'
    ];

    protected $casts = [
        'berat_kg' => 'double',
        'jumlah' => 'integer',
        'total_harga' => 'double',
        'tanggal_masuk' => 'date',
        'estimasi_selesai' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'layanan_id');
    }

    // Alias for the frontend which expects 'layanan'
    public function layanan()
    {
        return $this->belongsTo(Service::class, 'layanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            if (!$order->total_harga && $order->layanan_id) {
                $service = Service::find($order->layanan_id);
                if ($service) {
                    if ($service->harga_per_kg && $order->berat_kg) {
                        $order->total_harga = $service->harga_per_kg * $order->berat_kg;
                    } elseif ($service->harga_satuan && $order->jumlah) {
                        $order->total_harga = $service->harga_satuan * $order->jumlah;
                    }
                }
            }
        });
    }
}
