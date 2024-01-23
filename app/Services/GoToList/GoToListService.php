<?php 

namespace App\Services\GoToList;

use App\Repositories\GoToList\GoToListInterface;
use App\Services\SpotDetail\SpotDetailService;
use App\Repositories\SpotDetail\SpotDetailInterface;
use App\Repositories\Spot\SpotInterface;
use Illuminate\Http\Request;
use App\Models\GoToList;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Hash;
use Exception;
use Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class GoToListService
{
    private $goToList;
    private $spot;
    private $spotDetail;
    private $spotDetailInterface;
    private $validator;
    private $response;
    private $request;
    private $data = [];


    public function __construct(
        Validator $validator,
        GoToListInterface $goToList,
        SpotInterface $spot,
        SpotDetailService $spotDetail,
        SpotDetailInterface $spotDetailInterface,
        Response $response,
        Request $request
    )
    {
        $this->goToList = $goToList;
        $this->spot = $spot;
        $this->spotDetail = $spotDetail;
        $this->spotDetailInterface = $spotDetailInterface;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function reviews($goToList)
    {

        $user_id_array = [];
        $response['goto_list'] = [];
        foreach ($goToList as $key => $value) {
            foreach ($value['spot']['spot_user_review'] as $key => $value2) {
                array_push($user_id_array,$value2['user_id']);
            }
            
            $values = $this->spotDetail->rating($value,$user_id_array);

            $response['goto_list'][] = $values;
        }
        $response['status'] = true;
        $response['status_code'] = 201;
        return response()->json($response);
    }

    public function get()
    {
        $ip = request()->ip();
        $data = Location::get($ip); 
        if($data)
        {
            $lat = $data->latitude;
            $lang = $data->longitude;
        }
        else{
            $lat = 40.0992;
            $lang = -83.1141;
        }
        $user_id = Auth::id();
        if($user_id)
        {
            $goToList = $this->goToList->relationWithSpot
            (
                [
                    'spot',
                    'spot.userSpot',
                    'spot.spotUserReview',
                    'spot.spotUserReview.user',
                ],
                'spot.spotUserReview',
                'user_id',
                $user_id,
                'like',
                1,[
                'spot_id','user_id','created_at','updated_at']
            );
            if($goToList)
            {
                foreach($goToList as $key => $value)
                {
                    $goToList[$key]['created_time'] = Carbon::parse($value['created_at'])->format('h:i:s A');
                    $goToList[$key]['created_date'] = Carbon::parse($value['created_at'])->format('M d,Y');
                    $goToList[$key]['updated_time'] = Carbon::parse($value['updated_at'])->format('h:i:s A');
                    $goToList[$key]['updated_date'] = Carbon::parse($value['updated_at'])->format('M d,Y');
                    if($value['spot'])
                    {
                        $distance = ( 6367 * acos( cos( deg2rad($lat) ) * cos( deg2rad( $value['spot']['latitude'] ) ) * cos( deg2rad( $value['spot']['longitude'] ) - deg2rad($lang) ) + sin( deg2rad($lat) ) * sin( deg2rad( $value['spot']['latitude'] ) ) ) );
                        $goToList[$key]['spot']['distance'] = round($distance / 1000,1).'km';
                    }
                }
            }
            // return $goToList;
            // echo "<pre>";
            // print_r($goToList);
            // exit();
            return $this->reviews($goToList);
        }
    }

    public function add($request)
    {
        $user_id = Auth::id();
        if($user_id)
        {
            $goToList = $this->goToList->oldGoToList('user_id',$user_id,'spot_id',$request['spot_id']); 
            if($request['spot_id'])
            {
                foreach ($request['spot_id'] as $key => $spot_id) {
                    $this->data = [
                        'user_id'=>$user_id,
                        'spot_id' => $spot_id,
                        'is_liked'=> 0
                    ];
                    $create = $this->goToList->store($this->data);
                }
            }
            $response['message'] = "You create go to list successfully!";
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else {
            $response['message'] = "Authenticate Error!";
            $response['status'] = false;
            $response['status_code'] = 400;
        }
        return response()->json($response);
    }

    public function single($id)
    {
        $user_id = Auth::id();
        if($user_id)
        {
            $goToList = $this->goToList->relationWithSingleSpot
            (
                [
                    'spot.ownerImages',
                    'spot.ownerVideos',
                    'spot.userSpot',
                    'spot.spotUserReview',
                    'spot.spotUserReview.user'
                ],
                'spot.spotUserReview',
                'user_id',
                $user_id,
                'like',
                1,[
                'spot_id','id'],
                $id
            );
            // return $goToList;
            // echo "<pre>";
            // print_r($goToList);
            // exit();
            return $this->reviews($goToList);
        }
    }

    public function edit($request)
    {
        $user_id = Auth::id();
        if($user_id)
        {
            $goToList = $this->goToList->whereTwo('spot_id',$request['spot_id'],'user_id',$user_id);
            if(!$goToList)
            {
                $this->data = [
                    'spot_id' => $request['spot_id']
                ];
                // echo "<pre>";
                // print_r($request['spot_id']);
                // exit();
                $create = $this->goToList->edit('id',$this->data,$request['id']);
            }
            $response['message'] = "You updated go to list successfully!";
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else {
            $response['message'] = "Authenticate Error!";
            $response['status'] = false;
            $response['status_code'] = 400;
        }
        return response()->json($response);
    }

    public function like($id)
    {
        $user_id = Auth::id();
        if($user_id)
        {
            $likeGoto = $this->goToList->where('id',$id);
            // echo "<pre>";
            // print_r($goToList);
            // exit();
            if($likeGoto)
            {
                if($likeGoto[0]['is_liked'] == null || $likeGoto[0]['is_liked'] == 0)
                {
                    $this->data['is_liked'] = 1;
                    $response['message'] = 'You like this go to spot!';
                }
                else
                {
                    $this->data['is_liked'] = 0;
                    $response['message'] = 'You dislike this go to spot!';
                }
                $response['status'] = true;
                $response['status_code'] = 201;
                $data = $this->goToList->edit('id',$this->data,$likeGoto[0]['id']);
            }
            else
            {
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['status_code'] = 400;
            }
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function otherSpots()
    {
        $user_id = Auth::id();
        if($user_id)
        {
            $likeSpots = $this->spotDetailInterface->likeSpot
            (
                [
                    'user',
                    'spot.ownerImages',
                    'spot.ownerVideos',
                    'spot.userSpot'
                ],
                'connected',
                1,
                'like',
                'user_id',
                $user_id,
                [
                    'spot_id',
                    'user_id'
                ]
            );
            $spot_ids = [];
            foreach ($likeSpots as $key => $value) {
                array_push($spot_ids,$value['spot_id']);
            }

            $otherSpots = $this->spot->otherSpots
            (
                ['userSpot'],
                'id',
                $spot_ids,
                [
                    'business_name',
                    'spot_profile',
                    'short_description',
                    'user_id'
                ]
            );
            $response['other_spots'] = $otherSpots;
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function delete($id)
    {
        $user = Auth::user();
        if($user)
        {
            $this->goToList->destroy($id);
            $response['message'] = 'This goto is deleted successfully!';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }
}