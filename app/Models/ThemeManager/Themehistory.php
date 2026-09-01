<?php

namespace App\Models\ThemeManager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ThemeHistory extends Model
{
    use HasFactory;

    protected $fillable = ['theme_id', 'applied_at', 'applied_by'];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function appliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applied_by');
    }
}