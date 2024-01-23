<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'post_id',
        'from_user_id',
        'to_user_id',
        'group_id',
        'invited_spot_id',
        'invited_group_id',
        'invited_event_id',
        'invited_planning_id',
        'notification_type',
        'notification_time',
        'notification_read',
        'is_read'
    ];

    public function spot()
    {
        return $this->belongsTo('App\Models\Spot','invited_spot_id','id')
        ->select([
            'id',
            'user_id',
            'business_name',
        ]);
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event','invited_event_id','id')
        ->select([
            'id',
            'event_title',
            'event_slug',
            'event_unique_id',
        ]);
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group','invited_group_id','id')
        ->select([
            'id',
            'group_name',
            'group_slug',
            'group_unique_id',
            'group_profile',
            'group_cover'
        ]);
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post','post_id','id')
        ->select([
            'id',
            'description'
        ]);
    }

    public function fromUser()
    {
        return $this->belongsTo('App\Models\User','from_user_id','id')
        ->select(['id','unique_id','username','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }
}
