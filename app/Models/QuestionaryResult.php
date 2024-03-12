<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaryResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'result', 
        'user_id', 
    ];
    
}
