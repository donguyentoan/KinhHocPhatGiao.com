<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_key',
        'dharma_name',
        'last_seen_at',
        'intro_completed_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'intro_completed_at' => 'datetime',
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(PracticeActivity::class);
    }
}
