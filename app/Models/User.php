<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
        'role',
        'status',
        'sso_provider',
        'sso_id',
        'sso_avatar',
        'jabatan',
        'unit_kerja',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    public function isKabid(): bool
    {
        return $this->role === 'kepala_bidang';
    }

    public function isKapus(): bool
    {
        return $this->role === 'kepala_pusat';
    }

    public function isPimpinan(): bool
    {
        return in_array($this->role, ['kepala_bidang', 'kepala_pusat']);
    }

    public function isActive(): bool
    {
        return ($this->status ?? 'active') === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    public function canTte(): bool
    {
        return $this->role === 'kepala_pusat';
    }

    public function canParaf(): bool
    {
        return in_array($this->role, ['kepala_bidang', 'kepala_pusat']);
    }

    public function canKonsep(): bool
    {
        return true; // All registered officers can draft
    }

    public function canDisposisi(): bool
    {
        return in_array($this->role, ['kepala_pusat', 'kepala_bidang']);
    }

    public function canManageUsers(): bool
    {
        return $this->role === 'admin';
    }

    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'bg-purple-100 text-purple-800 border-purple-300',
            'pegawai' => 'bg-blue-100 text-blue-800 border-blue-300',
            'kepala_bidang' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            'kepala_pusat' => 'bg-amber-100 text-amber-800 border-amber-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status ?? 'active') {
            'active' => 'bg-success bg-opacity-10 text-success border-success',
            'pending' => 'bg-warning bg-opacity-10 text-warning border-warning',
            'suspended' => 'bg-danger bg-opacity-10 text-danger border-danger',
            default => 'bg-secondary bg-opacity-10 text-secondary'
        };
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator Persuratan',
            'pegawai' => 'Staf / Pegawai PKST',
            'kepala_bidang' => 'Kepala Bidang (Kabid)',
            'kepala_pusat' => 'Kepala Pusat (Kapus)',
            default => ucfirst($this->role)
        };
    }

    public function disposisiDiterima()
    {
        return $this->hasMany(Disposisi::class, 'kepada_user_id');
    }

    public function disposisiDiberikan()
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    public function suratKeluarDikonsep()
    {
        return $this->hasMany(SuratKeluar::class, 'konseptor_id');
    }
}
