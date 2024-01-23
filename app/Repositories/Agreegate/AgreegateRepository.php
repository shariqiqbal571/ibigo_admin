<?php 

namespace App\Repositories\Agreegate;

use App\Repositories\FourSquare\FourSquareInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Spot\SpotInterface;
use App\Repositories\CMS\CMSInterface;
use App\Repositories\Subscription\SubscriptionInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use FoursquareApi;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentMail;
use Auth;

class AgreegateRepository implements AgreegateInterface
{
    private $foursquare;
    private $user;
    private $cms;
    private $spot;
    private $validator;
    private $subscription;
    private $response;
    private $request;
    private $data = [];
    private $fourSpot = [];
    private $params = [];
    private $catIds = ['4bf58dd8d48988d1f9941735','503288ae91d4c4b30a586d67','4bf58dd8d48988d1c8941735','4bf58dd8d48988d10a941735','4bf58dd8d48988d14e941735','4bf58dd8d48988d142941735','4bf58dd8d48988d145941735','4bf58dd8d48988d111941735','4bf58dd8d48988d1d2941735','4bf58dd8d48988d113941735','4bf58dd8d48988d149941735','4bf58dd8d48988d14a941735','4bf58dd8d48988d1df931735','4bf58dd8d48988d16a941735','52e81612bcbc57f1066b7a02','52e81612bcbc57f1066b79f1','4bf58dd8d48988d143941735','4bf58dd8d48988d16c941735','4bf58dd8d48988d128941735','4bf58dd8d48988d16d941735','4bf58dd8d48988d144941735','4bf58dd8d48988d154941735','4bf58dd8d48988d1e0931735','4bf58dd8d48988d1d0941735','4bf58dd8d48988d1c9941735','5744ccdfe4b0c0459246b4e2','4bf58dd8d48988d147941735','4bf58dd8d48988d148941735','4bf58dd8d48988d108941735','5744ccdfe4b0c0459246b4d0','4bf58dd8d48988d109941735','52e81612bcbc57f1066b7a05','4bf58dd8d48988d16e941735','4bf58dd8d48988d120951735','4bf58dd8d48988d1cb941735','4bf58dd8d48988d10c941735','57558b36e4b065ecebd306b0','4d4ae6fc7a7b7dea34424761','4bf58dd8d48988d10e941735','53d6c1b0e4b02351e88a83d6','4bf58dd8d48988d1cc941735','52e81612bcbc57f1066b79ff','4bf58dd8d48988d16f941735','4bf58dd8d48988d10f941735','52e81612bcbc57f1066b7a06','4bf58dd8d48988d110941735','52e81612bcbc57f1066b79fd','4bf58dd8d48988d112941735','4bf58dd8d48988d1be941735','4bf58dd8d48988d1cd941735','4bf58dd8d48988d1c3941735','4bf58dd8d48988d1c1941735','4bf58dd8d48988d115941735','5bae9231bedf3950379f89e4','4bf58dd8d48988d1ca941735','4def73e84765ae376e57713a','4bf58dd8d48988d150941735','4bf58dd8d48988d1db931735','4bf58dd8d48988d1c4941735','5293a7563cf9994f4e043a44','4f04af1f2fb6e1c99f3db0bb','4bf58dd8d48988d1d3941735','52f2ab2ebcbc57f1066b8b31','4bf58dd8d48988d11f941735','52e81612bcbc57f1066b79ec','4bf58dd8d48988d11d941735','50327c8591d4c4b30a586d5d','4bf58dd8d48988d121941735','4bf58dd8d48988d133951735','4bf58dd8d48988d1ea941735','4bf58dd8d48988d18e941735','4bf58dd8d48988d116941735','4bf58dd8d48988d182941735','4bf58dd8d48988d193941735','4bf58dd8d48988d167941735','4bf58dd8d48988d168941735','52e81612bcbc57f1066b7a11','4bf58dd8d48988d1e9941735','58daa1558bbb0b01f18ec1b9','4bf58dd8d48988d1e1931735','4bf58dd8d48988d1e4931735','52e81612bcbc57f1066b79ea','52e81612bcbc57f1066b79eb','52e81612bcbc57f1066b79e8','4bf58dd8d48988d1f4931735','5bae9231bedf3950379f89c5','4bf58dd8d48988d1e6941735','5032829591d4c4b30a586d5e','4bf58dd8d48988d17c941735','4bf58dd8d48988d1e2931735','4bf58dd8d48988d181941735','4deefb944765f83613cdba6e','4bf58dd8d48988d18f941735','4bf58dd8d48988d190941735','4bf58dd8d48988d191941735','4bf58dd8d48988d1f2931735','52e81612bcbc57f1066b79ee','58daa1558bbb0b01f18ec1d6','4bf58dd8d48988d17f941735','4bf58dd8d48988d137941735','52e81612bcbc57f1066b79e7','4bf58dd8d48988d1e5931735','5267e4d9e4b0ec79466e48c7','5267e4d9e4b0ec79466e48d1','4bf58dd8d48988d1e7931735','4bf58dd8d48988d1e2941735','4bf58dd8d48988d1e3941735','56aa371be4b08b9a8d57355e','50aaa49e4b90af0d42d5de11','52e81612bcbc57f1066b7a0f','52e81612bcbc57f1066b7a23','50aaa4314b90af0d42d5de10','4bf58dd8d48988d161941735','52e81612bcbc57f1066b7a21','4bf58dd8d48988d163941735','4bf58dd8d48988d162941735','4bf58dd8d48988d1e7941735','5bae9231bedf3950379f89c7','4bf58dd8d48988d102941735','4bf58dd8d48988d1ed941735','4bf58dd8d48988d12f951735','50aa9e094b90af0d42d5de0d','4bf58dd8d48988d1f7941735','56aa371be4b08b9a8d573505','52f2ab2ebcbc57f1066b8b3c','5744ccdfe4b0c0459246b4df','52f2ab2ebcbc57f1066b8b35','4bf58dd8d48988d1fd941735','4d4b7105d754a06374d81259','4d4b7104d754a06370d81259','4d4b7105d754a06377d81259','4d4b7105d754a06373d81259'];

