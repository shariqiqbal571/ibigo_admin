<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    use HasFactory;
    protected $table = 'social_logins';
    protected $fillable = [
        'user_id',
        'provider_id',
        'provider'
    ];
}
