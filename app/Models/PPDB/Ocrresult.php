<?php

namespace App\Models\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OcrResult extends Model
{
    use HasFactory;

    protected $table = 'ocr_results';

    protected $fillable = [
        'report_card_id', 'raw_text', 'extracted_data', 'confidence_score', 'is_confirmed',
    ];

    protected $casts = [
        'extracted_data' => 'array',   // otomatis json_encode/decode ke array asosiatif {mapel: nilai}
        'is_confirmed' => 'boolean',
        'confidence_score' => 'float',
    ];

    public function reportCard(): BelongsTo
    {
        return $this->belongsTo(ReportCard::class, 'report_card_id');
    }

    /**
     * Ambil nilai 1 mapel tertentu dari hasil ekstraksi, atau null kalau tidak ketemu.
     */
    public function getGrade(string $subject): ?float
    {
        return $this->extracted_data[$subject] ?? null;
    }
}