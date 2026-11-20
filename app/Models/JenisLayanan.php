<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisLayanan extends Model
{
    protected $table = 'jenis_layanan';
    protected $fillable = ['nama', 'tarif', 'keterangan'];

    public function detailServis(): HasMany
    {
        return $this->hasMany(DetailServis::class);
    }
}
