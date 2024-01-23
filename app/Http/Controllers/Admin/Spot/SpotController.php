<?php

namespace App\Http\Controllers\Admin\Spot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use App\Models\Interest;
use App\Models\User;
use App\Models\Spot;
use FoursquareApi;

class SpotController extends Controller
{
    private $catIds = ['4bf58dd8d48988d1f9941735','503288ae91d4c4b30a586d67','4bf58dd8d48988d1c8941735','4bf58dd8d48988d10a941735','4bf58dd8d48988d14e941735','4bf58dd8d48988d142941735','4bf58dd8d48988d145941735','4bf58dd8d48988d111941735','4bf58dd8d48988d1d2941735','4bf58dd8d48988d113941735','4bf58dd8d48988d149941735','4bf58dd8d48988d14a941735','4bf58dd8d48988d1df931735','4bf58dd8d48988d16a941735','52e81612bcbc57f1066b7a02','52e81612bcbc57f1066b79f1','4bf58dd8d48988d143941735','4bf58dd8d48988d16c941735','4bf58dd8d48988d128941735','4bf58dd8d48988d16d941735','4bf58dd8d48988d144941735','4bf58dd8d48988d154941735','4bf58dd8d48988d1e0931735','4bf58dd8d48988d1d0941735','4bf58dd8d48988d1c9941735','5744ccdfe4b0c0459246b4e2','4bf58dd8d48988d147941735','4bf58dd8d48988d148941735','4bf58dd8d48988d108941735','5744ccdfe4b0c0459246b4d0','4bf58dd8d48988d109941735','52e81612bcbc57f1066b7a05','4bf58dd8d48988d16e941735','4bf58dd8d48988d120951735','4bf58dd8d48988d1cb941735','4bf58dd8d48988d10c941735','57558b36e4b065ecebd306b0','4d4ae6fc7a7b7dea34424761','4bf58dd8d48988d10e941735','53d6c1b0e4b02351e88a83d6','4bf58dd8d48988d1cc941735','52e81612bcbc57f1066b79ff','4bf58dd8d48988d16f941735','4bf58dd8d48988d10f941735','52e81612bcbc57f1066b7a06','4bf58dd8d48988d110941735','52e81612bcbc57f1066b79fd','4bf58dd8d48988d112941735','4bf58dd8d48988d1be941735','4bf58dd8d48988d1cd941735','4bf58dd8d48988d1c3941735','4bf58dd8d48988d1c1941735','4bf58dd8d48988d115941735','5bae9231bedf3950379f89e4','4bf58dd8d48988d1ca941735','4def73e84765ae376e57713a','4bf58dd8d48988d150941735','4bf58dd8d48988d1db931735','4bf58dd8d48988d1c4941735','5293a7563cf9994f4e043a44','4f04af1f2fb6e1c99f3db0bb','4bf58dd8d48988d1d3941735','52f2ab2ebcbc57f1066b8b31','4bf58dd8d48988d11f941735','52e81612bcbc57f1066b79ec','4bf58dd8d48988d11d941735','50327c8591d4c4b30a586d5d','4bf58dd8d48988d121941735','4bf58dd8d48988d133951735','4bf58dd8d48988d1ea941735','4bf58dd8d48988d18e941735','4bf58dd8d48988d116941735','4bf58dd8d48988d182941735','4bf58dd8d48988d193941735','4bf58dd8d48988d167941735','4bf58dd8d48988d168941735','52e81612bcbc57f1066b7a11','4bf58dd8d48988d1e9941735','58daa1558bbb0b01f18ec1b9','4bf58dd8d48988d1e1931735','4bf58dd8d48988d1e4931735','52e81612bcbc57f1066b79ea','52e81612bcbc57f1066b79eb','52e81612bcbc57f1066b79e8','4bf58dd8d48988d1f4931735','5bae9231bedf3950379f89c5','4bf58dd8d48988d1e6941735','5032829591d4c4b30a586d5e','4bf58dd8d48988d17c941735','4bf58dd8d48988d1e2931735','4bf58dd8d48988d181941735','4deefb944765f83613cdba6e','4bf58dd8d48988d18f941735','4bf58dd8d48988d190941735','4bf58dd8d48988d191941735','4bf58dd8d48988d1f2931735','52e81612bcbc57f1066b79ee','58daa1558bbb0b01f18ec1d6','4bf58dd8d48988d17f941735','4bf58dd8d48988d137941735','52e81612bcbc57f1066b79e7','4bf58dd8d48988d1e5931735','5267e4d9e4b0ec79466e48c7','5267e4d9e4b0ec79466e48d1','4bf58dd8d48988d1e7931735','4bf58dd8d48988d1e2941735','4bf58dd8d48988d1e3941735','56aa371be4b08b9a8d57355e','50aaa49e4b90af0d42d5de11','52e81612bcbc57f1066b7a0f','52e81612bcbc57f1066b7a23','50aaa4314b90af0d42d5de10','4bf58dd8d48988d161941735','52e81612bcbc57f1066b7a21','4bf58dd8d48988d163941735','4bf58dd8d48988d162941735','4bf58dd8d48988d1e7941735','5bae9231bedf3950379f89c7','4bf58dd8d48988d102941735','4bf58dd8d48988d1ed941735','4bf58dd8d48988d12f951735','50aa9e094b90af0d42d5de0d','4bf58dd8d48988d1f7941735','56aa371be4b08b9a8d573505','52f2ab2ebcbc57f1066b8b3c','5744ccdfe4b0c0459246b4df','52f2ab2ebcbc57f1066b8b35','4bf58dd8d48988d1fd941735','4d4b7105d754a06374d81259','4d4b7104d754a06370d81259','4d4b7105d754a06377d81259','4d4b7105d754a06373d81259'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spots = Spot::orderBy('id', 'desc')->paginate(10);
       return view('admin/spot/view')->with(compact('spots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interests = Interest::get(['id','image'])->toArray();
        return view('admin/spot/add')->with(compact('interests'));
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
            'business_type' => 'required',
            'email' => 'required|email|unique:users|string',
            'mobile' => 'required|unique:users',
           ]);
        if($validator->passes())
        {
            $place_id = '';
            $address = $request->postal_code .' '. $request->street_no .' ' . $request->city;
            if($request->postal_code && $request->street_no && $request->city)
            {
                $lat = '';
                $long = '';
                    
                $address = str_replace(" ", "+", $address);

                $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=true&key=AIzaSyB3pExTBkEm9-h5Eb-C44qEkVzHAUpgtrw");
                $json = json_decode($json);
                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $place_id = $json->{'results'}[0]->{'place_id'};
            }
            else{
                $lat =  '52.407956';
                $long = '4.897070';
            }
            if($request->spot_place)
            {
                $endpoint = "venues/search";

                $ll = "$lat,$long";
                
                $categoryId = '';
        
        
                foreach($this->catIds as $key => $value){
                    $categoryId .= trim($value).',';
                }
        
                $foursquare = new FoursquareApi("B1G1LCQ0LYQHZN51RPG2WNNMJJASCCBDLGBPIP1STC0JLVUH", "EFM2LW1VUBNWFO1NEQPRKVEAAH2IE0IFZBRHO2FXTAJ0EKLF");
        
                $endpoint = "venues/search";
        
                $params = array("near"=>$request->spot_place,'limit'=>10,'radius'=>250,'categoryId'=>trim($categoryId));
        
                $response = $foursquare->GetPublic($endpoint,$params);
        
                $arr = json_decode($response,true);
                // echo "<pre>";
                // print_r();
                // exit();
                $business_name = $arr['response']['venues'][0]['name'];

            }
            else{
                $business_name = $request->spot_name;
            }
            $user = new User;

            $user->unique_id = Str::random(32);
            if($request->mobile)
            {
                $user->country_code = 31;
                $user->country_short_code = 'NL';
                $user->mobile = $request->mobile;
            }
            $user->username = Str::lower($business_name);
            $user->user_slug = Str::slug($business_name,'-');
            $user->user_about = $request->long_description;
            if($request->user_interests)
            {
                $user->user_interests = null;
                $user->user_interests = implode(',',$request->user_interests);
            }
            else
            {
                $user->user_interests = null;
            }
            $user->email = $request->email;
            $user->password = Hash::make(0000);
            $user->user_type = 'business';
            
            if($request->hasfile('user_profle'))
            {
                $destination = 'public/images/user/profile';
                $user_photo = $request->file('user_profle');
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
                $token = $user->createToken('My Token')->accessToken;
                $user->user_api_token = $token;
                $user->accept_email = 1;
                $user->terms_conditions = 1;
                $user->save();
        

                $userid = $user->id;
                $spot = new Spot;
                $spot->user_id = $userid;
                $spot->street_no = $request->street_no;
                $spot->postal_code = $request->postal_code;
                $spot->city = $request->city;
                
            if($request->hasfile('spot_profile'))
            {
                $destination = 'public/images/spot/spot-photo/profile';
                $cover_photo = $request->file('spot_profile');
                $coverphoto = uniqid().$cover_photo->getClientOriginalName();
                $path = $cover_photo->storeAs($destination,$coverphoto);

                $spot->spot_profile = $coverphoto;

            }
            
            if($request->hasfile('spot_cover')){
                $destination = 'public/images/spot/spot-cover/cover';
                $spot_cover_photo = $request->file('spot_cover');
                $spotcover = uniqid().$spot_cover_photo->getClientOriginalName();
                $path = $spot_cover_photo->storeAs($destination,$spotcover);

                $spot->spot_cover = $spotcover;
            }

            $spot->phone_number = $request->phone_number;
            $spot->short_description = $request->short_description;
            
            $spot->business_type = $request->business_type;
            $spot->business_name = $business_name;
            $spot->parking_details = $request->spot_place; 
            $spot->place_id = $place_id; 
            
            $spot->longitude = $long;
            $spot->latitude = $lat;
        
            $spot->save();
            return redirect('admin/spot')->with('msg','Add New spot Successfully.');
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
        $spots = Spot::with('user')->where('id',$id)->first()->toArray();

        // echo "<pre>";
        // print_r($spots);
        // exit();
        $intrestId = explode(",",$spots['user']['user_interests']);
        $interests = Interest::get(['id','image'])->toArray();

        return view('admin/spot/update')->with(compact('spots','interests','intrestId'));
      
        
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
        $address = $request->postal_code .' '. $request->street_no .' ' . $request->city;
        if($request->postal_code && $request->street_no && $request->city)
        {
            $lat = '';
            $long = '';
                
            $address = str_replace(" ", "+", $address);

            $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=true&key=AIzaSyB3pExTBkEm9-h5Eb-C44qEkVzHAUpgtrw");
            $json = json_decode($json);
            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            $place_id = $json->{'results'}[0]->{'place_id'};
        }
        else{
            $lat =  '52.407956';
            $long = '4.897070';
        }
        
        $spot = Spot::find($id);
        $userId = $spot['user_id'];
        $user = User::find($userId);

        if($request->confirm_password == $request->password)
        {
            $spot->business_type = $request->business_type;
            if($request->hasfile('spot_profile'))
            {
                $destination = 'public/images/spot/spot-photo/profile';
                $cover_photo = $request->file('spot_profile');
                $coverphoto = uniqid().$cover_photo->getClientOriginalName();
                $path = $cover_photo->storeAs($destination,$coverphoto);

                $spot->spot_profile = $coverphoto;

            }
            if($request->hasfile('spot_cover')){
                $destination = 'public/images/spot/spot-cover/cover';
                $spot_cover_photo = $request->file('spot_cover');
                $spotcover = uniqid().$spot_cover_photo->getClientOriginalName();
                $path = $spot_cover_photo->storeAs($destination,$spotcover);

                $spot->spot_cover = $spotcover;
            }
            $spot->short_description = $request->short_description;
            $spot->street_no = $request->street_no;
            $spot->postal_code = $request->postal_code;
            $spot->city = $request->city;  
            
            $spot->phone_number = $request->phone_number;
            $spot->longitude = $long;
            $spot->latitude = $lat;
            $spot->save();
            $user->email = $request->email; //user  email
            $user->mobile = $request->mobile; //user mobile
            $user->user_about = $request->long_description;  //user about
            $user->password = Hash::make($request->password); //user password
            if($request->user_interests)
            {
                $user->user_interests = null;
                $user->user_interests = implode(',',$request->user_interests);
            }
            else
            {
                $user->user_interests = null;
            }
            $user->save();
            return redirect('admin/spot')->with('msg','Update Spot Successfully.');
            
        
        }    
        else
            { 
                return back()->with('notmatch','Password is not matching');
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
        Spot::find($id)->delete();
        return redirect('admin/spot')->with('msg','Spot delete Successfully.');

    }
}
