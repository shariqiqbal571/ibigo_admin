<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spot extends Model
{
    use HasFactory;

    public function userSpot()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(['id','unique_id','user_slug','user_profile','user_cover','user_interests']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function spotDetail()
    {
        return $this->hasMany('App\Models\SpotDetail','spot_id','id');
    }

    public function spotUserReview()
    {
        return $this->hasMany('App\Models\SpotDetail','spot_id','id')
        ->select(['id','user_id','spot_id','rating']);
    }

    public function likeSpot(){
        return $this->hasMany('App\Models\SpotDetail','spot_id','id')
        ->where('like',1);
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\SpotDetail','spot_id','id')
        ->where('review','!=',null);
    }

    public function connected()
    {
        return $this->hasMany('App\Models\SpotDetail','spot_id','id')
        ->select(['id','spot_id','connected'])->where('connected',1);
    }

    public function likesSpot(){
        return $this->hasMany('App\Models\SpotDetail','spot_id','id')
        ->where('like',1)->limit(4);
    }

    public function ratings(){
        return $this->hasMany('App\Models\SpotDetail','spot_id','id')
        ->where('rating','!=',null);
    }

    public function ownerImages()
    {
        return $this->hasMany('App\Models\SpotImage','spot_id','id');
    }

    public function ownerVideos()
    {
        return $this->hasMany('App\Models\SpotVideo','spot_id','id');
    }

    protected $table = "spots";
    protected $fillable = [
        'user_id',
        'street_no',
        'postal_code',
        'city',
        'spot_profile',
        'spot_cover',
        'latitude',
        'longitude',
        'phone_number',
        'business_name',
        'short_description',
        'parking_details',
        'place_id',
        'rating',
        'user_total_rating',
        'business_type'
    ];
}
