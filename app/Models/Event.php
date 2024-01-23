<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use HasFactory;

    protected $table = "events";
    protected $fillable = [
        'event_title',
        'event_slug',
        'event_unique_id',
        'event_description',
        'event_category',
        'event_cover',
        'user_id',
        'group_id',
        'start_date_time',
        'end_date_time',
        'event_location',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group','group_id','id')
        ->select(['id','group_unique_id','group_name','group_profile','group_slug']);
    }

    public function eventInvites()
    {
        return $this->hasMany('App\Models\EventInvite','event_id','id')
        ->select(['event_id','user_id','id']);
    }

    public function connectedPeople()
    {
        return $this->hasMany('App\Models\EventInvite','event_id','id')
        ->where('connected',1);
    }
}
