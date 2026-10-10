<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'user_id',
        'kategori_kerusakan_id',
        'lokasi_id',
        'tanggal_kejadian',
        'deskripsi',
        'foto',
        'video',
        'status',
        'catatan_admin',
        'ditangani_oleh',
        'selesai_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kejadian' => 'date',
            'selesai_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<KategoriKerusakan, $this> */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKerusakan::class, 'kategori_kerusakan_id');
    }

    /** @return BelongsTo<Lokasi, $this> */
    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }

    /** @return BelongsTo<User, $this> */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'diajukan' => 'bg-blue-50 text-blue-700 ring-blue-200',
            'diproses' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'selesai' => 'bg-green-50 text-green-700 ring-green-200',
            'ditolak' => 'bg-red-50 text-red-700 ring-red-200',
            default => 'bg-gray-50 text-gray-700 ring-gray-200',
        };
    }
}
