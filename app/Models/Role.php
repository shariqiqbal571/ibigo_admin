<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = ['role'];
    public function role_permissions(){
        return $this->hasMany('App\Models\RolePermission','role_id','id');
    }
}
