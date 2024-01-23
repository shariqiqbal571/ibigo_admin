<?php 

namespace App\Services\BusinessUser;

use App\Repositories\Spot\SpotInterface;
use App\Repositories\User\UserInterface;
use App\Models\User;
use App\Repositories\Interest\InterestInterface;
use App\Repositories\Agreegate\AgreegateInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use App\Services\Communication\CommunicationService;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class BusinessUserService
{
    private $spot;
    private $user;
    private $interest;
    private $validator;
    private $agreegate;
    private $response;
    private $request;
    private $data = [];

    public function __construct(
        Validator $validator,
        SpotInterface $spot,
        UserInterface $user,
        InterestInterface $interest,
        AgreegateInterface $agreegate,
        Response $response,
        Request $request
    )
    {
        $this->spot = $spot;
        $this->user = $user;
        $this->interest = $interest;
        $this->agreegate = $agreegate;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function validateSpotUser($request)
    {
        return $this->validator->make($request,[
            'business_name'=> 'required|unique:spots',
            'email' => 'required|email|unique:users|string',
            'business_type' => 'required',
            'mobile' => 'required',
            'password' => 'required|min:6|max:15|confirmed',
            'accept_email'=>'required',
            'terms_conditions' => 'required'
        ]);
    }

    public function create($request)
    {
        $validate = $this->validateSpotUser($request);

        if($validate->fails())
        {
            $response['message'] = $validate->errors();
            $response['status'] = false;
            return response()->json($response,401);
        }
        else
        {
            $userToken = new User;
            $this->data = [
                'first_name' => (isset($request['first_name']) ? $request['first_name'] : null),
                'last_name' => (isset($request['last_name']) ? $request['last_name'] : null),
                'username' => $request['business_name'],
                'birth_date'=>(isset($request['birth_date']) ? $request['birth_date'] : null),
                'user_about'=>(isset($request['user_about']) ? $request['user_about'] : null),
                'city'=>(isset($request['city']) ? $request['city'] : null),
                'full_address'=>(isset($request['full_address']) ? $request['full_address'] : null),
                'gender'=>(isset($request['gender']) ? $request['gender'] : null),
                'mobile_opt'=>rand(100000, 999999),
                'user_interests'=>(isset($request['user_interests']) ? $request['user_interests'] : null),
                'unique_id'=>Str::uuid(),
                'mobile' =>$request['mobile'],
                'country_code' =>(isset($request['country_code']) ? $request['country_code'] : 31),
                'country_short_code'=>(isset($request['country_short_code']) ? $request['country_short_code'] : 'NL'),
                'user_slug'=> Str::slug($request['business_name'],'-'),
                'email'=>$request['email'],
                'password'=>Hash::make($request['password']),
                'user_type'=>'business',
                'user_profile'=>(isset($request['profile']) ? $request['profile'] : null),
                'user_cover'=>(isset($request['cover']) ? $request['cover'] : null),
                'accept_email'=>$request['accept_email'],
                'terms_conditions'=>$request['terms_conditions'],
                'user_api_token'=> $userToken->createToken('My Token')->accessToken,
                'user_status'=>1
            ];


            $user = $this->user->store($this->data);

            $user_id = $user->id;
            // echo "<pre>";
            // print_r($user_id);
            // exit();
            $this->data = [
                'user_id'=>$user_id,
                'street_no'=>(isset($request['street_no'])?$request['street_no']:null),
                'postal_code'=>(isset($request['postal_code'])?$request['postal_code']:null),
                'city'=>(isset($request['city'])?$request['city']:null),
                'latitude'=>(isset($request['latitude'])?$request['latitude']:null),
                'longitude'=>(isset($request['longitude'])?$request['longitude']:null),
                'phone_number'=>(isset($request['phone_number'])?$request['phone_number']:null),
                'business_name'=>(isset($request['business_name'])?$request['business_name']:null),
                'business_type'=>(isset($request['business_type'])?$request['business_type']:null),
                'business_status'=>(isset($request['business_status'])?$request['business_status']:null),
                'place_id'=>(isset($request['place_id'])?$request['place_id']:null),
                'parking_details'=>(isset($request['parking_details'])?$request['parking_details']:null),
                'rating'=>(isset($request['rating'])?$request['rating']:null),
                'user_total_rating'=>(isset($request['user_total_rating'])?$request['user_total_rating']:null),
                'spot_profile'=>(isset($request['profile']) ? $request['profile'] : null),
                'spot_cover'=>(isset($request['cover']) ? $request['cover'] : null),
            ];
            $spot = $this->spot->store($this->data);

            $subscription = $this->agreegate->subscription($user,$request);

            try {
                $verify_url = env('APP_URL');
                $email_data = array(
                    'name' => $this->data['first_name'].' '.$this->data['last_name'],
                    'email' => $this->data['email'],
                    // 'link' => env('APP_URL'),
                    'link' => $verify_url.'?verify_token='.$this->data['user_api_token'],
                );
                CommunicationService::sendMail('Registration', $email_data);
            } catch (\Exception $th) {

            }
            

            $response['message'] = 'You are registered successfully';
            $response['status'] = true;
            return response()->json($response,200);
        }
    }

    public function profile()
    {
        $user = Auth::user();
        if($user)
        {
            $business = $this->user->authUser(
                [
                    'spot.ownerImages','spot.ownerVideos'
                ],
                'id',
                $user->id
            );
            $interests = [];
            $interests[] = explode(',', $business[0]['user_interests']);
            $interest = $this->interest->authInterest('id',$interests,['id','image']);
            
            $business[0]['interest'] = $interest;
            
            $response['profile'] = $business;
            $response['status'] = true;
            $response['status_code'] = 201;
            
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function edit($request)
    {
        $user = Auth::user();
        $id = $user->id;
        if($user)
        {
            $oldUser = $this->user->where('id',$id);
            $this->data = [
                'first_name' => (isset($request['first_name']) ? $request['first_name'] : $oldUser[0]['first_name']),
                'last_name' => (isset($request['last_name']) ? $request['last_name'] : $oldUser[0]['last_name']),
                'username' => (isset($request['business_name']) ? $request['business_name'] : $oldUser[0]['username']),
                'birth_date'=>(isset($request['birth_date']) ? $request['birth_date'] : $oldUser[0]['birth_date']),
                'user_about'=>(isset($request['user_about']) ? $request['user_about'] : $oldUser[0]['user_about']),
                'city'=>(isset($request['city']) ? $request['city'] : $oldUser[0]['city']),
                'full_address'=>(isset($request['full_address']) ? $request['full_address'] : $oldUser[0]['full_address']),
                'gender'=>(isset($request['gender']) ? $request['gender'] : $oldUser[0]['gender']),
                'user_interests'=>(isset($request['user_interests']) ? $request['user_interests'] : $oldUser[0]['user_interests']),
                'mobile' =>(isset($request['mobile']) ? $request['mobile'] : $oldUser[0]['mobile']),
                'country_code' =>(isset($request['country_code']) ? $request['country_code'] : $oldUser[0]['country_code']),
                'country_short_code'=>(isset($request['country_short_code']) ? $request['country_short_code'] : $oldUser[0]['country_short_code']),
                'user_slug'=> (isset($request['business_name']) ? Str::slug($request['business_name'],'-') : $oldUser[0]['user_slug']),
                'user_profile'=>(isset($request['profile']) ? $request['profile'] : $oldUser[0]['user_profile']),
                'user_cover'=>(isset($request['cover']) ? $request['cover'] : $oldUser[0]['user_cover']),
            ];
    
            $user = $this->user->edit('id',$this->data,$id);
            // echo "<pre>";
            // print_r($user_id);
            // exit();
            $oldSpot = $this->spot->where('user_id',$id);
            $this->data = [
                'street_no'=>(isset($request['street_no']) ? $request['street_no'] : $oldSpot[0]['street_no']),
                'postal_code'=>(isset($request['postal_code']) ? $request['postal_code'] : $oldSpot[0]['postal_code']),
                'city'=>(isset($request['city']) ? $request['city'] : $oldSpot[0]['city']),
                'latitude'=>(isset($request['latitude']) ? $request['latitude'] : $oldSpot[0]['latitude']),
                'longitude'=>(isset($request['longitude']) ? $request['longitude'] : $oldSpot[0]['longitude']),
                'phone_number'=>(isset($request['phone_number']) ? $request['phone_number'] : $oldSpot[0]['phone_number']),
                'business_name'=>(isset($request['business_name']) ? $request['business_name'] : $oldSpot[0]['business_name']),
                'place_id'=>(isset($request['place_id']) ? $request['place_id'] : $oldSpot[0]['place_id']),
                'parking_details'=>(isset($request['parking_details']) ? $request['parking_details'] : $oldSpot[0]['parking_details']),
                'rating'=>(isset($request['rating']) ? $request['rating'] : $oldSpot[0]['rating']),
                'user_total_rating'=>(isset($request['user_total_rating']) ? $request['user_total_rating'] : $oldSpot[0]['user_total_rating']),
                'spot_profile'=>(isset($request['profile']) ? $request['profile'] : $oldSpot[0]['spot_profile']),
                'spot_cover'=>(isset($request['cover']) ? $request['cover'] : $oldSpot[0]['spot_cover']),
            ];
            $spot = $this->spot->where('user_id',$this->data,$id);
            $response['message'] = 'Your Profile successfully updated!';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function updatePictures($request)
    {
        $user = Auth::user();
        $id = $user->id;
        if($user)
        {
            $oldUser = $this->user->where('id',$id);
            
            $this->data = [
                'user_profile'=>(isset($request['profile']) ? $request['profile'] : $oldUser[0]['user_profile']),
                'user_cover'=>(isset($request['cover']) ? $request['cover'] : $oldUser[0]['user_cover']),
            ];

            $user = $this->user->edit('id',$this->data,$id);
            // echo "<pre>";
            // print_r($user_id);
            // exit();
            $oldSpot = $this->spot->where('user_id',$id);
            $this->data = [
                'spot_profile'=>(isset($request['profile']) ? $request['profile'] : $oldSpot[0]['spot_profile']),
                'spot_cover'=>(isset($request['cover']) ? $request['cover'] : $oldSpot[0]['spot_cover']),
            ];
            $spot = $this->spot->where('user_id',$this->data,$id);
            $response['message'] = 'Your Pictures successfully updated!';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function payment($request)
    {
        $this->data = [
            'id'=>$request['id']
        ];
        $payment = $this->agreegate->getPayment($this->data);
        return $payment;
    }

    public function mailTest($request)
    {
        $payment = $this->agreegate->mailTestFor($request);
        return $payment;
    }
}