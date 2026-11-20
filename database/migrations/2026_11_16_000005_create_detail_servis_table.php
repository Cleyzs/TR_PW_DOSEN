<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_servis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_servis_id')->constrained('transaksi_servis')->cascadeOnDelete();
            $table->foreignId('jenis_layanan_id')->constrained('jenis_layanan')->restrictOnDelete();
            $table->unsignedInteger('harga');          // tarif saat transaksi dibuat
            $table->unsignedSmallInteger('jumlah')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_servis');
    }
};
