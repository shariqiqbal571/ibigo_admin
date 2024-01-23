<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use App\Models\UserPermission;
use App\Models\UserRole;
use App\Models\RolePermission;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::orderBy('id', 'desc')
        ->where('id','!=',session('admin')[0]['id'])
        ->paginate(10);
        return view('admin/view')->with(compact('admins'));
    }

    public function create()
    {
        $role = Role::all();
        $permission = Permission::all();
        return view('admin/add')->with(compact('role', 'permission'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email|unique:admins|string',
            'password' => 'required|string',
            'confirm_password' => 'required|string',

        ]);

        if($validator->passes())
        {

        $admin = new  Admin;

        if($request->confirm_password == $request->password)
        {
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        if($request->hasfile('avatar')){
            $destination = 'public/admin/profile';
            $admin_profile = $request->file('avatar');
            $adminprofile = uniqid().$admin_profile->getClientOriginalName();
            $path = $admin_profile->storeAs($destination,$adminprofile);

            $admin->avatar = $adminprofile;
        }
            $admin->save();
            $id = $admin->id;

            if($request->role_id)
            {
                foreach($request->role_id as $role_id){
                    $userRole = new UserRole;
                    $userRole->user_id = $id;
                    $userRole->role_id = $role_id;
                    $userRole->save();
                }
            }

            if($request->permission_id)
            {
            foreach($request->permission_id as $permission_id){
                $userpermission = new UserPermission;
                $userpermission->user_id = $id;
                $userpermission->permission_id = $permission_id;
                $userpermission->save();
            }
        }
            return redirect('/admin/admin-users')->with('msg','Create  admin Successfully.');
        }
            else
            {
            return back()->with('notmatchs','Password is not matching');
            }
        }
            else
            {
                return back()->withErrors($validator)->withInput();
            }

    }



    public function edit($id)
    {
        $admins = Admin::with(['userRole','userPermission'])->where('id',$id)->get()->toArray();
        // echo '<pre>';print_r($admins);exit();
        $role = Role::all();
        $permission = Permission::all();


        return view('admin/update')->with(compact('admins','role', 'permission'));

    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email|string',
            'password'=>'required',
            'confirm_password'=>'required'

        ]);
        if($validator->passes())
        {

            $admin = Admin::find($id);

            if(!Hash::check($request->old_password,$admin->password)){
                return back()->with('error','The specified password does not match.');

            }

            else{
                if($request->password ==$request->confirm_password)
                {
                    $admin->name = $request->name;
                    $admin->email = $request->email;
                    $admin->password = Hash::make($request->password);

                    if($request->hasfile('avatar')){
                        $destination = 'public/admin/profile';
                        $admin_profile = $request->file('avatar');
                        $adminprofile = uniqid().$admin_profile->getClientOriginalName();
                        $path = $admin_profile->storeAs($destination,$adminprofile);

                        $admin->avatar = $adminprofile;
                    }

                    $admin->save();

                    if($request->role_id)
                    {
                        UserRole::where('user_id',$id)->delete();
                        foreach($request->role_id as $role_id){
                            $userRole = new UserRole;
                            $userRole->user_id = $id;
                            $userRole->role_id = $role_id;
                            $userRole->save();
                        }
                    }

                    if($request->permission_id)
                    {
                        UserPermission::where('user_id',$id)->delete();
                        foreach($request->permission_id as $permission_id){
                            $userpermission = new UserPermission;
                            $userpermission->user_id = $id;
                            $userpermission->permission_id = $permission_id;
                            $userpermission->save();
                        }
                    }
                    return redirect('/admin/admin-users')->with('msg','Update  admin Successfully.');
                }
                else
                {
                    return back()->with('notmatch','Password is not matching');
                }
            }

        }
        else
        {
        return back()->withErrors($validator)->withInput();
        }
    }

    public function login()
    {
        return view('admin/login');
    }

    public function loginCheck(Request $request)

    {
        $validator =$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $admin = Admin::with(['userPermission.permission'])->where('email',$request->email)->get()->toArray();
        $password = Hash::check($request->password,$admin[0]['password']);
        // echo "<pre>";
        // print_r($admin);
        // exit();

        if($admin)
        {
            if($password){
                $request->session()->put('admin',$admin);
                return redirect('/admin');
            }

            else
            {
                return back()->with('fail','Password is incorrect');
            }
            
        }
        else
        {
            return back()->with('fail','User does not exist');
        }

    }

    public function logout(Request $request){
        session()->forget('admin');
        return redirect('/admin/login');
    }


    public function destroy($id)
    {
        Admin::find($id)->delete();
        UserRole::where('user_id', $id)->delete();
        UserPermission::where('user_id', $id)->delete();
        return redirect('/admin/admin-users')->with('msg','Admin delete Successfully.');

    }
}
