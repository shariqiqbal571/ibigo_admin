<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\User\UserService;
use App\Repositories\Agreegate\AgreegateInterface;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;


class UserController extends Controller
{
    private $userService;
    private $validator;
    private $agreegate;
    private $data;

    public function __construct(
        UserService $userService,
        AgreegateInterface $agreegate,
        Validator $validator
    )
    {
        $this->userService = $userService;    
        $this->agreegate = $agreegate;    
        $this->validator = $validator;
    }

    public function index()
    {
        return $this->userService->getAuthData();
    }

    public function getCity()
    {
        $data = $this->userService->cities();
        return response()->json([
            'city' => $data,
            'status'=>true
        ],201);
    }

    public function getImage()
    {
        $data = $this->userService->images();
        return response()->json([
            'interest' => $data,
            'status'=>true
        ],201);
    }

    public function signUp(Request $request){
        $user = new User;
        $this->data = $request->only([
            'first_name',
            'last_name',
            'username',
            'birth_date',
            'user_about',
            'country_code',
            'country_short_code',
            'city',
            'mobile',
            'gender',
            'email',
            'password',
            'password_confirmation',
            'accept_email',
            'terms_conditions'
        ]);

        $mobile_opt = rand(100000, 999999);
        $token = $user->createToken('My Token')->accessToken;
        $unique_id = Str::uuid();
        $name = $request['first_name'] . ' ' . $request['last_name'];
        $user_slug = Str::slug($name, '-');
        $user_status = 0;

        if($request->hasFile('user_profile')){
            $destination = 'public/images/user/profile';
            $profile = $request->file('user_profile');
            $user_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$user_profile);

            $this->data['user_profile'] = $user_profile;
        }

        if($request->hasFile('user_cover')){
            $destination = 'public/images/user/cover';
            $cover = $request->file('user_cover');
            $user_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$user_cover);

