<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority'
    ];

    protected $casts = [
        'status' => 'string',
        'priority' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_COMPLETED
        ];
    }

    public static function getPriorities()
    {
        return [
            self::PRIORITY_LOW,
            self::PRIORITY_MEDIUM,
            self::PRIORITY_HIGH
        ];
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status && in_array($status, self::getStatuses())) {
            return $query->where('status', $status);
        }
        return $query;
    }
}