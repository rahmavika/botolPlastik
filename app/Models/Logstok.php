<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logstok extends Model
{
    /** @use HasFactory<\Database\Factories\LogstokFactory> */
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'produk_id',
        'tipe',
        'jumlah',
        'keterangan',
        'created_by',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}