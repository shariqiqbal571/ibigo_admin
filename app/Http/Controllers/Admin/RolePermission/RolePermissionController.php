<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;


class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $rolePermission = RolePermission::paginate(10);
       return view('admin/rolepermission/view')->with(compact('rolePermission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $roles =  Role::all();
       $permissions = Permission::all();
        // $role_permission = RolePermission::with(['role','permission'])->get()->toArray();
        // echo "<pre>";
        // print_r($role_permission);
        // exit();
       return view('admin/rolepermission/add')->with(compact('roles','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->permission_id as $permission_id){
            $rolePermission = new RolePermission;
            $rolePermission->role_id = $request->role_id;
            $rolePermission->permission_id = $permission_id;
            $rolePermission->save();
        }
        return redirect('/admin/role_permission')->with('message', 'Permission has been successfully given!');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RolePermission::find($id)->delete();
        return redirect('/admin/role_permission');
    }
}
