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
        'father_name', 'father_nik', 'father_phone', 'father_occupation',
        'mother_name', 'mother_nik', 'mother_phone', 'mother_occupation',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }
}