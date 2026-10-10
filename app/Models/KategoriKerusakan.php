<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKerusakan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'icon'];

    /** @return HasMany<Pengaduan, $this> */
    public function pengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class);
    }
}
