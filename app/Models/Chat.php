<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'message_type',
        'message_date_time',
        'is_read',
        'user_chat_delete'
    ];

    public function fromUser()
    {
        return $this->belongsTo('App\Models\User','from_user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }

    public function toUser()
    {
        return $this->belongsTo('App\Models\User','to_user_id','id')
        ->select(['id','unique_id','user_slug','user_profile',
        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]);
    }
}
