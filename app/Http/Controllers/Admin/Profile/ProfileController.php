<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/profile/view');
    } 

    public function password()
    {
        return view('admin/profile/passwordview');
    }

    public function  updatepassword(Request $request, $id)
    {
        $validator =  Validator::make($request->all(),[
            'oldpassword'=>'required|string',
            'password'=>'required|string',
            'confirm_password'=>'required|string'

        ]);
        if($validator->passes())
        {
            $admin =  Admin::find($id);
            
            if(!Hash::check($request->oldpassword,$admin->password)){
                return back()->with('error','The specified password does not match.');
            }
            else
            {
                if($request->password == $request->confirm_password)
                {
                    $admin->password = Hash::make($request->password);
                    
                    $admin->save();
                    return redirect('/admin/profile')->with('msg','Update Password Successfully.');
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
           
    
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
        //
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
        // $validator = Validator::make($request->all(),[
        //     'name'=>'required',
        //     'email' => 'required|email|unique:admins|string',
        // ]);
        
        // if($validator->passes())
        // {

        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if($request->hasfile('avatar')){
           
            $destination = 'public/admin/profile';
            $admin_profile = $request->file('avatar');
            $adminprofile = uniqid().$admin_profile->getClientOriginalName();
            $path = $admin_profile->storeAs($destination,$adminprofile);
    
            $admin->avatar = $adminprofile;
        }    
        $admin->save();
        return redirect('admin/admin-users')->with('msg','When you log out, your profile will be updated.');
    // }
    
    // else
    // {
    //     return back()->withErrors($validator)->withInput(); 
    // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
