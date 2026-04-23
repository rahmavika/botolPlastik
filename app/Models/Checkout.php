<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    /** @use HasFactory<\Database\Factories\CheckoutFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'alamat_pengiriman',
        'courier',
        'service',
        'ongkir',
        'total_harga',
        'produk_details',
        'tanggal_pemesanan',
        'metode_pembayaran',
        'status_pembayaran',
        'status',
        'bukti_transfer',
    ];

    protected $casts = [
        'produk_details' => 'array',
        'tanggal_pemesanan' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}