<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scripture extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'content_text',
        'content_file_path',
        'duration_minutes',
        'chant_count',
        'image_url',
        'reader_mode',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ScriptureCategory::class, 'category_id');
    }
}
