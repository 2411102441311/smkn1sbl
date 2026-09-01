<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'image_path', 'caption'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
