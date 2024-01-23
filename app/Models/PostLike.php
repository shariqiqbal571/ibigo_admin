<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory;
    protected $table = 'post_likes';
    protected $fillable = [
        'post_id',
        'user_id',
        'like'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select('id','unique_id','first_name','last_name');
    }
}
