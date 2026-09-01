<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PPDB\MajorChoice;
use App\Models\PPDB\SawResult;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'code', 'name', 'description', 'capacity',
        'icon', 'logo', 'color_from', 'color_to',
    ];

    public function choices(): HasMany
    {
        return $this->hasMany(MajorChoice::class);
    }

    public function sawResults(): HasMany
    {
        return $this->hasMany(SawResult::class, 'recommended_major_id');
    }

    /**
     * Cek apakah kuota jurusan ini masih tersedia (dihitung dari pendaftar yang sudah diterima).
     */
    public function isFull(): bool
    {
        $accepted = $this->choices()
            ->whereHas('registration', fn ($q) => $q->where('status', 'accepted'))
            ->count();

        return $accepted >= $this->capacity;
    }
}