            $this->data['user_cover'] = $user_cover;
        }

        if($request->user_interests)
        {
            $interests = [];
            foreach ($request->user_interests as $value) {
                $interests[] = $value;
            }
            $this->data['user_interests'] = implode(',',$interests);
        }
        $this->data['user_api_token'] = $token;
        $this->data['mobile_opt'] = $mobile_opt;
        $this->data['unique_id'] = $unique_id;
        $this->data['user_slug'] = $user_slug;
        $this->data['user_status'] = $user_status;
        $this->data['user_type'] = "normal";

        // echo "<pre>";
        // print_r($this->data['mobile_opt']);
        // exit();
        $data = $this->userService->signUpUser($this->data);

        return $data;
    }

    public function signUpOtp(Request $request,$uuid)
    {
        $this->data['otp'] = $request->otp;
        $this->data['uuid'] = $uuid;
        return $this->userService->otp($this->data);
    }

    public function checkMail(Request $request)
    {
        $data = $request->all();
        $store = $this->userService->checkEmail($data);
        return $store;
    }

    public function updatePictures(Request $request)
    {
        if($request->hasFile('user_profile')){
            $destination = 'public/images/user/profile';
            $profile = $request->file('user_profile');
            $user_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$user_profile);

            $this->data['user_profile'] = $user_profile;
        }

        if($request->hasFile('user_cover')){
            $destination = 'public/images/user/cover';
            $cover = $request->file('user_cover');
            $user_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$user_cover);

            $this->data['user_cover'] = $user_cover;
        }

        $data = $this->userService->profileCover($this->data);

        return response()->json([
            'message'=>'Profile & Cover is updated successfully!',
            'status'=>true
        ],200);
    }
    
    public function forgotPassword(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json([
                'message' =>'User is not exist',
                'status_code' => 404,
                'status' => false,
            ]);
        }
        else{
        	$t = Str::random(60);
            User::where('email',$user->email)->update(['reset_password_token'=>$t,'updated_at'=>now()]);

            $url = 'http://127.0.0.1:8000/user/reset/'.$t;
            $to = $user->email;
            $subject = "Reset Password Notification";
            $details = [
                'title'=>'Hello!',
                'body'=>'You are receiving this email because we received a password reset request for your account.',
                'link'=>$url,
                'description'=>'This password reset link will expire in 60 minutes.',
                'short_description'=>'If you did not request a password reset, no further action is required.',
                'site_name'=>'Regards, IBIGO'
            ];

            $mail = Mail::to($to)->send(new UserMail($details));
            if($mail)
            {
                return response()->json([
                    'message' =>'Check Your Mail',
                    'status_code' => 201,
                    'status' => true,
                ]);
            }
            else {
                return response()->json([
                    'message' =>'Admin is facing issues!',
                    'status_code' => 400,
                    'status' => false,
                ]);
            }
        }
    }

    public function reset(Request $request,$token)
    {
        $passwordReset = User::where('reset_password_token', $token)->first();
        if (!$passwordReset){
            return response()->json([
                'message' => 'This password reset token is invalid.',
                'status_code' => 404,
                'status' => false
            ]);
        }
            
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->reset_password_token = null;
            $passwordReset->save();
            return response()->json([
                'message' => 'This password reset token is expired.',
                'status_code' => 404,
                'status' => false
            ]);
        }
        else
        {
            $request->validate([
                'password' => 'required|string|confirmed',
            ]);
            
            $user = User::where('reset_password_token', $token)->first();
            
            $user->password = Hash::make($request->password);
            $user->reset_password_token = null;
            $user->save();
            return response()->json([
                'message'=> "Password is successfully changed.",
                'status_code' => 200,
                'status' => true
            ]);
        }
    }

    public function verifyUser($token)
    {
        $userVerify = User::where('user_api_token',$token)->get()->toArray();
        if(!$userVerify)
        {
            return response()->json([
                'message'=>'User Not Found!',
                'status'=>false,
                'code'=>201
            ]);
        }
        else
        {
            $user = User::find($userVerify[0]['id']);
            $user->email_verified_at = now();
            $user->save();
            return response()->json([
                'data'=>$user,
                'message'=>'You are now verified, now you can login your profile!',
                'status'=>true,
                'code'=>200
            ]);
        }
    }

    public function login(Request $request)
    {
        $user = $request->only([
            'email',
            'password'
        ]);

        $data = $this->userService->loginResponse($user);

        return $data;
    }

    public function mobileLogin(Request $request)
    {
        $this->data = $request->only([
            'mobile',
            'mobile_opt'
        ]);
        $this->data['country_code'] = '31';

        $data = $this->userService->mobile($this->data);
        return $data;
    }


    public function show()
    {
        $user_id = Auth::id();
        return $this->userService->peopleProfile($user_id);
    }

    public function updateUser(Request $request)
    {
        $this->data = $request->all();
        if($request->hasFile('user_profile')){
            $destination = 'public/images/user/profile';
            $profile = $request->file('user_profile');
            $user_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$user_profile);

            $this->data['user_profile'] = $user_profile;
        }
        if($request->expertise_id)
        {
            $expertiseIds = [];
            foreach($request->expertise_id as $expertise_id)
            {
                $expertiseIds[] = $expertise_id;
            }
            $this->data['expertise_id'] = $expertiseIds;
        }
        $data = $this->userService->updateUserProfile($this->data);
        return $data;
    }

    public function updateInterest(Request $request)
    {
        $user_id = Auth::id();
        $user_interests = [];
        $user = User::find($user_id);
        if($interests = $request->user_interests)
        {
            foreach($interests as $interest)
            {
                $user_interests[] = $interest;
            }
            
            $user->user_interests = implode(',',$user_interests);
            $user->save();
            return response()->json([
                'message'=>'User Interests Update Successfully!',
                'status'=>true,
                'status_code'=>201
            ]);
        }
        else{
            return response()->json([
                'message'=>'Error',
                'status'=>false,
                'status_code'=>400
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = $request->validate([
            'old_password'=>'required',
            'password'=>'required|confirmed'
        ]);
        $user_id = Auth::id();
        $user = User::find($user_id);
        // echo "<pre>";
        // print_r($user);
        // exit();
        if(!Hash::check($request->old_password, $user->password)){
            return response()->json([
                'message'=>'Your old password is incorrect!',
                'status'=>false
            ],404);
        }
        else{
            if($request->password == $request->password_confirmation)
            {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json([
                    'message'=>'Your password has been changed!',
                    'status'=>true
                ],200);
            }
            else
            {
                return response()->json([
                    'message'=>'Your password are not matching!',
                    'status'=>false
                ],401);
            }
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'user_api_token' => "required"
        ]);

        $user = User::where('user_api_token', $request->verify_token)->first();
        if (!$user) {
            return response()->json(['status' => 'failure', 'message' => 'Verification link  invalid', 'data' => []], 200);
        }
        if ($user->email_verified_at) {
            $data['message'] = "Email is already verified!";
            return response()->json(['status' => 'failure', 'message' => 'Email is already verified', 'data' => []], 200);
        }

        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Email is successfully verified!', 'data' => []], 200);
    }


    public function updateAbout(Request $request)
    {
        $this->data['user_about'] = $request->user_about;
        
        $user_about = $this->userService->userAbout($this->data);

        return response()->json([
            'message'=>'Your about updated successfully!',
            'success'=>true
        ],200);

    }

    public function logout(Request $request)
    {
        $user = User::find(Auth::id());
        $user->user_status = 0;
        $user->save();
        $request->user()->token()->revoke();
        return response()->json([
            'message'=>'You are logout successfully!'
        ]);
    }

    public function destroy(){
        $user_id = Auth::id();
        $this->userService->delete($user_id);
        return response()->json([
            'message'=>'Your account is successfully deleted!',
            'status'=>true
        ],200);
    }

    public function userProfile($id)
    {
        $data = $this->userService->peopleProfile($id);
        
        return $data;
    }

    public function find()
    {
        return $this->agreegate->findFoursquare();
    }

    public function facebookLogin(Request $request)
    {
        $this->data = [
            'id'=>$request->id,
            'first_name'=>isset($request->first_name) ? $request->first_name:null
        ];

        if($request->hasFile('user_profile')){
            $destination = 'public/images/user/profile';
            $profile = $request->file('user_profile');
            $user_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$user_profile);

            $this->data['user_profile'] = $user_profile;
        }
        
        return $this->userService->loginForSocial($this->data);
    }

    public function validateUser(Request $request)
    {
        $this->data = $request->all();
        return $this->userService->registerValidate($this->data);
    }

    public function get()
    {
        return $this->userService->userList();
    }

    public function loggedInOrNot()
    {
        return $this->userService->loggedInUserOrNot();
    }

    public function checkUserLoggedInOrNot(Request $request)
    {
        $this->data = [
            'user_status' => $request->user_status
        ];
        return $this->userService->checkingUserLoggedInOrNot($this->data);
    }

    public function userFollow(Request $request)
    {
        $user = Auth::user();
        $this->data = [
            'from_user_id' => $user->id,
            'to_user_id' => $request->user_id,
            'follow' => $request->follow
        ];

        return $this->userService->follow($this->data);
    }

    public function followers()
    {
        return $this->userService->allFollowers();
    }

    public function followings()
    {
        return $this->userService->allFollowings();
    }
}