    public function __construct(
        Validator $validator,
        FourSquareInterface $foursquare,
        SubscriptionInterface $subscription,
        CMSInterface $cms,
        UserInterface $user,
        SpotInterface $spot,
        Response $response,
        Request $request
    )
    {
        $this->foursquare = $foursquare;
        $this->subscription = $subscription;
        $this->cms = $cms;
        $this->user = $user;
        $this->spot = $spot;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function findFoursquare()
    {
        $getCity = 'Amsterdam';
        $isLatChang = false;
        $getCurrentLimit = $this->foursquare->currentLimit('id','desc');
        
        if(!empty($getCurrentLimit)){
            $latitude =  $getCurrentLimit[0]['current_latitude'];
            $longitude = $getCurrentLimit[0]['current_longitude']; 
            $totalRecords = $getCurrentLimit[0]['total_records'];
            $currentLimit = $getCurrentLimit[0]['current_limit'] + 50;
            
            if($currentLimit > $totalRecords){
                $isLatChang = true;
                $addVal = '0.01';
                $latitude =  $latitude + $addVal;
                
                $currentLimit = 0;
            }
        }else{
            $latitude =  '52.377956';
            $longitude = '4.897070';
            $currentLimit = 0;
        }

        $latitudeLongitude = $latitude.','.$longitude;
        $categoryId = '';


        foreach($this->catIds as $key => $value){
            $categoryId .= trim($value).',';
        }
        
        
        $foursquare = new FoursquareApi("B1G1LCQ0LYQHZN51RPG2WNNMJJASCCBDLGBPIP1STC0JLVUH", "EFM2LW1VUBNWFO1NEQPRKVEAAH2IE0IFZBRHO2FXTAJ0EKLF");

        $endpoint = "venues/explore";
        $data = array(
            "near"=>$getCity,
            'offset'=> $currentLimit,
            'limit'=>10,
            'categoryId'=>trim($categoryId)
        );
        
        $response1 = $foursquare->GetPublic($endpoint,$data);
        
        
        $array = json_decode($response1,true);
        if(isset($array['response']['groups'])){            
            if($isLatChang){
                $this->data = [
                    'total_records'=>$array['response']['totalResults'],
                    'current_latitude' =>$latitude,
                    'current_longitude' =>$longitude,
                    'current_limit' => $currentLimit
                ];
                $fourSquare = $this->foursquare->store($this->data);
            }
                
            foreach ($array['response']['groups'] as $values) {
                foreach ($values['items'] as $key => $value) {

                    $user = $this->user->where('unique_id',$value['venue']['id']);
                    if(empty($user)){
                        $street_no = isset($value['venue']['location']['formattedAddress'][0])? $value['venue']['location']['formattedAddress'][0]:"";
                        $postal_code = isset($value['venue']['location']['formattedAddress'][1])?', '.$value['venue']['location']['formattedAddress'][1]:"";
                        $city = isset($value['venue']['location']['formattedAddress'][2])?', '.$value['venue']['location']['formattedAddress'][2]:"";

                        $pgotendpoint = 'venues/'.$value['venue']['id'].'/photos';
                        $photoresponse = $foursquare->GetPublic($pgotendpoint,$this->params);
                        $photoArr = json_decode($photoresponse,true);

                        $profileURl = '';

                        if(isset($photoArr['response']['photos']['items'][0]['prefix'])){
                            $profileURl = $photoArr['response']['photos']['items'][0]['prefix'].'300x500'.$photoArr['response']['photos']['items'][0]['suffix'];
                        }
                        $username = $value['venue']['name'].' '.Str::random('5');
                        $slug = $this->slugify($value['venue']['name']);
                        $this->data = [
                            'unique_id'=>$value['venue']['id'],
                            'user_slug'=>$slug,
                            'user_profile'=>$profileURl,
                            'user_type'=>'business'
                        ];

                        $newUser = $this->user->store($this->data);
                            
                            
                        $this->data = [
                            'user_id' => $newUser->id,
                            'postal_code'=>str_replace(',', '', $postal_code),
                            'street_no'=>str_replace(',', '', $street_no),
                            'city'=>str_replace(',', '', $city),
                            'latitude'=>$value['venue']['location']['lat'],
                            'longitude'=>$value['venue']['location']['lng'],
                            'business_name'=>$value['venue']['name'],
                            'business_type'=>'basic'
                        ];
                        $businessDetails = $this->spot->store($this->data);
                            
                        if(!$isLatChang){
                            $this->data = [
                                'current_limit'=>$currentLimit
                            ];
                            $updateFoursqure = $this->foursquare->edit('id',$this->data,$getCurrentLimit[0]['id']);
                        }
                        $response['business'] =$newUser->id;
                        $response['message'] = 'New Business saved!';
                        $response['status'] = true;
                        $response['status_code'] = 201;
                    }
                    else{
                        if(!$isLatChang){
                            $this->data = [
                                'current_limit'=>$currentLimit
                            ];
                            $updateFoursqure = $this->foursquare->edit('id',$this->data,$getCurrentLimit[0]['id']);
                        }
                        $response['message'] = 'New Business updated!';
                        $response['status'] = true;
                        $response['status_code'] = 201;
                    }
                }
            }
        }
        else {
            $response['message'] = 'No FourSquare Found!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }
    
    public function foursquareSearch($request,$all_spots)
    {
        $searchAddress = isset($request['searchAddress']) ? $request['searchAddress'] :null;
        if($request['latitude'] && $request['longitude'])
        {
            $latitude = $request['latitude'];
            $longitude = $request['longitude'];
        }
        else{
            $latitude =  '52.407956';
            $longitude = '4.897070';
        }
        
        $geodata = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&sensor=true&key=AIzaSyB3pExTBkEm9-h5Eb-C44qEkVzHAUpgtrw");
        $geodataArrs = json_decode($geodata,true);

        $getCity = '';
        if(isset($geodataArrs['results'][0]['address_components'][0]['long_name'])){
            $getCity = $geodataArrs['results'][0]['address_components'][0]['long_name'];
        }

        $endpoint = "venues/search";

       $ll = "$latitude,$longitude";
       
       $categoryId = '';


       foreach($this->catIds as $key => $value){
           $categoryId .= trim($value).',';
       }

       $foursquare = new FoursquareApi("B1G1LCQ0LYQHZN51RPG2WNNMJJASCCBDLGBPIP1STC0JLVUH", "EFM2LW1VUBNWFO1NEQPRKVEAAH2IE0IFZBRHO2FXTAJ0EKLF");

       $endpoint = "venues/search";

       if($searchAddress != "" || $searchAddress != null){
           $params = array("near"=>$searchAddress,'limit'=>10,'radius'=>250,'categoryId'=>trim($categoryId));
       }else{
            $params = array("near"=>$getCity,'limit'=>10,'radius'=>250,'categoryId'=>trim($categoryId));
       }

       $response = $foursquare->GetPublic($endpoint,$params);

       $arr = json_decode($response,true);

       $fourspot = array();

       if(isset($arr['response']['venues'])){
           foreach ($arr['response']['venues'] as $key => $value) {

               $address = isset($value['location']['formattedAddress'][0])?$value['location']['formattedAddress'][0]:"";
               $address .= isset($value['location']['formattedAddress'][1])?', '.$value['location']['formattedAddress'][1]:"";
               $address .= isset($value['location']['formattedAddress'][2])?', '.$value['location']['formattedAddress'][2]:"";

               $params1 = array();

               $pgotendpoint = 'venues/'.$value['id'].'/photos';
               $photoresponse = $foursquare->GetPublic($pgotendpoint,$params1);
               $photoArr = json_decode($photoresponse,true);

               $profileURl = '';

               if(isset($photoArr['response']['photos']['items'][0]['prefix'])){
                   $profileURl = $photoArr['response']['photos']['items'][0]['prefix'].'300x500'.$photoArr['response']['photos']['items'][0]['suffix'];
               }

               $fourspot = [
                   'user_id'=>$value['id'],
                   'user_profile'=>$profileURl,
                   'business_name'=>$value['name'],
                   'short_description'=>'',
                   'business_type'=>'',
                   'unique_id'=>'',
                   'user_slug'=>'',
                   'latitude'=>$value['location']['lat'],
                   'longitude'=>$value['location']['lng'],
                   'user_interests'=>'',
                   'full_address'=>$address,
                   'liked_users'=>'',
                   'avg_rating'=>''
               ];
           }
       }

       $allSPotObj = $all_spots;
       $emptyArr = array();
       $objToArray = $this->object_to_array($allSPotObj,$emptyArr);

       $finalSpot = array_merge($fourspot,$objToArray);

       return $finalSpot;
    }

    public function object_to_array($obj, &$arr)
    {
        if (!is_object($obj) && !is_array($obj))
        {
         $arr = $obj;
         return $arr;
        }

        foreach ($obj as $key => $value)
        {
         if (!empty($value))
         {
          $arr[$key] = array();
          $this->object_to_array($value, $arr[$key]);
         }
         else {$arr[$key] = $value;}
        }

        return $arr;
    }

    public function subscription($user,$request)
    {
        if(!empty($user))
        {
            if($request['business_type'] == 'premium')
            {
                $mollie = new \Mollie\Api\MollieApiClient();
                $mollie->setApiKey("test_s4w9grSfW8BvBTpGjCkvwdAmAxABvk");
                
                $customer = $mollie->customers->create(array(
                    "name" => $request['business_name'],
                    "email" => $request['email']
                ));

                $mandate = $mollie->customers->get($customer->id)->createMandate([
                    "method" => \Mollie\Api\Types\MandateMethod::DIRECTDEBIT,
                    "consumerName" => "Chirag Patel",
                    "consumerAccount" => "NL55INGB0000000000",
                    "consumerBic" => "INGBNL2A",
                    "signatureDate" => "2018-05-07",
                    "mandateReference" => "YOUR-COMPANY-MD13804",
                ]);

                $subscription = $customer->createSubscription([
                    "amount" => [
                        "currency" => "EUR",
                        "value" => "8.95",
                    ],
                    "interval" => "1 month",
                    "description" => "Daily Payment",
                    "webhookUrl" => "https://ibigo.shadowis.nl/server-api/api/webhook/redirect",
                ]);

                $this->data = [
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'customer_id'=> $customer->id,
                    'mandate_id'=>$mandate->id,
                    'subscription_status'=>$subscription->status,
                    'subscription_date'=>Carbon::parse($subscription->createdAt)
                ];

                $subscriptionAdd = $this->subscription->store($this->data);

                return $subscriptionAdd;
            }
        }
    }

    public function mail($request)
    {
        $to = 'mk@logixbuilt.com';
		$subject = "Redirected Webhook";
		$txt =  "Transation ID : ".$request;

		$headers = "MIME-Version: 1.0" . "\r\n"; 
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: demo.logixbuiltinfo@gmail.com" . "\r\n" ."CC: kl@logixbuilt.com";
    	$details = [
            'headers' => $headers,
            'title' => $subject,
            'body' => $txt
        ];
       
        $mail = Mail::to($to)->send(new PaymentMail($details));

        return $mail;
    }

    public function getPayment($request)
    {
        $mail = $this->mail($request['id']);
        
        if($mail)
        {
            $response['message'] = 'Something happening here...';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else
        {
            $response['message'] = 'Something went wrong...';
            $response['status'] = false;
            $response['status_code'] = 404;

        }
        return response()->json($response);
    }
    
    public function mailTestFor($request)
    {
        header('Content-Type: application/json');
        $request = file_get_contents('php://input');
        $req_dump = print_r( $request, true );

        $mail = $this->mail($req_dump);
        
        if($mail)
        {
            $response['message'] = 'Something happening here...';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else
        {
            $response['message'] = 'Something went wrong...';
            $response['status'] = false;
            $response['status_code'] = 404;

        }
        return response()->json($response);
    }

    public function getAllCms()
    {
        $user = Auth::user();
        if($user)
        {
            $cms = $this->cms->index();
            if($cms)
            {
                $response['cms'] = $cms;
                $response['status'] = true;
                $response['status_code'] = 201;
            }
            else
            {
                $response['message'] = 'No Cms!';
                $response['status'] = false;
                $response['status_code'] = 401;

            }
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 401;
        }
        return response()->json($response);
    }

    public function viewSingleCms($id)
    {
        $user = Auth::user();
        if($user)
        {
            $cms = $this->cms->relationCms(
                ['cmsDetail.cmsDetailImage'],
                'id',$id
            );
            if($cms)
            {
                $response['cms'] = $cms;
                $response['status'] = true;
                $response['status_code'] = 201;
            }
            else
            {
                $response['message'] = 'No Cms!';
                $response['status'] = false;
                $response['status_code'] = 400;
    
            }
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 401;
        }
        return response()->json($response);
    }
}
