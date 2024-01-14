<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sutraes extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'language_id',
        'athor_id',
        'type_id',
        'image',
    ];
}
