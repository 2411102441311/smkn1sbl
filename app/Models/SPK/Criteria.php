<?php

namespace App\Models\SPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'spk_criteria';

    protected $fillable = ['code', 'name', 'type', 'weight'];

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'criteria_id');
    }
}
