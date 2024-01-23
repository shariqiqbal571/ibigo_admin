<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupUser extends Model
{
    use HasFactory;
    protected $table = 'group_users';
    protected $fillable = [
        'user_id',
        'group_id',
        'invited_by',
        'group_status',
        'is_admin'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')
        ->select([
            'id',
            'user_profile',
            'user_slug',
            'user_status',
            'unique_id',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")]
        );
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group','group_id','id');
    }
}
