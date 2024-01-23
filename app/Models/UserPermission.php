<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;
    protected $table = 'user_permissions';
    protected $fillable = ['user_id','permission_id'];

    public function permission()
    {
        return $this->belongsTo('App\Models\Permission','permission_id','id');
    }
}

