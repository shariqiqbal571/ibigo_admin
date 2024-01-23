<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlanningInvitation extends Model
{
    use HasFactory;
    protected $table = 'planning_invitations';
    protected $fillable = [
        'planning_id',
        'invite_user_id',
        'invitation_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','invite_user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }
}
