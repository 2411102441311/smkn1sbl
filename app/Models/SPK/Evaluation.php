<?php

namespace App\Models\SPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'spk_evaluations';

    protected $fillable = ['alternative_id', 'criteria_id', 'value'];

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
