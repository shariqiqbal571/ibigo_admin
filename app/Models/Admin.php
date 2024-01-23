<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    
   protected $table = 'admins';
   protected $fillable = ['name','email','password','avatar'];

    public function userRole(){
        return $this->hasMany('App\Models\UserRole','user_id','id');
    }
    
    public function userPermission(){
        return $this->hasMany('App\Models\UserPermission','user_id','id');
    }

    // admin table
}
