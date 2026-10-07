<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'no_agenda',
        'no_surat_asal',
        'asal_instansi',
        'perihal',
        'tanggal_surat',
        'tanggal_diterima',
        'sifat_surat',
        'klasifikasi_kode',
        'ringkasan_isi',
        'file_lampiran',
        'status',
        'catatan_penerima',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'tanggal_diterima' => 'date',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id')->orderBy('created_at', 'desc');
    }

    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'klasifikasi_kode', 'kode');
    }

    public function getSifatBadgeClassAttribute(): string
    {
        return match ($this->sifat_surat) {
            'Sangat Segera' => 'badge-danger',
            'Segera' => 'badge-warning',
            'Rahasia' => 'badge-purple',
            default => 'badge-info'
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Baru Masuk' => 'status-blue',
            'Telah Didisposisi' => 'status-amber',
            'Sedang Ditindaklanjuti' => 'status-purple',
            'Selesai' => 'status-emerald',
            default => 'status-gray'
        };
    }
}
