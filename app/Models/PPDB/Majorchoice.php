<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Major;

class MajorChoice extends Model
{
    use HasFactory;

    protected $table = 'major_choices';

    protected $fillable = ['registration_id', 'major_id', 'choice_order'];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
}