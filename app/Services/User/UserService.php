<?php 

namespace App\Services\User;

use App\Repositories\User\UserInterface;
use App\Repositories\UserFollow\UserFollowInterface;
use App\Repositories\Interest\InterestInterface;
use App\Repositories\Post\PostInterface;
use App\Repositories\UserExpertise\UserExpertiseInterface;
use App\Repositories\Group\GroupInterface;
use App\Repositories\SocialLogin\SocialLoginInterface;
use App\Repositories\SpotDetail\SpotDetailInterface;
use App\Repositories\Spot\SpotInterface;
use App\Repositories\City\CityInterface;
use App\Services\FriendRelation\FriendRelationService;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Time\Time;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use App\Services\Communication\CommunicationService;
use Twilio\Rest\Client;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Craftsys\Msg91\Facade\Msg91;

class UserService
{
    private $user;
    private $userFollow;
    private $post;
    private $userExpertise;
    private $time;
    private $spotDetail;
    private $spot;
    private $interest;
    private $city;
    private $group;
    private $friendRelationService;
    private $socialLogin;
    private $validator;
    private $response;
    private $request;


    public function __construct(
        Time $time,
        Validator $validator,
        UserInterface $user,
        UserFollowInterface $userFollow,
        InterestInterface $interest,
        PostInterface $post,
        UserExpertiseInterface $userExpertise,
        CityInterface $city,
        FriendRelationService $friendRelationService,
        SocialLoginInterface $socialLogin,
        SpotDetailInterface $spotDetail,
        SpotInterface $spot,
        GroupInterface $group,
        Response $response,
        Request $request
    )
    {
        $this->user = $user;
        $this->userFollow = $userFollow;
        $this->post = $post;
        $this->spotDetail = $spotDetail;
        $this->spot = $spot;
        $this->interest = $interest;
        $this->userExpertise = $userExpertise;
        $this->friendRelationService = $friendRelationService;
        $this->socialLogin = $socialLogin;
        $this->city = $city;
        $this->group = $group;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
        $this->time = $time;
    }

