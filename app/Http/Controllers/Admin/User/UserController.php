<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expertise;
use App\Models\UserExpertise;
use App\Models\Spot;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Interest;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{


    public function adminLayout()
    {

        return view('admin/index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = '';
        if($request->filter == 'normal' || $request->filter == 'business'){
            $filter = $request->filter;
        }
        else{
            $filter = '';
        }
        $users = User::where('user_type', 'like', '%'.$filter.'%')->orderBy('id', 'desc')->paginate(10);
        return view('admin/user/view')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expertise = Expertise::all();
        $interests = Interest::get(['id','image'])->toArray();
        return view('admin/user/add')->with(compact('interests','expertise'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";
        // print_r($request->all());
        // exit;
       $validator = Validator::make($request->all(),[
        'first_name'=>'required',
        'last_name'=>'required',
        'email' => 'required|email|unique:users|string',
        'username' => 'required|unique:users',
        'mobile' => 'required|min:9|max:9',
        'password' => 'required|string',
        'confirm_password' => 'required|string',
        'accept_email' => 'required',
        'terms_conditions' => 'required',
       ]);
       if($validator->passes())

       {

        $user = new User;
        if($request->confirm_password == $request->password)
        {
            $user->unique_id = Str::random(32);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->accept_email = $request->accept_email;
            $user->terms_conditions = $request->terms_conditions;
            $user_slug =   $request->first_name . " " .  $request->last_name;
            $user->user_slug = Str::slug($user_slug,'-');
            $user->birth_date = $request->birth_date;

            if($request->hasfile('user_profile')){
                $destination = 'public/images/user/profile';
                $user_photo = $request->file('user_profile');
                $userphoto = uniqid().$user_photo->getClientOriginalName();
                $path = $user_photo->storeAs($destination,$userphoto);

                $user->user_profile = $userphoto;

            }

            if($request->hasfile('user_cover')){
                $destination = 'public/images/user/cover';
                $user_cover = $request->file('user_cover');
                $usercover = uniqid().$user_cover->getClientOriginalName();
                $path = $user_cover->storeAs($destination,$usercover);

                $user->user_cover = $usercover;
            }

            $user->user_about = $request->user_about;
            $user->user_status = 0;
            if($request->mobile){
                $user->country_code = 31;
                $user->country_short_code = 'NL';
                $user->mobile = $request->mobile;
            }
            $user->gender = $request->gender;
            if($request->user_interests){
                $user->user_interests = implode(',',$request->user_interests);
            }
            $user->user_type = 'normal';
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $token = $user->createToken('My Token')->accessToken;
            $user->user_api_token = $token;
            $user->save();
            if($request->user_expertise)
            {
                foreach($request->user_expertise as $user_expertise)
                {
                    $expertise = new UserExpertise;
                    $expertise->user_id = $user->id;
                    $expertise->expertise_id = $user_expertise;
                    $expertise->save();
                }
            }
            $request->session()->flash('msg','Add New User Successfully.');
            return redirect('/admin/user');
        }
        else{
            return back()->with('notmatch','Password is not matching');
        }
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
        $interests = [];
        $user =  User::find($id);
        $expertise = Expertise::all();
        $user_expertise = UserExpertise::where('user_id', $id)->get();
        $intrestId = explode(",",$user['user_interests']);
        // echo "<pre>";
        // print_r($intrestId);
        // exit();
        $interests = Interest::get(['id','image'])->toArray();
        return view('admin/user/update')->with(compact('user','interests','intrestId','expertise','user_expertise'));
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
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email|string',
            'username' => 'required|unique:users,username,'.$id,
            'mobile' => 'required',
            'password' => 'required|string',

           ]);
           if($validator->passes())

           {
            $user =  User::find($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user_slug =   $request->first_name . " " .  $request->last_name;
            $user->user_slug = Str::slug($user_slug,'-');
            $user->birth_date = $request->birth_date;

            if($request->hasfile('user_profile')){
                $destination = 'public/images/user/profile';
                $user_photo = $request->file('user_profile');
                $userphoto = uniqid().$user_photo->getClientOriginalName();
                $path = $user_photo->storeAs($destination,$userphoto);

                $user->user_profile = $userphoto;

            }

            if($request->hasfile('user_cover')){
                $destination = 'public/images/user/cover';
                $user_cover = $request->file('user_cover');
                $usercover = uniqid().$user_cover->getClientOriginalName();
                $path = $user_cover->storeAs($destination,$usercover);

                $user->user_cover = $usercover;
            }

            $user->user_about = $request->user_about;

            if($request->mobile){
                $user->country_code = 31;
                $user->country_short_code = 'NL';
                $user->mobile = $request->mobile;
            }
            $user->gender = $request->gender;


            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if($request->user_interests){
                $user->user_interests = null;
                $user->user_interests = implode(',',$request->user_interests);
            }
            else{
                $user->user_interests = null;
            }
            $user->save();
            if($request->user_expertise)
            {
                UserExpertise::where('user_id',$id)->delete();
                foreach($request->user_expertise as $user_expertise)
                {
                    $expertise = new UserExpertise;
                    $expertise->user_id = $user->id;
                    $expertise->expertise_id = $user_expertise;
                    $expertise->save();
                }
            }
            $request->session()->flash('msg','Update User Successfully.');
            return redirect('/admin/user');
        }

            else
            {
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
        Spot::where('user_id', $id)->delete();
        UserExpertise::where('user_id',$id)->delete();
        User::find($id)->delete();
        return redirect('/admin/user')->with('msg','User delete Successfully.');;
    }
}
