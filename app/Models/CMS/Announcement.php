<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'start_date', 'end_date', 'is_pinned'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_pinned' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->whereDate('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', now());
            })
            ->orderByDesc('is_pinned');
    }
}
