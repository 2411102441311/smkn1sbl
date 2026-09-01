<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biodata extends Model
{
    use HasFactory;

    protected $table = 'ppdb_biodata';

    protected $fillable = [
        'registration_id', 'nik', 'family_card_number', 'name', 'place_of_birth', 'date_of_birth',
        'gender', 'height_cm', 'weight_kg', 'religion', 'address', 'school_origin',
        'has_kip', 'kip_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'has_kip' => 'boolean',
        'height_cm' => 'float',
        'weight_kg' => 'float',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }
}