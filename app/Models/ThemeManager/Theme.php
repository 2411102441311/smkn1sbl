<?php

namespace App\Models\ThemeManager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'primary_color', 'secondary_color', 'accent_color', 'hero_image', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ThemeSchedule::class);
    }

    public static function active(): ?self
    {
        return static::where('is_active', true)->first();
    }

    public function activate(): void
    {
        static::query()->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }
}
