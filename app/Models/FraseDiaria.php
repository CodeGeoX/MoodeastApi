<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraseDiaria extends Model
{
    use HasFactory;
    protected $fillable = [
        'frase',
    ];
}
