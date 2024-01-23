<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;


class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    
    protected $fillable = [
        'user_id',
        'group_name',
        'group_slug',
        'group_unique_id',
        'group_description',
        'group_profile',
        'group_cover'
    ];

    public function adminGroup(){
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(
            'id',
            'user_profile',
            'user_slug',
            'user_status',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
        );
    }

    public function groupStatus()
    {
        return $this->hasMany('App\Models\GroupUser','group_id','id');
    }

    public function groupUsers()
    {
        return $this->hasMany('App\Models\GroupUser','group_id','id')
        ->select(['group_id','user_id','is_admin'])
        ->where('group_status',3);
    }

    public function members()
    {
        return $this->hasMany('App\Models\GroupUser','group_id','id')
        ->select(['group_id','user_id','is_admin'])
        ->where('group_status',3)->where('user_id','!=',Auth::user()->id)->limit(5)->orderBy('id','DESC');
    }

    public function requestedUser()
    {
        return $this->hasMany('App\Models\GroupUser','group_id','id')
        ->select(['group_id','user_id','is_admin'])
        ->where('group_status',1);
    }

    public function post()
    {
        return $this->hasMany('App\Models\Post','group_id','id');
    }

    public function groupChat()
    {
        return $this->hasMany('App\Models\GroupChat','group_id','id')
        ->orderBy('message_date_time','desc');
    }

}
