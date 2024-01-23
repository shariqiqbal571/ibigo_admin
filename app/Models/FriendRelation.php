<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRelation extends Model
{
    use HasFactory;

    protected $table = 'friend_relations';
    protected $fillable = ['from_user_id','to_user_id','relation_status'];
    protected $guarded = ['id'];
    
}
