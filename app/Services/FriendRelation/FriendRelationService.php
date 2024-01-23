<?php 

namespace App\Services\FriendRelation;

use App\Repositories\User\UserInterface;
use App\Repositories\FriendRelation\FriendRelationInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\SpotDetail\SpotDetailInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\DB;


class FriendRelationService
{
    private $friendRelation;
    private $spotDetail;
    private $user;
    private $notification;
    private $validator;
    private $response;
    private $request;
    private $data = [];
    private $noti = [];


    public function __construct(
        Validator $validator,
        FriendRelationInterface $friendRelation,
        SpotDetailInterface $spotDetail,
        UserInterface $user,
        NotificationInterface $notification,
        Response $response,
        Request $request
    )
    {
        $this->friendRelation = $friendRelation;
        $this->user = $user;
        $this->notification = $notification;
        $this->spotDetail = $spotDetail;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function view($id)
    {
        $user_id = Auth::id();
        if($user_id)
        {
            $spotDetail = $this->spotDetail->where('spot_id',$id);
            $userIds = [];
            foreach ($spotDetail as $key => $value) {
                array_push($userIds,$value['user_id']);
            }
            
            $friendList = $this->user->allFriends(
                'id',
                $userIds,
                [
                    'id',
                    'user_profile',
                    'user_slug',
                    'unique_id',
                    DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
                ],
            );
            return response()->json([
                'connected_friends_list'=> $friendList,
                'status_code' => 200,
                'status' => true,
            ]);
        }
        return response()->json([
            'status_code' => 402,
            'status' => false,
        ]);
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

    public function request($request)
    {
        $user = $this->friendRelation
        ->friendRelation('from_user_id',$request['from_user_id'],'to_user_id',$request['to_user_id']);

        $noti = $this->notification->requestNoti(
            'from_user_id',
            $request['from_user_id'],
            'to_user_id',
            $request['to_user_id'],
            'notification_type',
            'friend-request'
        );
        
        $this->data = [
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'relation_status'=>$request['relation_status'],
        ];

        $this->noti = [
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'notification_type'=>'friend-request',
            'notification_time'=> now(),
            'notification_read'=>0,
            'is_read'=> 0
        ];
        // echo "<pre>";
        // print_r($user);
        // exit();

        
        if(!$user)
        {
            $this->friendRelation->store($this->data);
            if($noti)
            {
                $this->notification->destroy($noti[0]['id']);
            }
            $this->notification->store($this->noti);
            return response()->json([
                'message'=>'Request has been sent!',
                'status'=> true,
                'code'=>201
            ]);
        }
        else if($user[0]['relation_status'] == 1)
        {   
            return response()->json([
                'message'=>'You are already friends!',
                'status'=>false
            ],400);
        }
        else if( $user[0]['relation_status'] == 4)
        {
            return response()->json([
                'message'=>'You blocked this user!',
                'status'=>false
            ],400);
        }
        else
        {
            $this->friendRelation->edit('id',$this->data,$user[0]['id']);
            if($noti)
            {
                $this->notification->destroy($noti[0]['id']);
            }
            $this->notification->store($this->noti);
            
            return response()->json([
                'message'=>'Request has been sent!',
                'status'=> true,
                'code'=>201
            ]);
        }
        
    }

    public function accepted($request)
    {
        $user = $this->friendRelation
        ->twoWhere('from_user_id',$request['to_user_id'],'to_user_id',$request['from_user_id']);
        // echo "<pre>";
        // print_r($user);
        // exit();
        $noti = $this->notification->requestNoti(
            'from_user_id',
            $request['from_user_id'],
            'to_user_id',
            $request['to_user_id'],
            'notification_type',
            'accept-request'
        );

        $old_noti = $this->notification->requestNoti(
            'from_user_id',
            $request['to_user_id'],
            'to_user_id',
            $request['from_user_id'],
            'notification_type',
            'friend-request'
        );
        
        $this->data = [
            'relation_status'=>$request['relation_status']
        ];
        
        $this->noti = [
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'notification_type'=>'accept-request',
            'notification_time'=> now(),
            'notification_read'=>0,
            'is_read'=> 0
        ];

        $update_noti = [
            'notification_type' => 'accepted-request',
            'notification_read'=>1,
            'is_read'=> 1
        ];
        
        if($user)
        {
            if($user[0]['relation_status'] == 0)
            {
                if($noti)
                {
                    $this->notification->destroy($noti[0]['id']);
                }
                $this->notification->store($this->noti);
                $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
                $this->friendRelation->edit('id',$this->data,$user[0]['id']); 
                return response()->json([
                    'message'=>'Request accepted successfully!',
                    'status'=> true,
                    'code'=>201
                ]);
            }
            else if($user[0]['relation_status'] == 1){
                return response()->json([
                    'message'=>'Your are already friends!',
                    'status'=> false,
                    'code'=>400
                ]);
            }
            else {
                return response()->json([
                    'message'=>'You blocked this user!',
                    'status'=> false,
                    'code'=>401
                ]);
            }
        }
        else{
            return response()->json([
                'message'=>'This user is not send you a request!',
                'status'=> false,
                'code'=>404
            ]);
        }
    }

    public function rejected($request)
    {
        $user = $this->friendRelation->twoWhere('from_user_id',$request['to_user_id'],'to_user_id',$request['from_user_id']);
        
        $this->data = [
            'relation_status'=>$request['relation_status']
        ];

        $noti = $this->notification->requestNoti(
            'from_user_id',
            $request['from_user_id'],
            'to_user_id',
            $request['to_user_id'],
            'notification_type',
            'reject-request'
        );

        $old_noti = $this->notification->requestNoti(
            'from_user_id',
            $request['to_user_id'],
            'to_user_id',
            $request['from_user_id'],
            'notification_type',
            'friend-request'
        );

        $this->noti = [
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'notification_type'=>'reject-request',
            'notification_time'=> now(),
            'notification_read'=>0,
            'is_read'=> 0
        ];

        $update_noti = [
            'notification_type' => 'rejected-request',
            'notification_read'=>1,
            'is_read'=> 1
        ];

        if($user)
        {
            if($user[0]['relation_status'] == 0)
            {
                if($noti)
                {
                    $this->notification->destroy($noti[0]['id']);
                }
                $this->notification->store($this->noti);
                $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
                $this->friendRelation->edit('id',$this->data,$user[0]['id']); 
                return response()->json([
                    'message'=>'Request reject successfully!',
                    'status'=> true,
                    'code'=>201
                ]);
            }
            else if($user[0]['relation_status'] == 1){
                return response()->json([
                    'message'=>'Your are already friends!',
                    'status'=> false,
                    'code'=>400
                ]);
            }
            else {
                return response()->json([
                    'message'=>'You blocked this user!',
                    'status'=> false,
                    'code'=>401
                ]);
            }
        }
        else{
            return response()->json([
                'message'=>'This user is not send you a request!',
                'status'=> false,
                'code'=>404
            ]);
        }
    }

    public function cancel($request)
    {
        $user = $this->friendRelation->twoWhere('from_user_id',$request['from_user_id'],'to_user_id',$request['to_user_id']);
        
        $this->data = [
            'relation_status'=>$request['relation_status']
        ];

        if($user)
        {
            if($user[0]['relation_status'] == 0)
            {
                $this->friendRelation->edit('id',$this->data,$user[0]['id']); 
                return response()->json([
                    'message'=>'Request reject successfully!',
                    'status'=> true,
                    'code'=>201
                ]);
            }
            else if($user[0]['relation_status'] == 1){
                return response()->json([
                    'message'=>'Your are already friends!',
                    'status'=> false,
                    'code'=>400
                ]);
            }
            else {
                return response()->json([
                    'message'=>'You blocked this user!',
                    'status'=> false,
                    'code'=>401
                ]);
            }
        }
        else{
            return response()->json([
                'message'=>'This user is not send you a request!',
                'status'=> false,
                'code'=>404
            ]);
        }
    }

    public function unfriendUser($request)
    {
        $user = $this->friendRelation->friendRelation('from_user_id',$request['from_user_id'],'to_user_id',$request['to_user_id']);
        
        $this->data = [
            'relation_status'=>$request['relation_status']
        ];

        if($user)
        {
            if($user[0]['relation_status'] == 1)
            {
                $this->friendRelation->edit('id',$this->data,$user[0]['id']); 
                return response()->json([
                    'message'=>'You unfriend the user',
                    'status'=> true,
                    'code'=>201
                ]);
            }
            else{
                return response()->json([
                    'message'=>'You are not friends!',
                    'status'=> false,
                    'code'=>404
                ]);
            }
        }
    }

    public function blockUser($request)
    {
        $this->data = [
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'relation_status'=>$request['relation_status']
        ];
        $user = $this->friendRelation->friendRelation('from_user_id',$request['from_user_id'],'to_user_id',$request['to_user_id']);
        if($user)
        {
            $this->friendRelation->edit('id',$this->data,$user[0]['id']); 
            return response()->json([
                'message'=>'You block this user!',
                'status'=> true,
                'code'=>201
            ]);
        }
        else{
            $this->friendRelation->store($this->data);
            return response()->json([
                'message'=>'You block this user!',
                'status'=> true,
                'code'=>201
            ]);
        }
    }

    public function unblockUser($request)
    {
        $this->data = [
            'relation_status'=>$request['relation_status']
        ];
        $user = $this->friendRelation->twoWhere('from_user_id',$request['from_user_id'],'to_user_id',$request['to_user_id']);
        
        if($user)
        {
            if($user[0]['relation_status'] == 4)
            {
                $this->friendRelation->edit('id',$this->data,$user[0]['id']); 
                return response()->json([
                    'message'=>'You unblock this user!',
                    'status'=> true,
                    'code'=>201
                ]);
            }
            else if($user[0]['relation_status'] != 4){
                return response()->json([
                    'message'=>'No one block each other!',
                    'status'=> false,
                    'code'=>401
                ]);
            }
        }
        else{
            return response()->json([
                'message'=>'No one block each other!',
                'status'=> false,
                'code'=>401
            ]);
        }
    }

    public function getFriends($id)
    {
        $user = $this->friendRelation->getFriends('to_user_id','relation_status','from_user_id',$id,1);
        if($user)
        {
            $user_id_array = [];
            foreach ($user as $key) {
                array_push($user_id_array,$key['from_user_id']);
                array_push($user_id_array,$key['to_user_id']);
            }

            $user_id_array = array_unique($user_id_array);
            if (($key = array_search($id, $user_id_array)) !== false) {
                unset($user_id_array[$key]);
            }

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
            // echo "<pre>";
            // print_r($friends);
            // exit();
            return $friends;
        }
    }

    public function friend($id)
    {
        $user = $this->friendRelation->
        getFriends('to_user_id','relation_status','from_user_id',$id,0);
        
        if($user)
        {
            $user_id_array = [];
            foreach ($user as $key) {
                array_push($user_id_array,$key['from_user_id']);
                array_push($user_id_array,$key['to_user_id']);
            }

            $user_id_array = array_unique($user_id_array);
            if (($key = array_search($id, $user_id_array)) !== false) {
                unset($user_id_array[$key]);
            }

            if($user_id_array != $id)
            {
                $userRequest = $this->user->
                allFriends(
                    'id',
                    $user_id_array,
                    [
                        'id',
                        'user_profile',
                        'user_slug',
                        'unique_id',
                        DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
                    ],
                );
            
                $response['user'] = $userRequest;
                $response['status'] = true;
                return response()->json($response,201);
            }
        }
        else
        {
            $response['message'] = 'You have no friend request';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function getFriendSuggestion()
    {
        $users_id_array = [];
        $check_this_ids = [];
        $friends_of_friends_users_id = [];
        $same_interest_users_ids = [];
        $all_suggestions = [];
        $all_friend_suggestions = [];
        
        $id = Auth::id();
        $user = $this->user->show($id);

        array_push($check_this_ids, $id.'');
        $friendList = $this->getFriends($id);

        if($friendList)
        {
            foreach ($friendList as $key => $value) {
                array_push($users_id_array,$value['id']);
            }
        }
        $check_this_ids = array_merge($check_this_ids,$users_id_array);
        
        $friends_of_friends = $this->friendRelation->friendOfFriends(
            'to_user_id',
            'from_user_id',
            'relation_status',
            $id,
            $users_id_array,
        );

        if (count($friends_of_friends) > 0) {
            foreach ($friends_of_friends as $value) {
                array_push($friends_of_friends_users_id, $value['to_user_id']);
                array_push($friends_of_friends_users_id, $value['from_user_id']);
            }
        }


        if($user->user_interests!='' || $user->user_interests!=null){
            $user_i = explode(',', $user->user_interests);
            foreach ($user_i as $value) {
                $same_interest_user = $this->user->userInterest(
                    $value,
                    'user_type',
                    'normal'
                );
                if (count($same_interest_user) > 0) {
                    foreach ($same_interest_user as $i) {
                        array_push($same_interest_users_ids, $i['id'].'');
                    }
                }
            }
        }
        $all_suggestions = array_merge($same_interest_users_ids,$friends_of_friends_users_id);
        $all_suggestions = array_unique($all_suggestions);

        if(count($all_suggestions) > 0)
        {
            foreach ($all_suggestions as $key => $friends) {
                $friendsOrNot = $this->friendRelation->friendsOrNot(
                    'to_user_id',
                    'from_user_id',
                    'relation_status',
                    $id,
                    $friends
                );
                // echo "<pre>";
                // print_r($friendsOrNot);
                // exit();
                if (count($friendsOrNot)>0) {
                    foreach ($friendsOrNot as $value) {
                        array_push($check_this_ids, $value['from_user_id']);
                        array_push($check_this_ids, $value['to_user_id']);
                    }
                }
            }
        }
        $check_this_ids = array_unique($check_this_ids);
        if (count($check_this_ids)>0) {
            foreach ($check_this_ids as $value) {
                if (($key = array_search($value, $all_suggestions)) !== false) {
                    unset($all_suggestions[$key]);
                }
            }
        }

        $friend_suggestions = $this->user->suggestions(
            [
                'id',
                'user_profile',
                'user_slug',
                'unique_id',
                DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
            ],
            'id',
            $all_suggestions
        );
        // echo "<pre>";
        // print_r($friend_suggestions);
        // exit();
        $response['all_suggestions'] = $all_suggestions;
        $response['friend_suggestions'] = $friend_suggestions;
        $response['check_this_ids'] = $check_this_ids;
        $response['status'] = true;
        $response['code'] = 200;
        return response()->json($response);
    }

    public function queryForUser($request,$status) {
        $authUser = Auth::user();
        $user = $this->user->findForFriends(
            [
                'id',
                'first_name',
                'last_name',
                'username',
                'user_profile',
            ],
            'first_name',$request['search'],'last_name','id',$authUser->id,'user_type','normal',$status
        );

        return $user;
    }

    public function searchForFriends($request)
    {
        $friends = $this->queryForUser($request,1);
        $pending = $this->queryForUser($request,0);
        $all = [];
        foreach ($friends as $value) 
        {
            array_push($all,$value['id']);
        }
        foreach ($pending as $value) 
        {
            array_push($all,$value['id']);
        }
        $all_users = $this->user->allFriendsForSearch('id',$all,[
            'id',
            'first_name',
            'last_name',
            'username',
            'user_profile',
        ],'first_name',$request['search'],'last_name');
        // echo "<pre>";
        // print_r($all_users);
        // exit();
        $response['friends'] = $friends;
        $response['pending'] = $pending;
        $response['all_users'] = $all_users;
        return response()->json($response);

    }

}