<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmotionalCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'emotional_state',
        'emotions', 
        'user_id', 
    ];

    protected $casts = [
        'emotions' => 'array',
    ];
    
}
