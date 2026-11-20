<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = ['nama', 'no_hp', 'alamat'];

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class);
    }
}
