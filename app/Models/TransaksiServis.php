<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiServis extends Model
{
    protected $table = 'transaksi_servis';
    protected $fillable = [
        'kendaraan_id', 'tanggal', 'keluhan',
        'status', 'total_biaya', 'status_pembayaran',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function detailServis(): HasMany
    {
        return $this->hasMany(DetailServis::class);
    }
}
