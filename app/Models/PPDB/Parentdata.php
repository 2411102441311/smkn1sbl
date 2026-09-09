<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentData extends Model
{
    use HasFactory;

    protected $table = 'ppdb_parents';

    protected $fillable = [
        'registration_id',

        // Data Ayah
        'father_name',
        'father_nik',
        'father_phone',
        'father_occupation',

        // Data Ibu
        'mother_name',
        'mother_nik',
        'mother_phone',
        'mother_occupation',

        // Data Wali
        'has_guardian',
        'guardian_relationship',
        'guardian_name',
        'guardian_nik',
        'guardian_phone',
        'guardian_occupation',
    ];

    protected $casts = [
        'has_guardian' => 'boolean',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }
}