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
        Schema::create('logstoks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('produk_id');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logstoks');
    }
};