<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Major;

class SawResult extends Model
{
    use HasFactory;

    protected $table = 'saw_results';

    protected $fillable = ['registration_id', 'criteria_scores', 'total_score', 'recommended_major_id'];

    protected $casts = [
        'criteria_scores' => 'array',
        'total_score' => 'float',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function recommendedMajor(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'recommended_major_id');
    }
}