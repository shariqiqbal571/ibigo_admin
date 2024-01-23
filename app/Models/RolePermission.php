<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;

class RolePermission extends Model
{
    use HasFactory;
    protected $table = 'role_permissions';
    protected $fillable = ['role_id','permission_id'];

    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id','id');
    }

    public function permission()
    {
        return $this->belongsTo('App\Models\Permission','permission_id','id');
    }
}
