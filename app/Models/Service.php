<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan',
        'kategori',
        'harga_per_kg',
        'harga_satuan',
        'estimasi_waktu',
        'deskripsi'
    ];

    protected $casts = [
        'harga_per_kg' => 'double',
        'harga_satuan' => 'double',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'layanan_id');
    }
}
