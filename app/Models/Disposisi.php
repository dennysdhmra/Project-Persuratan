<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';

    protected $fillable = [
        'surat_masuk_id',
        'dari_user_id',
        'kepada_user_id',
        'instruksi',
        'catatan_disposisi',
        'batas_waktu',
        'status',
        'tanggapan_pegawai',
        'file_laporan',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'instruksi' => 'array',
            'batas_waktu' => 'date',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function pemberi()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'kepada_user_id');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Menunggu' => 'status-amber',
            'Sedang Dikerjakan' => 'status-blue',
            'Selesai' => 'status-emerald',
            default => 'status-gray'
        };
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'Selesai' || !$this->batas_waktu) {
            return false;
        }
        return now()->gt($this->batas_waktu->endOfDay());
    }
}
