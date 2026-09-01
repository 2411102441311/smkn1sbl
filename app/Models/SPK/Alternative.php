<?php

namespace App\Models\SPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'spk_alternatives';

    protected $fillable = ['code', 'name', 'description'];

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'alternative_id');
    }

    public function ranking(): HasOne
    {
        return $this->hasOne(Ranking::class, 'alternative_id')->latestOfMany('calculated_at');
    }
}
