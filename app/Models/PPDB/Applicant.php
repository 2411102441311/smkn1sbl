<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number', 'full_name', 'nisn', 'email', 'phone',
        'address', 'previous_school', 'chosen_major',
    ];

    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    protected static function booted()
    {
        static::creating(function (Applicant $applicant) {
            if (empty($applicant->registration_number)) {
                $applicant->registration_number = 'PPDB-' . date('Y') . '-' . str_pad((string) (static::max('id') + 1), 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