    public function validateUserData($data)
    {
        return $this->validator->make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'mobile'=>'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'accept_email' => 'required',
            'terms_conditions' => 'required'
        ]);
    }

    public function validateUserUpdate($data,$user)
    {
        return $this->validator->make($data, [
            'username' => 'required|unique:users,username,'.$user['id'],
            'mobile' => 'required|unique:users,mobile,'.$user['id'],
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
    }

    public function validateUserLogin($data)
    {
        return $this->validator->make($data, [
            "email"=>"required|email|exists:users",
            "password"=>"required|password",
        ]);
    }

    public function signUpUser($userData)
    {
        return $this->signUp($userData);
    }

    public function signUp($userData)
    {
        $validate = $this->validateUserData($userData);

        if($validate->fails()){
            $response['message'] = $validate->errors();
            $response['status'] = false;
            $response['status_code'] = 400;
        }
        else{
            $userData['password'] = Hash::make($userData['password']);
            // $token = $userData['user_api_token'];

            
            $saveUser = $this->user->store($userData);
            $passwordToken = New PasswordReset;
            $passwordToken->email = $userData['email'];
            $passwordToken->token = $userData['user_api_token'];
            $passwordToken->updated_at = now();
            $passwordToken->created_at = now();
            $passwordToken->save();
            
            // $tId = env('TWILIO_SID');
            // $tToken = env('TWILIO_TOKEN');
            // $tNumber = env('TWILIO_NUMBER');
            // $client = new Client($tId,$tToken);
            // $number = json_decode($userData['mobile']);
    
    
            // try {
            //     $client->messages->create(
            //         $number,
            //         [
            //             "from" => $tNumber,
            //             "body" => "Your opt is #".$userData['mobile_opt'],
            //         ]
            //     );
            //     $message = Log::info('Message sent to ' . $tnumber);
            // } catch (TwilioException $e) {
            //     Log::error(
            //         'Could not send SMS notification.' .
            //         ' Twilio replied with: ' . $e
            //     );
            // }

            try {
                $verify_url = env('APP_URL');
                $email_data = array(
                    'name' => $userData['first_name'].' '.$userData['last_name'],
                    'email' => $userData['email'],
                    // 'link' => env('APP_URL'),
                    'link' => $verify_url.'?verify_token='.$userData['user_api_token'],
                );
                CommunicationService::sendMail('Registration', $email_data);
            } catch (\Exception $th) {

            }

            $response['message'] = 'You are successfully registered!';
            $response['status'] = true;
            $response['status_code'] = 201;
            $response['uuid'] = $userData['unique_id'];
            $response['token'] = $userData['user_api_token'];
        }
        return response()->json($response);
    }

    public function otp($request)
    {
        $user = $this->user->where('unique_id', $request['uuid']);
        $mobileOTP = $user[0]['mobile_opt'];
        if($mobileOTP == $request['otp'])
        {
            $this->data['mobile_verified_at'] = now();
            $this->user->edit('unique_id',$this->data,$request['uuid']);
            $response['message'] = 'You are allow to login with your number!';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else
        {
            $response['message'] = 'Wrong OTP number!';
            $response['status'] = false;
            $response['status_code'] = 400;
        }
        return response()->json($response);
    }

    public function checkEmail($request)
    {
        $validate = $this->validator->make($request,[
            'email' => "required|email"
        ]);

        if($validate->fails())
        {
            return response()->json([
                'message' => $validate->errors(),
                'status_code' => 401,
                'status' => false
            ]);
        }
        else
        {
            return response()->json([
                'status_code' => 200,
                'status' => true
            ]);
        }
    }

    public function loginResponse($data)
    {
        return $this->login($data);
    }

    public function login($data)
    {
        $validate = $this->validateUserLogin($data);

        if(!Auth::attempt($data)){
            if($validate->fails()){
               return response()->json(['message'=>$validate->errors()],401);
            }
        }
        else{
            // if($this->request->user()->email_verified_at != null)
            // {
                $user = $this->request->user();
                $tokenRes = $user->createToken('Personal Token Accesss');
                $token = $tokenRes->token;

                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $status['user_status'] = 1;
                $this->user->edit('id',$status,Auth::id());
                return response()->json([
                    "access_token"=>$tokenRes->accessToken,
                    "token_type"=>"Bearer",
                    "expires_at"=>Carbon::parse($token->expires_at)->toDateTimeString(),
                    'data'=>Auth::user()
                ]);
            // }
            // else{
            //     return response()->json([
            //         'message'=>'Your are not verified!',
            //         'status'=>false
            //     ],404);
            // }
        }
    }

    public function mobile($request)
    {
        $user = $this->user->where('mobile',$request['mobile']);
        // echo "<pre>";
        // print_r($user);
        // exit();
        if(!empty($user))
        {
            if($request['mobile_opt'] != NULL)
            {
                $mobile_opt = $user[0]['mobile_opt'];
                if($request['mobile_opt'] == $mobile_opt)
                {
                    if($user[0]['email_verified_at'])
                    {
                        if($user[0]['user_api_token'] == NULL)
                        {
                            $token = Str::uuid();
                            $this->user->edit('id',['user_api_token'=>$token],$user[0]['id']);
                        }
                        else{
                            $token = $user[0]['user_api_token'];
                        }
                        return response()->json([
                            'message' => 'User login successfully.',
                            'token' => $token,
                            'data'=>$user,
                            'status_code' => 200, 
                            'status' => true
                        ]);
                    }
                    else
                    {
                        $response = "Verify your account.";
                        return response()->json([
                            'message' => $response, 
                            'status_code' => 422, 
                            'status' => false
                        ]);
                    }
                }
                else{
                    return response()->json([
                        'message' => 'OTP is incorrect.',
                        'status_code' => 404,
                        'status' => false
                    ]);
                }
            }
            else{
                return response()->json([
                    'message' => 'OTP sent to your mobile.',
                    'status_code' => 200,
                    'status' => true
                ]);
            }
        }
        else{
            $response = 'User does not exist';
            return response()->json([
                'message' => $response, 
                'status_code' => 422, 
                'status' => false
            ]);
        }
    }

    public function updateUserProfile($request)
    {
            $user = Auth::user();
            $validate = $this->validateUserUpdate($request,$user);

        if($validate->fails()){
            $response['message'] = $validate->errors();
            $response['status'] = false;
            return response()->json($response,401);
        }
        else{
            $id = $user->id;
            if($user)
            {
                $userdata = [
                    'first_name' => (isset($request['first_name'])? $request['first_name'] : $user->first_name),
                    'last_name' => (isset($request['last_name'])? $request['last_name'] : $user->last_name),
                    'username' => (isset($request['username'])? $request['username'] : $user->username),
                    'mobile' => (isset($request['mobile'])? $request['mobile'] : $user->mobile),
                    'country_short_code' => (isset($request['country_short_code'])? $request['country_short_code'] : $user->country_short_code),
                    'country_code' => (isset($request['country_code'])? $request['country_code'] : $user->country_code),
                    'user_about' => (isset($request['user_about'])? $request['user_about'] : $user->user_about),
                    'city' => (isset($request['city'])? $request['city'] : $user->city),
                    'full_address' => (isset($request['full_address'])? $request['full_address'] : $user->full_address),
                    'user_profile'=> (isset($request['user_profile'])? $request['user_profile']: $user->user_profile)
                ];
                $name = $userdata['first_name'] . ' ' . $userdata['last_name'];
                $userdata['user_slug'] = Str::slug($name, '-');

                $storeData = $this->user->edit('id', $userdata,$id);
                if($storeData)
                {
                    if($request['expertise_id'])
                    {
                        foreach($request['expertise_id'] as $key => $expertiseIds)
                        {
                            $this->data = [
                                'user_id' => $id,
                                'expertise_id' => $expertiseIds
                            ];
                            $this->userExpertise->store($this->data);
                        }
                    }
                }
            }
            return response()->json([
                'message'=>'User Update Successfully!',
                'status'=>true,
                'status_code'=>201
            ]);
        }
    }
    
    public function userAbout($request)
    {
        $id = Auth::id();
        $userAbout = [
            'user_about'=>$request['user_about']
        ];

        $storeData = $this->user->edit('id', $userAbout,$id);
        return $storeData;
    }

    public function images()
    {
        return $this->interest->getImages();
    }

    public function cities()
    {
        return $this->city->getCities('city');
    }

    public function profileCover($request)
    {
        $user = Auth::user();
        $this->data = [
            'user_profile'=>(isset($request['user_profile'])? $request['user_profile'] : $user->user_profile),
            'user_cover'=>(isset($request['user_cover'])?$request['user_cover'] : $user->user_cover)
        ];
        $data = $this->user->edit('id',$request,$user->id);
        return $data;
    }

    public function delete($id)
    {
        $userDelete = $this->user->destroy($id);
        return $userDelete;
    }

    public function spotDeailsRating($spot)
    {   
        $rating = $this->spotDetail->ratings(
            'DB::raw',
            'rating',
            'rating_sum',
            'id',
            'count_rating',
            'spot_id',
            $spot['id']
        );

        $avg_rating = null;
        if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
            $avg_rating = 0;
        }else{
            $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
        }
        return $avg_rating;
    }

    public function users($id)
    {
        $users = $this->user
        ->allUsers('id','!=',$id,
        ['id','unique_id','first_name','last_name','user_slug','user_profile']);
        // echo "<pre>";
        // print_r($users);
        // exit();
        return response()->json([
            'user'=>$users,
            'status'=>'success',
        ],201);
    }

    public function peopleProfile($id)
    {
        $user = $this->user->authUser(
            [
                'userExpertise.expertise',
                'toFriendsRelation',
                'fromFriendsRelation',
                'followers',
                'followings'
            ],
            'id',
            $id);
        $userReviews = $this->spotDetail->where('user_id',$id,'review','!=',null);
        $age = Carbon::parse($user[0]['birth_date'])->diff(Carbon::now())->y.' years';
        $fullname = $user[0]['first_name'].' ' .$user[0]['last_name'];
        $user[0]['fullname'] = $fullname;
        $user[0]['age'] = $age;
        $user[0]['reviews'] = count($userReviews);
        $user[0]['followings'] = count($user[0]['followings']);
        $user[0]['followers'] = count($user[0]['followers']);

        if($user[0]['user_interests'] != null) {
            $user_interests = explode(',',$user[0]['user_interests']);
            $interest = $this->interest->authInterest('id',$user_interests,['id','title','icon']);
            $user[0]['user_interests'] = $interest;
        }
        $sushiSpot = $this->spot->sushiSpot(
            [
                'userSpot',
                'spotUserReview'
            ],
            [
                'id',
                'user_id',
                'spot_profile',
                'business_name',
                'short_description',
                DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
            ],
           'street_no','postal_code','city','business_name','sushi',3,'updated_at','desc'
        );
        $user[0]['sushi_spots'] = $sushiSpot;

        $spotDetailRecent = $this->spotDetail->userReviewSpots(
            'user_id',$id,'review_date_time','desc',3
        );
        $spotRecentids = [];
        foreach ($spotDetailRecent as $key => $spotDetailRecent) {
            array_push($spotRecentids,$spotDetailRecent['spot_id']);
        }
        $spotRecentids = array_unique($spotRecentids);
        $recentSpot = $this->spot->recentSpots(
            [
                'userSpot',
                'spotUserReview'
            ],
            [
                'id',
                'user_id',
                'spot_profile',
                'business_name',
                'short_description',
                DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
            ],
           3,'updated_at','desc','id',$spotRecentids
        );

        $user[0]['recent_spots'] = [];
        if($recentSpot)
        {
            $user[0]['recent_spots'] = $recentSpot;
            foreach ($recentSpot as $key => $value) {
                $avg_rating = $this->spotDeailsRating($value);
                $user[0]['recent_spots'][$key]['avg_rating'] = $avg_rating;
            }
        }
        // echo "<pre>";
        // print_r($recentSpot);
        // exit();
        $spotDetail = $this->spotDetail->topSpots(
            [
                'spot.userSpot'
            ],
            [
                'id','spot_id','rating'
            ],
            'rating','<=','5.0','5','desc'
        );
        $spotids = [];
        foreach ($spotDetail as $key => $spotDetail) {
            array_push($spotids,$spotDetail['spot_id']);
        }
        $spotids = array_unique($spotids);
        $spots = $this->spot->topRatedSpots(
            [
                'userSpot',
                'spotUserReview'
            ],
            [
                'id',
                'user_id',
                'spot_profile',
                'business_name',
                'short_description',
                DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
            ],
            'id',
            $spotids,3
        );
        $user[0]['top_rated_spots'] = [];
        if($spots)
        {
            $user[0]['top_rated_spots'] = $spots;
            foreach ($spots as $key => $value) {
                $avg_rating = $this->spotDeailsRating($value);
                $user[0]['top_rated_spots'][$key]['avg_rating'] = $avg_rating;
            }
        }
        $post = $this->post->postForUserProfile(
            ['postImages','postVideos'],
            ['id'],
            'user_id',$id
        );
        $user[0]['gallery'] = [];
        if($post)
        {
            foreach ($post as $key => $value)
            {
                if($value['post_images'])
                {
                    foreach ($value['post_images'] as $key2 => $postImages)
                    {
                        // echo "<pre>";
                        // print_r();
                        $user[0]['gallery']['images'][] = '/storage/images/post/images/'.$postImages['post_images'];
                    }
                }
                if($value['post_videos'])
                {
                    foreach ($value['post_videos'] as $key2 => $postVideos)
                    {
                        // echo "<pre>";
                        // print_r($postVideos);
                        $user[0]['gallery']['videos'][] = '/storage/videos/post/videos/'.$postVideos['post_videos'];
                    }
                }
            }
            // exit();
        }
        $spotDetailPhotosAndVideos = $this->spotDetail->spotForUserProfile(
            ['spotDetailPhotos','spotDetailVideos'],
            ['id'],
            'user_id',$id
        );
        // echo "<pre>";
        // print_r($spotDetailPhotosAndVideos);
        // exit();
        if($spotDetailPhotosAndVideos)
        {
            foreach ($spotDetailPhotosAndVideos as $key => $value)
            {
                if($value['spot_detail_photos'])
                {
                    foreach ($value['spot_detail_photos'] as $key2 => $postImages)
                    {
                        // echo "<pre>";
                        // print_r();
                        $user[0]['gallery']['images'][] = '/storage/images/review/images/'.$postImages['review_photo'];
                    }
                }
                if($value['spot_detail_videos'])
                {
                    foreach ($value['spot_detail_videos'] as $key2 => $postVideos)
                    {
                        // echo "<pre>";
                        // print_r($postVideos);
                        $user[0]['gallery']['videos'][] = '/storage/videos/review/videos/'.$postVideos['review_video'];
                    }
                }
            }
            // exit();
        }
        
        if($user)
        {
            return response()->json([
                'user'=>$user,
                'status'=>'success',
            ],201);
        }
    }

    public function post($posts,$key,$post)
    {
        $shared_user_ids = explode(',',$post['shared_user_id']);
        $shared_friends = $this->user->suggestions(
            ['first_name', 'last_name', 'id','unique_id','user_slug'],
            'id',
            $shared_user_ids
        );
        $posts[$key]['shared_with_friends'] = $shared_friends;


        $tagged_user_ids = explode(',',$post['tagged_user_id']);
        $tagged_friends = $this->user->suggestions(
            ['first_name', 'last_name', 'id','unique_id','user_slug'],
            'id',
            $tagged_user_ids
        );
        $posts[$key]['tagged_friends'] = $tagged_friends;


        $group_user_ids = explode(',',$post['shared_group_id']);
        $shared_group = $this->group->getGroupPost(
            'id',
            $group_user_ids,
            ['id','group_name', 'group_slug','group_unique_id']
        );
        $posts[$key]['shared_with_groups'] = $shared_group;

        return $posts;
    }

    public function getAuthData()
    {
        $user_id = Auth::id();
        $user = $this->user->authUser(
            [
                'post.status',
                'post.postImages',
                'post.postVideos',
                'post.postAudios',
                'post.spotPost.userSpot',
                'post.groupPost',
                'post.eventPost',
                'post.postLike',
                'post.postComment.user',
                'spotDetail.spot.userSpot',
                'spotDetail.spotDetailPhotos',
                'spotDetail.spotDetailVideos',
                'event',
                'group'
            ],'id',$user_id
        );

        
        $user_interests = explode(',',$user[0]['user_interests']);
        $interest = $this->interest->authInterest('id',$user_interests,['id','title','image']);
        $user[0]['interest'] = $interest;
        $friends = $this->friendRelationService->getFriends($user_id);
        $user[0]['friends'] = $friends;
        foreach ($user[0]['post'] as $key => $post) {
            
            $posts = $this->post($user[0]['post'],$key,$post);
            $user[0]['post'] = $posts;
        }
        // echo "<pre>";
        // print_r($user);
        if($user[0]['friends']) {
            foreach ($user[0]['friends'] as $key => $value) {
                $friends = $this->user->authUser(
                    [
                        'post.postImages',
                        'post.postVideos',
                        'post.postAudios',
                        'post.spotPost.userSpot',
                        'post.groupPost',
                        'post.eventPost',
                        'post.postLike',
                        'post.postComment.user',
                        'event',
                        'group'
                    ],'id',$value['id']
                );
                $user_interests = explode(',',$friends[0]['user_interests']);
                $interest = $this->interest->authInterest('id',$user_interests,['id','title','image']);
                $friends[0]['interest'] = $interest;
                foreach ($friends[0]['post'] as $key => $post) {
                    
                    $posts = $this->post($friends[0]['post'],$key,$post);
                    $friends[0]['post'] = $posts;
                }
                // echo "<pre>";
                // print_r($friends);
                $user[0]['friends'][$key] = $friends;
            }
        }
        // exit();
        if($user)
        {
            return response()->json([
                'user'=>$user,
                'status'=>'success',
            ],201);
        }

    }

    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = $this->socialLogin->getUser('facebook',$providerUser->getId());

        if($account) {
            return $account->user;
        } 
        else {
            $account = [
                'user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ];

            $user = $this->user->where('email',$providerUser->getEmail());

            if (!$user) {
                $forToken = new User;
                $this->data = [
                    'unique_id' => Str::uuid(),
                    'username' => $providerUser->getName(),
                    'user_slug' => Str::slug($providerUser->getName(),'-'),
                    'user_type' => 'normal',
                    'user_api_token'=>$forToken->createToken('My Token')->accessToken,
                    'accept_email'=>1,
                    'terms_conditions'=>1,
                    'email' => $providerUser->getEmail(),
                    'password' => Hash::make('normal-user'),
                ]; 
                $user = $this->user->store($this->data);
            }

            $account->user()->associate($user);
            $this->socialLogin->store($account);

            return $user;
        }
    }

    public function loginForSocial($request)
    {
        $social = $this->socialLogin->where('provider_id', $request['id']);
        if(count($social)>0)
        {
            $user = $this->user->show($social[0]['user_id']);
            $tokenRes = $user->createToken('Personal Token Accesss');
            $token = $tokenRes->token;

            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

        }
        else{
            $forToken = new User;
            $this->data = [
                'unique_id' => Str::uuid(),
                'username' => isset($request['name'])?$request['name']:'Normal '.Str::random('5'),
                'user_slug' => isset($request['name'])?Str::slug($request['name'],'-'):Str::slug('normal '.Str::random('5'),'-'),
                'user_type' => 'normal',
                'user_api_token'=>$forToken->createToken('My Token')->accessToken,
                'accept_email'=>1,
                'terms_conditions'=>1,
                'email' => 'normal'.Str::random('5').'@ibigo.nl',
                'password' => Hash::make('normal-user'),
            ]; 

            $newUser = $this->user->store($this->data);
            
            $user = $this->user->show($newUser->id);
            $tokenRes = $newUser->createToken('Personal Token Accesss');
            $token = $tokenRes->token;

            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            $account = [
                'user_id' => $newUser->id,
                'provider_id' => $request['id'],
                'provider' => 'facebook'
            ];

            $this->socialLogin->store($account);
        }
        $response['message'] = 'You are Login Successfully!';
        $response['access_token'] = $tokenRes->accessToken;
        $response['token_type'] = "Bearer";
        $response['expires_at'] = Carbon::parse($token->expires_at)->toDateTimeString();
        $response['user'] = $user;
        $response['status'] = true;
        $response['status_code'] = 201;
        return response()->json($response);
    }

    public function registerValidate($request)
    {
        $userEmail = '';
        if(isset($request['email']))
        {
            $userEmail = 'email';
        }
        else if(isset($request['username']))
        {
            $userEmail = 'username';
        }else{
            $userEmail = '';
        }

        $validate = $this->validator->make($request, [
            $userEmail => (($userEmail == 'email')?'required|unique:users,email|email':'required|unique:users,username|string')
        ]);
        if($userEmail == '' || $userEmail == null)
        {
            $response['message'] = 'Email or Username is required!';
            $response['status'] = false;
        } 
        else if($validate->fails())
        {
            $response['message'] = $validate->errors();
            $response['status'] = false;
        }
        else{
            $response['message'] = 'Validation is applied!';
            $response['status'] = true;
        }
        return response()->json($response);
    }

    public function userList()
    {
        $id = Auth::id();
        $user = $this->user->users(
            'id',
            '!=',
            $id,
            ['id',
            'username',
            'user_profile',
            'user_slug',
            'full_address',
            'user_about',
            'user_interests',
            'birth_date',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")],
            'user_type',
            'normal'
        );
        $user_interests = [];
        foreach ($user as $key => $value) {
            // echo "<pre>";
            // print_r($value['user_interests']);
            if($value['birth_date'] != NULL)
            {
                $age = Carbon::parse($value['birth_date'])->diff(Carbon::now())->y.' years';
                // echo "<pre>";
                // print_r($age);
                $user[$key]['age'] =$age;
            }
            else {
                $user[$key]['age'] = '';
            }
            if($value['user_interests'] != null) {
                $user_interests = explode(',',$value['user_interests']);
                $interest = $this->interest->authInterest('id',$user_interests,['id','title','image']);
                $user[$key]['interest'] = $interest;
            }
        }

        // exit();
        if($user)
        {
            $response['users'] = $user;
            $response['status'] = true;
            $response['code'] = 201;
        }
        return response()->json($response);
    }

    public function loggedInUserOrNot()
    {
        $user = Auth::user();
        if($user)
        {
            $loginUser = $this->user->twoWhere(
                'user_status',
                1,
                'user_type',
                'normal',
                [
                    'id',
                    'user_profile',
                    'username',
                    DB::raw("CONCAT(first_name,' ',last_name) AS fullname"),
                    'user_slug',
                    'user_status'
                ]
            );
            $logoutUser = $this->user->twoWhere(
                'user_status',
                0,
                'user_type',
                'normal',
                [
                    'id',
                    'user_profile',
                    'username',
                    DB::raw("CONCAT(first_name,' ',last_name) AS fullname"),
                    'user_slug',
                    'user_status'
                ]
            );
            $response['logged_in'] = $loginUser;
            $response['logged_out'] = $logoutUser;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else
        {
            $response['message'] = 'Authenticate Errors!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function checkingUserLoggedInOrNot($request)
    {
        $user = Auth::user();
        $this->data = [
            'user_status' => $request['user_status']
        ];
        if($user)
        {
            if($user->user_status == $request['user_status'])
            {

                $loggedout = $this->user->edit('id',$this->data,$user->id);

                $current = strtotime( $user->updated_at );
                $previous = $this->time->timePrevious($current);
                
                $response['message'] = ($user->user_status == 1)?$user->first_name.' '.$user->last_name.' is logged in':$user->first_name.' '.$user->last_name.' is logged out';
                $response['user_status'] = $request['user_status'];
                $response['time'] = $previous;
                $response['status'] = true;
                $response['code'] = 200;
            }
            else if($user->user_status == null){
                $loggedin = $this->user->edit('id',$this->data,$user->id);
                
                $current = strtotime( $user->updated_at );
                $previous = $this->time->timePrevious($current);
                // echo "<pre>";
                // print_r($newUser);
                // exit();
                $response['message'] = ($user->user_status == 1)?$user->first_name.' '.$user->last_name.' is logged in':$user->first_name.' '.$user->last_name.' is logged out';
                $response['user_status'] = $request['user_status'];
                $response['time'] = $previous;
                $response['status'] = true;
                $response['code'] = 201;
            }
            else{
                $loggedin = $this->user->edit('id',$this->data,$user->id);
                
                $current = strtotime( $user->updated_at );
                $previous = $this->time->timePrevious($current);
                // echo "<pre>";
                // print_r($newUser);
                // exit();
                $response['message'] = ($user->user_status == 1)?$user->first_name.' '.$user->last_name.' is logged in':$user->first_name.' '.$user->last_name.' is logged out';
                $response['user_status'] = $request['user_status'];
                $response['time'] = $previous;
                $response['status'] = true;
                $response['code'] = 201;
            }
        }
        else{
            $response['message'] = 'Authenticate Errors!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function follow($request)
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'from_user_id'=>$request['from_user_id'],
                'to_user_id'=>$request['to_user_id'],
                'follow'=> $request['follow']
            ];
            $follow = $this->userFollow->twoWhere(
                'from_user_id', 
                $request['from_user_id'], 
                'to_user_id',
                $request['to_user_id']
            );
            if($follow){
                if($request['follow'] == 1)
                {
                    $this->userFollow->unfollowFollow(
                        'from_user_id', 
                        $request['from_user_id'], 
                        'to_user_id',
                        $request['to_user_id'],
                        $this->data
                    );
                    $response['message'] = 'You follow this user!';
                }
                else{
                    $this->userFollow->unfollowFollow(
                        'from_user_id', 
                        $request['from_user_id'], 
                        'to_user_id',
                        $request['to_user_id'],
                        $this->data
                    );
                    $response['message'] = 'You unfollow this user!';
                }
            }
            else{
                $this->userFollow->store($this->data);
                $response['message'] = 'You follow this user!';
            }
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Errors!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function followersFollowings($column1,$column2)
    {
        $auth = Auth::user();
        if($auth)
        {
            $follow = $this->userFollow->twoWhere(
                $column2,
                $auth->id,
                'follow',
                1
            );

            $user_id_array = [];
            foreach ($follow as $key) {
                array_push($user_id_array,$key[$column1]);
            }

            $user_id_array = array_unique($user_id_array);

            $friends = $this->user
            ->allFriends
            (
                'id',
                $user_id_array,
                [
                    'id',
                    'user_profile',
                    'user_slug',
                    'unique_id',
                    'user_status',
                    DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
                ],
            );
            $response['users'] = $friends;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Errors!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function allFollowers()
    {
        return $this->followersFollowings('from_user_id','to_user_id');
    }

    public function allFollowings()
    {
        return $this->followersFollowings('to_user_id','from_user_id');
    }
}