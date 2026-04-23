<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('alamat_pengiriman');
            $table->string('courier')->nullable(); // jne, pos, tiki
            $table->string('service')->nullable(); // REG, YES
            $table->integer('ongkir')->default(0);
            $table->decimal('total_harga', 12, 2);
            
            $table->json('produk_details');
            $table->timestamp('tanggal_pemesanan')->useCurrent();
            $table->enum('metode_pembayaran', ['transfer', 'cod']);
            $table->enum('status_pembayaran', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->enum('status', [
                'menunggu_konfirmasi',
                'diproses',
                'dikirim',
                'selesai'
            ])->default('menunggu_konfirmasi');
            $table->string('bukti_transfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};