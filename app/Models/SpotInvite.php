<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotInvite extends Model
{
    use HasFactory;
    protected $table = 'spot_invites';
    protected $fillable = [
        'spot_id',
        'from_user_id',
        'invited_user_id'
    ];
}
