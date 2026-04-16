<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_produk',
        'harga',
        'gambar',
        'keterangan',
    ];

    public function stok()
    {
        return $this->hasOne(Stok::class, 'produk_id');
    }

}