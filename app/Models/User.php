<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    public function toFriendsRelation()
    {
        return $this->hasMany('App\Models\FriendRelation','to_user_id','id')
        ->where('relation_status',1);
    }

    public function fromFriendsRelation()
    {
        return $this->hasMany('App\Models\FriendRelation','from_user_id','id')
        ->where('relation_status',1);
    }

    public function to()
    {
        return $this->hasMany('App\Models\FriendRelation','to_user_id','id');
    }

    public function from()
    {
        return $this->hasMany('App\Models\FriendRelation','from_user_id','id');
    }

    public function interest()
    {
        return $this->belongsTo('App\Models\Interest','user_interests','id');
    }

    public function post()
    {
        return $this->hasMany('App\Models\Post','user_id','id');
    }

    public function event()
    {
        return $this->hasMany('App\Models\Event','user_id','id');
    }

    public function group()
    {
        return $this->hasMany('App\Models\Group','user_id','id');
    }

    public function spotDetail()
    {
        return $this->hasMany('App\Models\SpotDetail','user_id','id');
    }

    public function spot()
    {
        return $this->hasMany('App\Models\Spot','user_id','id');
    }

    public function userExpertise()
    {
        return $this->hasMany('App\Models\UserExpertise','user_id','id');
    }

    public function likeSpot(){
        return $this->hasMany('App\Models\SpotDetail','user_id','id')
        ->where('like',1)->limit(4);
    }

    public function reviewSpotsAll(){
        return $this->hasMany('App\Models\SpotDetail','user_id','id')
        ->where('rating','!=',null);
    }

    public function reviewSpot(){
        return $this->hasMany('App\Models\SpotDetail','user_id','id')
        ->where('rating','!=',null)->limit(4);
    }

    public function photosVideos()
    {
        return $this->hasMany('App\Models\SpotDetail','user_id','id')->limit(4);
    }

    public function followers()
    {
        return $this->hasMany('App\Models\UserFollow','to_user_id','id')
        ->where('follow',1);
    }

    public function followings()
    {
        return $this->hasMany('App\Models\UserFollow','from_user_id','id')
        ->where('follow',1);
    }

    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id', // random
        'first_name', //post
        'last_name', //post
        'username', //post
        'user_slug',  // first name and lasst name
        'birth_date', //post
        'user_profile', //post
        'user_cover', //post
        'user_about', //post
        'city', //post
        'full_address', //post
        'user_status', //default 0
        'country_code', //post
        'country_short_code', //post
        'mobile', //post
        'mobile_verified_at', //post
        'mobile_opt', //post
        'gender', //post
        'user_interests', //post
        'user_type', //post
        'email', //post
        'user_api_token',
        'password', //post
        'accept_email', //post
        'terms_conditions', //post
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
