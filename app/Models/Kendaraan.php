<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $fillable = ['pelanggan_id', 'no_polisi', 'merek', 'tipe', 'tahun'];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transaksiServis(): HasMany
    {
        return $this->hasMany(TransaksiServis::class);
    }
}
