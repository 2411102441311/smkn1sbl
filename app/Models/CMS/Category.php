<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type'];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
