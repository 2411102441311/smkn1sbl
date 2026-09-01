<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'ppdb_registrations';

    protected $fillable = ['registration_number', 'user_id', 'status'];

    protected static function booted()
    {
        static::creating(function (Registration $registration) {
            if (empty($registration->registration_number)) {
                $registration->registration_number = 'PPDB-' . date('Y') . '-'
                    . str_pad((string) (static::max('id') + 1), 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function biodata(): HasOne
    {
        return $this->hasOne(Biodata::class, 'registration_id');
    }

    public function parentData(): HasOne
    {
        return $this->hasOne(ParentData::class, 'registration_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'registration_id');
    }

    public function reportCards(): HasMany
    {
        return $this->hasMany(ReportCard::class, 'registration_id');
    }

    public function majorChoices(): HasMany
    {
        return $this->hasMany(MajorChoice::class, 'registration_id')->orderBy('choice_order');
    }

    public function sawResult(): HasOne
    {
        return $this->hasOne(SawResult::class, 'registration_id')->latestOfMany();
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}