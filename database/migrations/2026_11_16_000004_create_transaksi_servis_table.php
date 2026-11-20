<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_servis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->restrictOnDelete();
            $table->date('tanggal');
            $table->text('keluhan');
            // menunggu | dikerjakan | selesai
            $table->string('status', 20)->default('menunggu');
            $table->unsignedInteger('total_biaya')->default(0);
            // belum_lunas | lunas (dicatat manual)
            $table->string('status_pembayaran', 20)->default('belum_lunas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_servis');
    }
};
