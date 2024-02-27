<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'perfil',
        'userResponse',
        'card_id',
        'user_id',
    ];

}
