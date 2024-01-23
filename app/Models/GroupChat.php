<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupChat extends Model
{
    use HasFactory;
    protected $table = 'group_chats';
    protected $fillable = [
        'group_id','user_id','message','message_date_time','is_read'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select(
            'id',
            'user_profile',
            'user_slug',
            'user_status',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
        );
    }
}
