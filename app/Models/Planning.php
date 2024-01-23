<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Planning extends Model
{
    use HasFactory;
    protected $table = 'plannings';
    protected $fillable = [
        'planning_title',
        'planning_description',
        'user_id',
        'event_id',
        'spot_id',
        'start_date_time',
        'end_date_time',
        'is_liked'
    ];

    public function inviteUser()
    {
        return $this->hasMany('App\Models\PlanningInvitation','planning_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event','event_id','id')
        ->select(['id','event_location','event_unique_id','event_title','event_description','event_slug','event_cover','start_date_time','end_date_time']);
    }

    public function spot()
    {
        return $this->belongsTo('App\Models\Spot','spot_id','id')->select([
            'id',
            'user_id',
            'spot_profile',
            'business_name',
            'short_description',
            'latitude',
            'longitude',
            DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
        ]);;
    }
}
