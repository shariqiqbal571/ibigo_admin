<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventInvite extends Model
{
    use HasFactory;
    protected $table = 'event_invites';
    protected $fillable = [
        'event_id',
        'user_id',
        'group_id',
        'share_spot_id',
        'connected'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }
}
