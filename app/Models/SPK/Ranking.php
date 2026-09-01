<?php

namespace App\Models\SPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ranking extends Model
{
    use HasFactory;

    protected $table = 'spk_rankings';

    protected $fillable = ['alternative_id', 'final_score', 'rank_position', 'method', 'calculated_at'];

    protected $casts = [
        'calculated_at' => 'datetime',
    ];

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }
}
