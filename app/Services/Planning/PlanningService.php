<?php 

namespace App\Services\Planning;

use App\Repositories\Planning\PlanningInterface;
use App\Repositories\Post\PostInterface;
use App\Repositories\PostStatus\PostStatusInterface;
use App\Repositories\PlanningInvitation\PlanningInvitationInterface;
use App\Repositories\Notification\NotificationInterface;
use Illuminate\Http\Request;
use App\Models\Planning;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class PlanningService
{
    private $planning;
    private $notification;
    private $post;
    private $postStatus;
    private $planningInvitation;
    private $validator;
    private $response;
    private $request;
    private $data = [];


    public function __construct(
        Validator $validator,
        PlanningInterface $planning,
        PostInterface $post,
        NotificationInterface $notification,
        PostStatusInterface $postStatus,
        PlanningInvitationInterface $planningInvitation,
        Response $response,
        Request $request
    )
    {
        $this->planning = $planning;
        $this->notification = $notification;
        $this->post = $post;
        $this->postStatus = $postStatus;
        $this->planningInvitation = $planningInvitation;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function get()
    {
        $user = Auth::user();
        if($user)
        {
            $planning = $this->planning->getPlans(
                [
                    'user',
                    'inviteUser.user',
                    'spot.userSpot',
                    'event.user',
                    'event.group'
                ],
                'user_id',
                $user->id
            );
            $response['spot_events'] = $planning;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function add($request)
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'user_id' => $user->id,
                'spot_id'=> isset($request['spot_id']) ? $request['spot_id'] : null,
                'event_id' => isset($request['event_id']) ? $request['event_id'] :null,
                'planning_title'=> isset($request['planning_title']) ? $request['planning_title'] : null,
                'planning_description'=> isset($request['planning_description']) ? $request['planning_description'] : null,
                'start_date_time' => isset($request['start_date_time']) ? $request['start_date_time'] : now(),
                'end_date_time' => isset($request['end_date_time']) ? $request['end_date_time'] : now(),
                'is_liked'=> 0
            ];

            $planning = $this->planning->store($this->data);
            $planning_id = $planning->id;

            if($request['invite_user_id'])
            {
                foreach(explode(',',$request['invite_user_id']) as $key => $invitationUserId)
                {
                    $this->data = [
                        'planning_id' => $planning_id,
                        'invite_user_id' => $invitationUserId,
                        'invitation_status'=>0
                    ];
                    $this->planningInvitation->store($this->data);
                }
            }
            
            if($planning)
            {
                $response['planning_id'] = $planning_id;
                $response['message'] = $request['spot_id'] == null ? 'Event is added to planning.' : 'Spot is added to planning.';
                $response['status'] = true;
                $response['code'] = 201;
            }
            else{
                $response['message'] = 'Something went wrong!';
                $response['status'] = false;
                $response['code'] = 400;
            }
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function eventCalender()
    {
        $user = Auth::user();
        if($user)
        {
            $planning = $this->planning->getPlans(
                [
                    'spot.userSpot',
                    'event'
                ],'user_id',$user->id
            );
            foreach ($planning as $key => $value) {
                $planning[$key]['allDay'] = true;
                $planning[$key]['start'] = Carbon::parse($value['start_date_time'])->format('Y-m-d h:i:s A');
                $planning[$key]['end'] = Carbon::parse($value['end_date_time'])->format('Y-m-d h:i:s A');
                if($value['event_id']!= NULL)
                {
                    $planning[$key]['listing_type'] = 'event';
                }
                else if($value['spot_id']!= NULL)
                {
                    $planning[$key]['listing_type'] = 'spot';
                }
            }
            // echo "<pre>";
            // print_r($planning);
            // exit();
            $response['calender'] = $planning;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function share($id)
    {
        $user = Auth::user();
        if($user)
        {
            $planning = $this->planning->show($id);
            // echo "<pre>";
            // print_r($planning);
            // exit();
            if($planning)
            {
                $this->data = [
                    'user_id' => $user->id,
                    'spot_id'=> isset($planning->spot_id) ? $planning->spot_id : null,
                    'event_id' => isset($planning->event_id) ? $planning->event_id :null,
                    'title'=>isset($planning->planning_title) ? $planning->planning_title : null,
                    'description'=>isset($planning->planning_description) ? $planning->planning_description : null,
                    'planning_id'=>$id
                ]; 
                $post = $this->post->store($this->data);
                
                $this->data = [
                    'post_id' => $post->id,
                    'status'=>0
                ];
                $this->postStatus->store($this->data);  

                $response['message'] = 'Planning is shared successfully!';
                $response['status'] = true;
                $response['code'] = 201;
            }
            else{
                $response['message'] = 'This planning is end!';
                $response['status'] = false;
                $response['code'] = 400;
            }
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function send($request)
    {
        $user = Auth::user();
        if($user)
        {
            $invite = $this->planningInvitation->twoWhere(
                'invite_user_id',
                $request['invite_user_id'],
                'planning_id',
                $request['planning_id']  
            );
            $this->data = [
                'planning_id'=> $request['planning_id'],
                'invite_user_id'=> $request['invite_user_id'],
                'invitation_status'=> 0,
            ];
            $this->noti = [
                'from_user_id'=>$user->id,
                'to_user_id'=>$request['invite_user_id'],
                'invited_planning_id' =>$request['planning_id'],
                'notification_type'=>'invite-in-planning',
                'notification_time'=> now(),
                'notification_read'=>0,
                'is_read'=> 0
            ];
            if($invite)
            {
                $this->planningInvitation->edit('id',$this->data,$invite[0]['id']);
            }
            else{
                $this->planningInvitation->store($this->data);
            }
            $this->notification->deleteOldNoti(
                'from_user_id',
                $user->id,
                'to_user_id',
                $request['invite_user_id'],
                'invited_planning_id',
                $request['planning_id'],
                'notification_type',
                'invite-in-planning'
            );
            $this->notification->store($this->noti);
            $response['message'] = 'You invite this user in this planning!';
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function accept($id)
    {
        $user = Auth::user();
        if($user)
        {
            $invite = $this->planningInvitation->twoWhere(
                'invite_user_id',
                $user->id,
                'planning_id',
                $id 
            );

            $old_noti = $this->notification->requestNoti(
                'to_user_id',
                $user->id,
                'invited_planning_id',
                $id,
                'notification_type',
                'invite-in-planning',
            );
            if($old_noti)
            {
                $this->noti = [
                    'from_user_id'=>$user->id,
                    'to_user_id'=>$old_noti[0]['from_user_id'],
                    'invited_planning_id' =>$id,
                    'notification_type'=>'accept-planning-invitation',
                    'notification_time'=> now(),
                    'notification_read'=>0,
                    'is_read'=> 0
                ];
                $this->notification->store($this->noti);
                $update_noti = [
                    'notification_type'=>'accepted-invitation-of-planning',
                    'notification_read'=>1,
                    'is_read'=> 1
                ];
                $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
            }


            if($invite)
            {
                if($invite[0]['invitation_status'] == 0)
                {
                    $this->data = [
                        'invitation_status' => 1
                    ];
                    $this->planningInvitation->edit('id',$this->data,$invite[0]['id']);
                    $response['message'] = 'You accept the invitation!';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
                else if($invite[0]['invitation_status'] == 1){
                    $response['message'] = 'You already accept the invitation!';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
                else{
                    $response['message'] = 'You already reject the invitation!';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
            }
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function reject($id)
    {
        $user = Auth::user();
        if($user)
        {
            $invite = $this->planningInvitation->twoWhere(
                'invite_user_id',
                $user->id,
                'planning_id',
                $id 
            );

            $old_noti = $this->notification->requestNoti(
                'to_user_id',
                $user->id,
                'invited_planning_id',
                $id,
                'notification_type',
                'invite-in-planning',
            );
            if($old_noti)
            {
                $this->noti = [
                    'from_user_id'=>$user->id,
                    'to_user_id'=>$old_noti[0]['from_user_id'],
                    'invited_planning_id' =>$id,
                    'notification_type'=>'reject-planning-invitation',
                    'notification_time'=> now(),
                    'notification_read'=>0,
                    'is_read'=> 0
                ];
                $this->notification->store($this->noti);
                $update_noti = [
                    'notification_type'=>'rejected-invitation-of-planning',
                    'notification_read'=>1,
                    'is_read'=> 1
                ];
                $this->notification->edit('id',$update_noti,$old_noti[0]['id']);
            }
            if($invite)
            {
                if($invite[0]['invitation_status'] == 0)
                {
                    $this->data = [
                        'invitation_status' => 2
                    ];
                    $this->planningInvitation->edit('id',$this->data,$invite[0]['id']);
                    $response['message'] = 'You reject the invitation!';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
                else if($invite[0]['invitation_status'] == 1){
                    $response['message'] = 'You already accept the invitation!';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
                else{
                    $response['message'] = 'You already reject the invitation!';
                    $response['status'] = true;
                    $response['code'] = 201;
                }
            }
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function pending($id)
    {
        $user = Auth::user();
        if($user)
        {
            $pending = $this->planningInvitation->twoWhereRelation(
                'invitation_status',
                0,
                'planning_id',
                $id,
                [
                    'user'
                ]
            );
            $response['pending'] = $pending;
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }
}