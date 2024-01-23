<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    use HasFactory;
    protected $table = 'user_follows';
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'follow'
    ];
}
