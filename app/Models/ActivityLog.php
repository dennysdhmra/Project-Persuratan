<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function record(?int $userId, string $action, string $description): self
    {
        return static::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip() ?? '127.0.0.1',
            'created_at' => now(),
        ]);
    }
}
