<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /** @return array<string, string> */
    public function optionsForQuiz(): array
    {
        return [
            'A' => $this->option_a,
            'B' => $this->option_b,
            'C' => $this->option_c,
            'D' => $this->option_d,
        ];
    }

    /** @return array{topic: string, text: string, options: array<string, string>, answer: string, explain: string} */
    public function toQuizArray(): array
    {
        return [
            'topic' => $this->topic,
            'text' => $this->question,
            'options' => $this->optionsForQuiz(),
            'answer' => $this->correct_answer,
            'explain' => $this->explanation,
        ];
    }
}
