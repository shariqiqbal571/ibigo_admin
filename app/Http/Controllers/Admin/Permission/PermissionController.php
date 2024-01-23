<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
class PermissionController extends Controller
{
   public function index()
   {
        $permissions = Permission::paginate(10);
        return view('admin/permission/view')->with(compact('permissions'));
   }
}
