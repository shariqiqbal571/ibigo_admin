<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostStatus extends Model
{
    use HasFactory;
    protected $table = 'post_statuses';
    protected $fillable = [
        'post_id',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select(
            'id',
            'user_profile',
            'user_slug',
            'unique_id',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
        );
    }

    public function userStatus()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select(
            'id',
            'user_profile',
            'user_slug',
            'unique_id',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
        )->limit(2);
    }
}
