<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegacyRegistration extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'applicant_id',
        'wave',
        'registration_date',
        'status',
        'notes',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
