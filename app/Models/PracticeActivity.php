<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'practice_profile_id',
        'activity_type',
        'reference_type',
        'reference_id',
        'practiced_on',
        'meta',
    ];

    protected $casts = [
        'practiced_on' => 'date',
        'meta' => 'array',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(PracticeProfile::class, 'practice_profile_id');
    }
}
