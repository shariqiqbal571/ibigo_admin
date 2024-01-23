<?php 

namespace App\Services\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interest\InterestInterface;
use App\Repositories\Expertise\ExpertiseInterface;
use App\Repositories\Spot\SpotInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\SpotDetail\SpotDetailInterface;
use App\Repositories\Group\GroupInterface;
use App\Repositories\Event\EventInterface;
use App\Repositories\Agreegate\AgreegateInterface;
use Carbon\Carbon;
use App\Repositories\User\UserInterface;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Pnlinh\GoogleDistance\Facades\GoogleDistance;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class SearchService
{
    private $user;
    private $interest;
    private $expertise;
    private $spot;
    private $spotDetail;
    private $group;
    private $event;
    private $agreegate;
    private $notification;
    private $validator;
    private $response;
    private $request;


    public function __construct(
        Validator $validator,
        UserInterface $user,
        InterestInterface $interest,
        ExpertiseInterface $expertise,
        SpotInterface $spot,
        AgreegateInterface $agreegate,
        SpotDetailInterface $spotDetail,
        GroupInterface $group,
        EventInterface $event,
        NotificationInterface $notification,
        Response $response,
        Request $request
    )
    {
        $this->response = $response;
        $this->interest = $interest;
        $this->expertise = $expertise;
        $this->spot = $spot;
        $this->spotDetail = $spotDetail;
        $this->agreegate = $agreegate;    
        $this->group = $group;
        $this->event = $event;
        $this->user = $user;
        $this->notification = $notification;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function get($request)
    {
        $search = $request['search_text'];
        $response = []; //
        $count = [];
        $users = $this->user->findFriends
        (
            [
                'id',
                'user_profile',
                'user_interests',
                'user_slug',
                'unique_id',
                DB::raw("CONCAT(first_name,' ',last_name) AS user_name")
            ],
            'first_name',
            $search,
            'last_name',
        );
        $response['people_list'] = $users;
        $count['people_list'] = count($users);

        $interests = $this->interest->findInterest(
            'title',
            $search
        );
        $response['interests'] = $interests;
        $count['interests'] = count($interests);

        $spots = $this->spot->findSpot(
            [
                'userSpot'
            ],
            [
                'id',
                'user_id',
                'business_name',
                'business_type',
                DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                'latitude',
                'longitude',
                'short_description',
                'spot_profile'
            ],
            'business_name',
            'street_no',
            'postal_code',
            'city',
            $search
        );
        $response['spot_list'] =[];
        foreach ($spots as $key => $value) {
            $rating = $this->spotDetail->ratings(
                'DB::raw',
                'rating',
                'rating_sum',
                'id',
                'count_rating',
                'spot_id',
                $value['id']
            );
            $value['rating'] = $rating;
            $response['spot_list'][] = $value;
        }
        $foursquare = $this->agreegate->foursquareSearch($request,$response['spot_list']);
        $count['spot_count'] = count($foursquare);

        $group = $this->group->searchGroup
        (
            [
                'id','group_unique_id','group_name','group_slug','group_profile'
            ],
            'group_name',
            $search
        );
        $response['group_list'] =$group;
        $count['group_count'] = count($group);
        // exit();

        $event = $this->event->searchEvent(
            [
                'user',
                'group'
            ],
            'event_title',
            $search,
            'start_date_time',
            now()
        );

        
        $response['event_list'] =$event;
        $count['event_count'] = count($event);
        $response['counts'] = $count;
        $response['status'] = true;
        $response['code'] = 201;
        return response()->json($response);
    }

    public function notifications() 
    {
        $user = Auth::user();
        if($user)
        {
            $notification = $this->notification->getNotification(
                [
                    'fromUser',
                    'post',
                    'spot',
                    'event',
                    'group'
                ],'to_user_id',$user->id
            );
            $response['notification'] = [];
            $noti = [];
            foreach($notification as $key =>$value)
            {
                $noti[$key]['noti_id'] = $value['id'];
                $noti[$key]['noti_type'] = $value['notification_type'];
                $noti[$key]['noti_read'] = $value['notification_read'];
                $time = $value['notification_time'];
                $noti[$key]['notification_date_time'] = Carbon::parse($time)->format('Y-m-d h:i:s A');
                $noti[$key]['user'] = $value['from_user'];
                $noti[$key]['post'] = $value['post'];
                $noti[$key]['group'] = $value['group'];
                $noti[$key]['event'] = $value['event'];
                $noti[$key]['spot'] = $value['spot'];

            }
            // echo "<pre>";
            // print_r($noti);
            // exit();
            $response['notification'] = $noti;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function changeStatus($id) 
    {
        $user = Auth::user();
        if($user)
        {
            $data['notification_read'] = 1;
            $this->notification->edit('id',$data,$id);
            $response['message'] = 'You read this notification!';
            $response['status'] = true;
            $response['code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function spotSuggestion($request)
    {
        $user = Auth::user();
        if($user)
        {
            $spot = $this->spot->spotSuggestions(
                ['userSpot'],
                [
                    'id',
                    'user_id',
                    'business_name',
                    'short_description',
                    'business_type',
                    'latitude',
                    'longitude',
                    DB::raw("CONCAT(street_no ,', ', postal_code ,', ', city) AS full_address"),
                    DB::raw(' ( 6367 * acos( cos( radians('.$request['latitude'].') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$request['longitude'].') ) + sin( radians('.$request['latitude'].') ) * sin( radians( latitude ) ) ) ) AS distance'),
                ],
                'business_type',
                'desc'
            );
            $spot = $spot->sortBy('distance')->filter(function ($item) {
                return $item->new_distance < 100;
            })->values()->all();
            foreach ($spot as $key =>$value) {
                // if (($value->latitude!=null && $value->longitude!=null)||$value->new_distance!=null) {
                //     $distance = GoogleDistance::calculate($request['latitude'].','.$request['longitude'], $value->latitude.','.$value->longitude);
                //     $value->distance = $distance/1000;
                // }else{
                //     $distance = GoogleDistance::calculate($request['latitude'].','.$request['longitude'], $value->full_address);
                //     $value->distance = $distance/1000;
                // }
                $spot[$key]['distance'] = round($value['distance'] / 1000,1).'km';
            }
            $spot = collect($spot);
            $spot = $spot->sortBy('distance')->filter(function ($item) {
                return $item->distance <= 5 && $item->distance !=null && $item->distance > 0;
            })->values()->all();
            $response['all_spots'] = $spot;
            $response['latitude'] = $request['latitude'];
            $response['longitude'] = $request['longitude'];
            $response['status'] = true;
            $response['code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function getAllExpertise()
    {
        $user = Auth::user();
        if($user)
        {
            $expertise = $this->expertise->get(
                [
                    'id','title','icon'
                ],
                'status',
                1
            );
            $response['expertise'] = $expertise;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function findSpots($text)
    {

        $spots = $this->spot->findSpot(
            [
                'userSpot'
            ],
            [
                'id',
                'user_id',
                'business_name',
                'business_type',
                DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                'latitude',
                'longitude',
                'short_description',
                'spot_profile'
            ],
            'business_name',
            'street_no',
            'postal_code',
            'city',
            $text
        );
        $response =[];
        foreach ($spots as $key => $value) {
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
            $value['rating'] = $rating;
            $value['avg_rating'] = $avg_rating;
            $response[] = $value;
        }
        return $response;
    }

    public function findSpotsWho($text)
    {

        $spots = $this->spot->findSpotWho(
            [
                'userSpot'
            ],
            [
                'id',
                'user_id',
                'business_name',
                'business_type',
                DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                'latitude',
                'longitude',
                'short_description',
                'spot_profile'
            ],
            'short_description',
            $text
        );
        $response =[];
        foreach ($spots as $key => $value) {
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
            $value['rating'] = $rating;
            $value['avg_rating'] = $avg_rating;
            $response[] = $value;
        }
        return $response;
    }

    public function findEvents($text)
    {

        $event = $this->event->searchEvent(
            [
                'user',
                'group'
            ],
            'event_title',
            $text,
            'start_date_time',
            now()
        );

        
        // $response['events'] =$event;
        // $response['event_count'] = count($event);

        return $event;
    }

    public function searchWithTime($from,$to)
    {
        $spots = $this->spot->searchWithTime(
            [
                'userSpot'
            ],
            [
                'id',
                'user_id',
                'business_name',
                'business_type',
                DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                'latitude',
                'longitude',
                'short_description',
                'spot_profile'
            ],
            'created_at',
            $from,
            $to
        );

        $response =[];
        foreach ($spots as $key => $value) {
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
            $value['rating'] = $rating;
            $value['avg_rating'] = $avg_rating;
            $response[] = $value;
        }
        return $response;

    }

    public function searchWithMonth($month)
    {
        $spots = $this->spot->searchWithMonth(
            [
                'userSpot'
            ],
            [
                'id',
                'user_id',
                'business_name',
                'business_type',
                DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                'latitude',
                'longitude',
                'short_description',
                'spot_profile'
            ],
            'created_at',
            $month
        );

        $response =[];
        foreach ($spots as $key => $value) {
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
            $value['rating'] = $rating;
            $value['avg_rating'] = $avg_rating;
            $response[] = $value;
        }
        return $response;

    }

    public function searchWithWeekend()
    {
        $spots = $this->spot->searchWithWeekend(
            [
                'userSpot'
            ],
            [
                'id',
                'user_id',
                'business_name',
                'business_type',
                DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
                'latitude',
                'longitude',
                'short_description',
                'spot_profile',
                'created_at',
            ]
        );

        $response =[];
        foreach ($spots as $key => $value) {
            $value['created_at'] = Carbon::parse($value['created_at'])->format('l');
            if($value['created_at'] == 'Saturday' || $value['created_at'] == 'Sunday')
            {

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
                $value['rating'] = $rating;
                $value['avg_rating'] = $avg_rating;
                $response[] = $value;
            }
        }
        return $response;

    }

    public function searchWithFilters($search)
    {
        $user = Auth::user();
        if($user)
        {
            $response['events'] = [];
            $response['spots'] = [];
            if(isset($search['search_what']))
            {
                foreach($search['search_what'] as $search_what)
                {
                    if($search_what == 'event')
                    {
                        $response['events'][] = $this->findEvents('');
                    }
                    
                    else if($search_what == 'spot')
                    {
                        $response['spots'][] = $this->findSpots('');
                    }

                    else{
                        $response['events'][] = $this->findEvents('');
                        $response['spots'][] = $this->findSpots('');
                    }
                }
            }
            if(isset($search['search_who']))
            {
                foreach($search['search_who'] as $search_who)
                {
                    $response['spots'][] = $this->findSpots($search_who);
                }
            }
            if(isset($search['search_category']))
            {
                foreach($search['search_category'] as $search_category)
                {
                    $response['spots'][] = $this->findSpotsWho($search_category);
                }
            }
            if(isset($search['search_special']))
            {
                foreach($search['search_special'] as $search_special)
                {
                    $response['spots'][] = $this->findSpotsWho($search_special);
                }
            }
            if($search['search_city'] != null)
            {
                $response['spots'] = $this->findSpots($search['search_city']);
            }
            if($search['from'] && $search['to'])
            {
                $spots = $this->searchWithTime($search['from'],$search['to']);
                $response['spots'] = $spots;
            }
            else if($search['search_week'] == 'week')
            {
                $spots = $this->searchWithTime(Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek());
                $response['spots'] = $spots;
            }
            else if($search['search_month'] == 'month')
            {
                $spots = $this->searchWithMonth(date('m'));
                $response['spots'] = $spots;
            }
            else if($search['search_weekend'] == 'weekend')
            {
                $spots = $this->searchWithWeekend();
                $response['spots'] = $spots;
            }
            if(empty($search) || $search == [] || $search == '' || $search == null)
            {
                $response['events'] = $this->findEvents('');
                $response['spots'] = $this->findSpots('');
            }
        }
        return response()->json($response);
    }

    public function deleteNoti($id)
    {
        $this->notification->destroy($id);
        $response['message'] = 'Notification has been delete!';
        $response['status'] = true;
        $response['code'] = 201;
        return response()->json($response);
    }

    public function count()
    {
        $user = Auth::user();
        $noti = $this->notification->twoWhere('to_user_id',$user->id,'notification_read',0);
        if($user)
        {
            $response['count_noti'] = (count($noti) > 0) ? count($noti) : null;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 400;
        }
        return response()->json($response);
    }

    public function update()
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'notification_read' => 1
            ];
            $noti = $this->notification->updateNotification(
                'to_user_id',
                $user->id,
                'notification_read',
                0,
                $this->data
            );
            $response['message'] = 'You have seen all the notifications.';
            $response['status'] = true;
            $response['code'] = 201;
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 400;
        }
        return response()->json($response); 
    }

}