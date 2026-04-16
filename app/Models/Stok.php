<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    /** @use HasFactory<\Database\Factories\StokFactory> */
    use HasFactory;
    protected $fillable = [
        'produk_id',
        'jumlah_stok',
    ];


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}