<?php 

namespace App\Services\GroupUser;

use App\Repositories\GroupUser\GroupUserInterface;
use App\Repositories\Group\GroupInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class GroupUserService
{
    private $groupUser;
    private $group;
    private $notification;
    private $user;
    private $validator;
    private $response;
    private $data = [];
    private $noti = [];


    public function __construct(
        Validator $validator,
        GroupUserInterface $groupUser,
        GroupInterface $group,
        NotificationInterface $notification,
        UserInterface $user,
        Response $response
    )
    {
        $this->groupUser = $groupUser;
        $this->group = $group;
        $this->notification = $notification;
        $this->user = $user;
        $this->response = $response;
        $this->validator = $validator;
    }

    public function request($request)
    {
        return $this->groupUser->
        sendData('group_id',$request['group_id'],'user_id',$request['user_id']);
    }

    public function getInvitedFriends($groupId)
    {
        $user = Auth::user();
        if ($user)
        {
            $id = Auth::id();
            $groupUser = $this->groupUser->invitedFriends('invited_by',$id,'group_id',$groupId,'group_status',0);

            if($groupUser)
            {
                $user_id_array = [];
                foreach ($groupUser as $key) {
                    array_push($user_id_array,$key['user_id']);
                }

                $user_id_array = array_unique($user_id_array);
                if (($key = array_search($id, $user_id_array)) !== false) {
                    unset($user_id_array[$key]);
                }

                // echo "<pre>";
                // print_r($user_id_array);
                // exit();
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
                $response['message'] = 'No Invited Friends';
                $response['status'] = false;
                return response()->json($response,400);
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
    }
    
    public function send($request)
    {
        $user = Auth::user();
        if ($user)
        {
            foreach (explode(',',$request['user_id']) as $key => $value) {
                $this->data = [
                    'user_id'=>$value,
                    'group_id'=>$request['group_id'],
                    'invited_by' =>$request['invited_by'],
                    'group_status'=>0,
                    'is_admin'=>'Member',
                ];

                $this->noti = [
                    'from_user_id'=>isset($request['invited_by'])?$request['invited_by']: null,
                    'to_user_id'=>$value,
                    'invited_group_id' =>$request['group_id'],
                    'notification_type'=>'invite-in-group',
                    'notification_time'=> now(),
                    'notification_read'=>0,
                    'is_read'=> 0
                ];

                $userGroup = $this->request($this->data);
                // echo "<pre>";
                // print_r($userGroup);
                // exit();
                if(!$userGroup){
                    $data = $this->groupUser->store($this->data);
                    $this->notification->store($this->noti);
                    $response['message'] = 'Invited your friend successfully!';
                    $response['status'] = true;
                }
                else
                {
                    if($userGroup[0]['group_status'] == 2 || $userGroup[0]['group_status'] == 4 || $userGroup[0]['group_status'] == 5|| $userGroup[0]['group_status'] == 0)
                    {
                        $this->notification->deleteOldNoti(
                            'from_user_id',
                            $request['invited_by'],
                            'to_user_id',
                            $value,
                            'invited_group_id',
                            $request['group_id'],
                            'notification_type',
                            'invite-in-group'
                        );
                        $this->notification->store($this->noti);
                        $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                        $response['message'] = 'Invited your friend successfully!';
                        $response['status'] = true;
                    }
                    else if($userGroup[0]['group_status'] == 1)
                    {
                        $response['message'] = 'This user send request to this group!';
                        $response['status'] = false;
                        $response['code'] = 401;
                    }
                    else if($userGroup[0]['group_status'] == 3)
                    {
                        $response['message'] = 'This user is member of this group!';
                        $response['status'] = false;
                        $response['code'] = 404;
                    }
                }
            }

        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response,200);

    }

    public function join($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();
            $this->data = [
                'user_id' => $request['user_id'],
                'group_id' => $request['group_id'],
                'group_status'=>1,
                'is_admin'=>'Member',
            ];
            
            $this->noti = [
                'from_user_id'=>$request['user_id'],
                'to_user_id'=>isset($userGroup[0]['invited_by'])?$userGroup[0]['invited_by']:null,
                'invited_group_id' =>$request['group_id'],
                'notification_type'=>'join-request-to-group',
                'notification_time'=> now(),
                'notification_read'=>0,
                'is_read'=> 0
            ];

            if(!$userGroup)
            {
                $this->notification->store($this->noti);
                $data = $this->groupUser->store($this->data);
                $response['message'] = 'You send a request to join this group!';
                $response['status'] = true;
                $response['code'] = 200;
            }
            else
            { 
                if($userGroup[0]['group_status'] == 2 || $userGroup[0]['group_status'] == 4 || $userGroup[0]['group_status'] == 5 || $userGroup[0]['group_status'] == 1)
                {
                    $this->notification->deleteOldNoti(
                        'from_user_id',
                        $request['user_id'],
                        'to_user_id',
                        $userGroup[0]['invited_by'],
                        'invited_group_id',
                        $request['group_id'],
                        'notification_type',
                        'join-request-to-group'
                    );
                    $this->notification->store($this->noti);
                    $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                    $response['message'] = 'You send a request to join this group!';
                    $response['status'] = true;
                    $response['code'] = 200;
                }
                else if($userGroup[0]['group_status'] == 0)
                {
                    $response['message'] = 'You already send a request to join this group!';
                    $response['status'] = false;
                    $response['code'] = 401;
                }
                else if($userGroup[0]['group_status'] == 3)
                {
                    $response['message'] = 'You are member of this group!';
                    $response['status'] = false;
                    $response['code'] = 404;
                }
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }

    public function accept($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();
            $this->data = [
                'invited_by'=> $request['invited_by'],
                'group_status'=>3
            ];

            $this->noti = [
                'from_user_id'=>$request['user_id'],
                'to_user_id'=>$request['invited_by'],
                'invited_group_id' =>$request['group_id'],
                'notification_type'=>'accept-request-of-group',
                'notification_time'=> now(),
                'notification_read'=>0,
                'is_read'=> 0
            ];

            $old_noti = $this->notification->getNotificationGroup(
                'from_user_id',
                ($request['invited_by'] ? $request['invited_by'] : null),
                'to_user_id',
                $request['user_id'],
                'invited_group_id',
                $request['group_id'],
                'notification_type',
                'join-request-to-group',
            );

            $update_noti = [
                'notification_type' => 'accepted-request-in-the-group',
                'notification_read'=>1,
                'is_read'=> 1
            ];

            if($userGroup)
            {
                if($userGroup[0]['group_status'] == 1)
                {
                    $this->notification->deleteOldNoti(
                        'from_user_id',
                        $request['user_id'],
                        'to_user_id',
                        $request['invited_by'],
                        'invited_group_id',
                        $request['group_id'],
                        'notification_type',
                        'accept-request-of-group'
                    );
                    $this->notification->store($this->noti);
                    $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
                    $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                    $response['message'] = 'You are now member of this group!';
                    $response['status'] = true;
                    $response['code'] = 200;
                }
            }
            else
            {
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }

    public function cancel($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();
            $this->data = [
                'group_status'=>2
            ];
            if($userGroup)
            {
                if($userGroup[0]['group_status'] == 1)
                {
                    $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                    $response['message'] = 'You are cancel the request!';
                    $response['status'] = true;
                    $response['code'] = 200;
                }
            }
            else
            {
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }

    public function confirm($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();
            $this->data = [
                'group_status'=>3
            ];

            $this->noti = [
                'from_user_id'=>$request['user_id'],
                'to_user_id'=>$userGroup[0]['user_id'],
                'invited_group_id' =>$request['group_id'],
                'notification_type'=>'confirm-group-invitation',
                'notification_time'=> now(),
                'notification_read'=>0,
                'is_read'=> 0
            ];


            $update_noti = [
                'notification_type'=>'accepted-invitation',
                'notification_read'=>1,
                'is_read'=> 1
            ];

            if($userGroup[0]['group_status'] == 0)
            {
                $this->notification->deleteOldNoti(
                    'from_user_id',
                    $request['user_id'],
                    'to_user_id',
                    $userGroup[0]['user_id'],
                    'invited_group_id',
                    $request['group_id'],
                    'notification_type',
                    'confirm-group-invitation'
                );
                $old_noti = $this->notification->requestNoti(
                    'to_user_id',
                    $request['user_id'],
                    'invited_group_id',
                    $request['group_id'],
                    'notification_type',
                    'invite-in-group',
                );

                $this->notification->store($this->noti);
                $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
                $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                $response['message'] = 'You are now member of this group!';
                $response['status'] = true;
                $response['code'] = 200;
            }
            else
            {
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }

    public function reject($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();
            $this->data = [
                'group_status'=>4
            ];

            $this->noti = [
                'from_user_id'=>$request['user_id'],
                'to_user_id'=>$userGroup[0]['user_id'],
                'invited_group_id' =>$request['group_id'],
                'notification_type'=>'reject-group-invitation',
                'notification_time'=> now(),
                'notification_read'=>0,
                'is_read'=> 0
            ];

            $update_noti = [
                'notification_type'=>'rejected-invitation',
                'notification_read'=>1,
                'is_read'=> 1
            ];
            if($userGroup[0]['group_status'] == 0)
            {
                $this->notification->deleteOldNoti(
                    'from_user_id',
                    $request['user_id'],
                    'to_user_id',
                    $userGroup[0]['user_id'],
                    'invited_group_id',
                    $request['group_id'],
                    'notification_type',
                    'reject-group-invitation'
                );
                $old_noti = $this->notification->requestNoti(
                    'to_user_id',
                    $request['user_id'],
                    'invited_group_id',
                    $request['group_id'],
                    'notification_type',
                    'invite-in-group',
                );
                $this->notification->store($this->noti);
                $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
                $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                $response['message'] = 'You reject the request!';
                $response['status'] = true;
                $response['code'] = 200;
            }
            else
            {
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }

    public function leave($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();
            $this->data = [
                'group_status'=>5
            ];

            if($userGroup[0]['group_status'] == 3)
            {
                $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                $response['message'] = 'You leave this group!';
                $response['status'] = true;
                $response['code'] = 200;
            }
            else
            {
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }
    public function adminOrNot($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $userGroup = $this->request($request);

            // echo "<pre>";
            // print_r($userGroup);
            // exit();

            if($userGroup[0]['is_admin'] == "Member")
            {
                $this->data = [
                    'is_admin'=>"Admin"
                ];
                $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                $response['message'] = 'This user is now admin of this group!';
                $response['status'] = true;
                $response['code'] = 201;
            }
            else
            {
                $this->data = [
                    'is_admin'=>"Member"
                ];
                $data = $this->groupUser->updateGroup('user_id',$userGroup[0]['user_id'],'group_id',$userGroup[0]['group_id'],$this->data);
                $response['message'] = 'This user is no more admin of this group';
                $response['status'] = true;
                $response['code'] = 201;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);

    }

    public function removeUser($request)
    {
        $user = Auth::user();
        if ($user)
        {
            $admins = $this->groupUser->
            invitedFriends('group_id',$request['group_id'],'user_id',$request['auth_id'],'is_admin','Admin');

            // echo "<pre>";
            // print_r($admins);
            // exit();
            if($admins)
            {
                $userRemove = $this->groupUser->removeUser('group_id',$request['group_id'],'user_id',$request['user_id']);
                if($userRemove)
                {
                    $response['message'] = 'Remove user to the group';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
                else{
                    $response['message'] = 'User not found';
                    $response['status'] = false;
                    $response['code'] = 400;
                }
            }
            else{
                $response['message'] = 'You are not admin to remove the user!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }

    public function getPendingInvitation() 
    {
        $user = Auth::user();
        if($user)
        {
            $groupUser = $this->groupUser->pendingGroups(
                ['group'],
                'user_id',
                $user->id,
                'group_status',
                0,
                'updated_at',
                'DESC'
            );
            $groups = [];
            if($groupUser)
            {
                foreach($groupUser as $key => $value) 
                {
                    $groups[$key] = $value['group'];
                    $groups[$key]['pending_time'] = Carbon::parse($value['updated_at'])->diffForHumans();
                }
            }
            $response['groups'] = $groups;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticated Error';
            $response['status'] = false;
            $response['code'] = 402;
        }
        return response()->json($response);
    }
}