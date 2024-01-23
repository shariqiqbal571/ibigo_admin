<?php 

namespace App\Services\Spot;

use App\Repositories\Spot\SpotInterface;
use App\Repositories\SpotDetail\SpotDetailInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Interest\InterestInterface;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\User;
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


class SpotService
{
    private $spot;
    private $spotDetail;
    private $user;
    private $interest;
    private $userService;
    private $validator;
    private $response;
    private $request;
    private $data = [];

    public function __construct(
        Validator $validator,
        SpotInterface $spot,
        SpotDetailInterface $spotDetail,
        UserInterface $user,
        InterestInterface $interest,
        UserService $userService,
        Response $response,
        Request $request
    )
    {
        $this->spot = $spot;
        $this->interest = $interest;
        $this->spotDetail = $spotDetail;
        $this->user = $user;
        $this->userService = $userService;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function get()
    {
        $ip = request()->ip();
        $data = Location::get($ip); 
        // echo "<pre>";
        // print_r($ip);
        // print_r($data);
        // exit();
        if($data)
        {
            $lat = $data->latitude;
            $lang = $data->longitude;
        }
        else{
            $lat = 40.0992;
            $lang = -83.1141;
        }
        $spot = $this->spot->getRelation(
            [
                'ownerImages','ownerVideos','userSpot','spotDetail','spotDetail.user'],
            [
                'id',
                'user_id',
                'street_no',
                'postal_code',
                'city',
                'business_name',
                'spot_profile',
                'latitude',
                'longitude',
                'short_description',
                DB::raw(' ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$lang.') ) + sin( radians('.$lat.') ) * sin( radians( latitude ) ) ) ) AS distance')
            ],'id',''
        );
        if($spot)
        {
            $response['spot'] = $spot;
            foreach ($spot as $key => $value) {
                $response['spot'][$key]['distance'] = round($value['distance'] / 1000,1).'km';
                $rating = $this->spotDetail->ratings(
                    'DB::raw',
                    'rating',
                    'rating_sum',
                    'id',
                    'count_rating',
                    'spot_id',
                    $value['id']
                );

                $avg_rating = null;
                if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                    $avg_rating = 0;
                }else{
                    $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                }
                $response['spot'][$key]['avg_rating'] = $avg_rating;
                // echo "<pre>";print_r($response);exit();
                if($value['spot_detail']){
                    foreach ($value['spot_detail'] as $key2 => $value2) {
                        if($value2['spot_id'])
                        {
                            $likeUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2['spot_id'],
                                'like',
                                '=',
                                1,
                                'user_id',
                            );
                            $connectUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2['spot_id'],
                                'connected',
                                '=',
                                1,
                                'user_id',
                            );
                            $reviewUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2['spot_id'],
                                'review',
                                '!=',
                                null,
                                'user_id',
                            );
                
                            // echo "<pre>";
                            // print_r(count($likeUser));
                            $response['spot'][$key]['spot_detail']['count_like'] = count($likeUser);
                            $response['spot'][$key]['spot_detail']['count_connected'] = count($connectUser);
                            $response['spot'][$key]['spot_detail']['count_review'] = count($reviewUser);
                        }
                    }
                }
            }
            // exit();
            $response['status'] = true;
        }
        else
        {
            $response['message'] = 'No spot';
            $response['status'] = false;
        }
        return response()->json($response,201);
    }

    public function view($id)
    {
        $spot = $this->spot->getRelation(
            [
                'ownerImages','ownerVideos','userSpot','spotDetail.spotDetailPhotos','spotDetail.spotDetailVideos','spotDetail.user'],
            [
                'id',
                'user_id',
                'street_no',
                'postal_code',
                'city',
                'business_name',
                'spot_profile',
                'spot_cover',
                'latitude',
                'longitude',
                'short_description',
            ],
            'id',$id
        );
        if($spot)
        {
            $response['spot'] = $spot;
            foreach ($spot as $key => $value) {
                $rating = $this->spotDetail->ratings(
                    'DB::raw',
                    'rating',
                    'rating_sum',
                    'id',
                    'count_rating',
                    'spot_id',
                    $value['id']
                );

                $avg_rating = null;
                if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                    $avg_rating = 0;
                }else{
                    $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                }
                $response['spot'][$key]['avg_rating'] = $avg_rating;
                
                if($value['user_spot']['user_interests'] != null) {
                    $user_interests = explode(',',$value['user_spot']['user_interests']);
                    $interest = $this->interest->authInterest('id',$user_interests,['id','title','icon']);
                    $response['spot'][$key]['user_spot']['user_interests'] = $interest;
                }

                if($value['spot_detail']){
                    foreach ($value['spot_detail'] as $key2 => $value2) {
                        if($value2['spot_id'])
                        {
                            $likeUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2['spot_id'],
                                'like',
                                '=',
                                1,
                                'user_id',
                            );
                            $connectUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2['spot_id'],
                                'connected',
                                '=',
                                1,
                                'user_id',
                            );
                            $reviewUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2['spot_id'],
                                'review',
                                '!=',
                                null,
                                'user_id',
                            );
                            // echo "<pre>";
                            // print_r(count($likeUser));
                            $response['spot'][$key]['spot_detail']['count_like'] = count($likeUser);
                            $response['spot'][$key]['spot_detail']['count_connected'] = count($connectUser);
                            $response['spot'][$key]['spot_detail']['count_review'] = count($reviewUser);
                        }
                    }
                }
            }
            // exit();
            $response['status'] = true;
        }
        else
        {
            $response['message'] = 'No spot';
            $response['status'] = false;
        }
        return response()->json($response,201);
    }

    public function searchSpot($request)
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
        $user = Auth::user();
        if($user)
        {
            $spots = $this->spot->findSpot(
                [
                    'userSpot','spotDetail.spotDetailPhotos','spotDetail.spotDetailVideos'
                ],
                [
                    'id',
                    'user_id',
                    'business_name',
                    'business_type',
                    'street_no',
                    'postal_code',
                    'city',
                    DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                    'latitude',
                    'longitude',
                    'short_description',
                    'rating',
                    'spot_profile',
                    DB::raw(' ( 6367 * acos( cos( radians('.$lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$lang.') ) + sin( radians('.$lat.') ) * sin( radians( latitude ) ) ) ) AS distance')
                ],
                'business_name',
                'street_no',
                'postal_code',
                'city',
                $request['search']
            );
            $response['spot_list'] =[];
            foreach ($spots as $key => $value) {
                $value['distance'] = round($value['distance'] / 1000,1).'km';
                $rating = $this->spotDetail->ratings(
                    'DB::raw',
                    'rating',
                    'rating_sum',
                    'id',
                    'count_rating',
                    'spot_id',
                    $value['id']
                );
                $avg_rating = null;
                if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                    $avg_rating = 0;
                }else{
                    $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                }
                $value['ratings'] = $rating;
                $value['rating'] = $avg_rating;
                $response['spot_list'][] = $value;
            }
            $response['spot_count'] = count($spots);
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'No Spot Found!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function getTopRated() 
    {
        $user = Auth::user();
        if($user)
        {
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
            $top_rated_spots = [];
            if($spots)
            {
                $top_rated_spots = $spots;
                foreach ($spots as $key => $value) {
                    $avg_rating = $this->userService->spotDeailsRating($value);
                    $top_rated_spots[$key]['avg_rating'] = $avg_rating;
                }
            }
            $response['top_rated_spots'] = $top_rated_spots;
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Authenticated Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

}
