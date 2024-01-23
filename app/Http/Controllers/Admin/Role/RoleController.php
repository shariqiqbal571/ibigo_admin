<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\UserPermission;
use App\Models\UserRole;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin/role/view')->with(compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $permissions = Permission::all();
         // $role_permission = RolePermission::with(['role','permission'])->get()->toArray();
         // echo "<pre>";
         // print_r($role_permission);
         // exit();
        return view('admin/role/add')->with(compact('permissions'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required', 
            
        ]);

        if($validator->passes())
        {

        $role = new Role;
        $role->role=$request->name;
        $role->save();
        $role_id = $role->id;
        if($request->permission_id){
        foreach($request->permission_id as $permission_id){
            $rolePermission = new RolePermission;
            $rolePermission->role_id = $role_id;
            $rolePermission->permission_id = $permission_id;
            $rolePermission->save();
        }
    }

       
        $request->session()->flash('msg','Add New Roles Successfully.');
            return redirect('/admin/role');
        }
        else{
            return back()->withErrors($validator)->withInput();
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::find($id);
        $rolePermission = RolePermission::where('role_id',$id)->get()->toArray();
        $permissions = Permission::all();
        // echo '<pre>';
        // print_r($rolePermission);
        // exit();
        return view('admin/role/update')->with(compact('roles','permissions','rolePermission'));
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
        $validator = Validator::make($request->all(),[
            'name'=>'required',
        ]);
        
        if($validator->passes()){
        
            $roles = Role::find($id);
            $roles->role =$request->name;
            $roles->save();

            if($request->permission_id){
                RolePermission::where('role_id',$id)->delete();
                foreach($request->permission_id as $permission_id){
                    $rolePermission = new RolePermission;
                    $rolePermission->role_id = $id;
                    $rolePermission->permission_id = $permission_id;
                    $rolePermission->save();
                }
            }
    
            $request->session()->flash('msg','Update  Roles Successfully.');
            return redirect('/admin/role');
        }
        else{
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        RolePermission::where('role_id',$id)->delete();
        UserRole::where('role_id',$id)->delete();
        return redirect('/admin/role')->with('msg','Role delete Successfully.');
    }
}
