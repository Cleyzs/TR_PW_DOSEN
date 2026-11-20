<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailServis extends Model
{
    protected $table = 'detail_servis';
    protected $fillable = ['transaksi_servis_id', 'jenis_layanan_id', 'harga', 'jumlah'];

    public function transaksiServis(): BelongsTo
    {
        return $this->belongsTo(TransaksiServis::class);
    }

    public function jenisLayanan(): BelongsTo
    {
        return $this->belongsTo(JenisLayanan::class);
    }
}
