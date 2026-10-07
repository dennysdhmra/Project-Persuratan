<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'no_surat',
        'tujuan_surat',
        'perihal',
        'tanggal_surat',
        'sifat_surat',
        'klasifikasi_kode',
        'ringkasan_isi',
        'isi_surat',
        'file_lampiran',
        'status',
        'konseptor_id',
        'paraf_kabid_by',
        'paraf_kabid_at',
        'paraf_kabid_catatan',
        'tte_kapus_by',
        'tte_kapus_at',
        'tte_kapus_catatan',
        'qr_code_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'paraf_kabid_at' => 'datetime',
            'tte_kapus_at' => 'datetime',
        ];
    }

    public function konseptor()
    {
        return $this->belongsTo(User::class, 'konseptor_id');
    }

    public function parafKabid()
    {
        return $this->belongsTo(User::class, 'paraf_kabid_by');
    }

    public function tteKapus()
    {
        return $this->belongsTo(User::class, 'tte_kapus_by');
    }

    public function klasifikasi()
    {
        return $this->belongsTo(MasterKlasifikasi::class, 'klasifikasi_kode', 'kode');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Draft Konsep' => 'status-gray',
            'Review Staf' => 'status-blue',
            'Menunggu Paraf Kabid' => 'status-amber',
            'Menunggu TTE Kapus' => 'status-purple',
            'Disetujui/TTE' => 'status-emerald',
            'Terkirim' => 'status-teal',
            default => 'status-gray'
        };
    }

    public function getStepIndexAttribute(): int
    {
        return match ($this->status) {
            'Draft Konsep' => 1,
            'Review Staf' => 2,
            'Menunggu Paraf Kabid' => 3,
            'Menunggu TTE Kapus' => 4,
            'Disetujui/TTE' => 5,
            'Terkirim' => 6,
            default => 1
        };
    }
}
