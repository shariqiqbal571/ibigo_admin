<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SpotDetail extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }

    public function spot()
    {
        return $this->belongsTo('App\Models\Spot','spot_id','id')
        ->select([
            'id',
            'user_id',
            'spot_profile',
            'business_name',
            'latitude',
            'longitude',
            'short_description',
            DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
        ]);
    }

    public function spotDetailPhotos()
    {
        return $this->hasMany('App\Models\SpotDetailPhoto','spot_detail_id','id');
    }

    public function spotDetailVideos()
    {
        return $this->hasMany('App\Models\SpotDetailVideo','spot_detail_id','id');
    }

    protected $table = 'spot_details';
    protected $fillable = [
        'spot_id',
        'user_id',
        'rating',
        'review',
        'connected',
        'like',
        'invited_users_id',
        'review_date_time',
    ];
}
