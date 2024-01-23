<?php 

namespace App\Services\Event;

use App\Repositories\Event\EventInterface;
use App\Repositories\EventInvite\EventInviteInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class EventService
{
    private $event;
    private $eventInvite;
    private $notification;
    private $user;
    private $validator;
    private $response;
    private $request;
    private $data = [];
    private $noti = [];

    public function __construct(
        Validator $validator,
        EventInterface $event,
        NotificationInterface $notification,
        EventInviteInterface $eventInvite,
        UserInterface $user,
        Response $response,
        Request $request
    )
    {
        $this->event = $event;
        $this->eventInvite = $eventInvite;
        $this->user = $user;
        $this->response = $response;
        $this->validator = $validator;
        $this->notification = $notification;
        $this->request = $request;
    }

    public function validate($data)
    {
        return $this->validator->make($data,[
            'event_title'=> 'required',
            'start_date_time' =>'required',
            'end_date_time' => 'required',
            'event_location'=>'required'
        ]);
    }

    public function get($id)
    {
        $event = $this->event
        ->relation(['user']);
        if($event){
            $response['event'] = $event;
            $response['status'] = true;
            return response()->json($response,201);
        }
        else
        {
            $response['message'] = 'No events found!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function create($data)
    {
        $validate = $this->validate($data);

        if($validate->fails())
        {
            $response['message'] = $validate->errors();
            $response['status'] = false;
            return response()->json($response,401);
        }
        else
        {
            $this->data = [
                'event_title'=> $data['event_title'],
                'event_slug'=>Str::slug($data['event_title']),
                'event_unique_id'=>Str::uuid(),
                'user_id'=>$data['user_id'],
                'start_date_time'=>$data['start_date_time'],
                'end_date_time'=>$data['end_date_time'],
                'event_description'=>$data['event_description'],
                'event_location'=>$data['event_location']
            ];

            $event = $this->event->store($this->data);
            $response['message'] = 'Event created successfully!';
            $response['status'] = true;
            return response()->json($response,200);
        }
    }

    public function view($id)
    {
        $event = $this->event
        ->event(['user'],'id',$id);
        // echo "<pre>";
        // print_r($event);
        // exit();
        if($event){
            $response['event'] = $event;
            $response['status'] = true;
            return response()->json($response,201);
        }
        else
        {
            $response['message'] = 'No events found!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function edit($request)
    {
        $userEvent = $this->event->twoWhere('user_id',$request['user_id'],'id',$request['id']);
        if($userEvent)
        {
            $validate = $this->validate($request);

            if($validate->fails())
            {
                $response['message'] = $validate->errors();
                $response['status'] = false;
                $response['code'] = 400;
            }
            else
            {
                $this->data = [
                    'event_title'=> $request['event_title'],
                    'event_slug'=>Str::slug($request['event_title']),
                    'start_date_time'=>$request['start_date_time'],
                    'end_date_time'=>$request['end_date_time'],
                    'event_location'=>$request['event_location']
                ];
                
                if($request['event_description'])
                {
                    $this->data['event_description']=$request['event_description'];
                }

                $event = $this->event->edit('id',$this->data,$request['id']);
                $response['message'] = 'Event updated successfully!';
                $response['status'] = true;
                $response['code'] = 201;
            }
        }
        else
        {
            $response['message'] = 'You are not created this event!';
            $response['status'] = false;
            $response['code'] = 404;

        }
        return response()->json($response);
    }

    public function updateCover($request)
    {
        $userEvent = $this->event->twoWhere('user_id',$request['user_id'],'id',$request['id']);
        if($userEvent)
        {
            $this->data = [
                'event_cover'=>$request['event_cover']
            ];

            $event = $this->event->edit('id',$this->data,$request['id']);
            $response['message'] = 'Event cover updated successfully!';
            $response['status'] = true;
            return response()->json($response,200);
        }
        else{
            $response['message'] = 'You are not allow to change cover';
            $response['status'] = false;
            return response()->json($response,401);
        }
    }

    public function delete($request)
    {
        $userEvent = $this->event->twoWhere('user_id',$request['user_id'],'id',$request['id']);
        if($userEvent)
        {
            $this->event->destroy($request['id']);
            $response['message'] = 'Event delete successfully!';
            $response['status'] = true;
            $response['code'] = 201;
        } 
        else
        {
            $response['message'] = 'You are not created this event!';
            $response['status'] = false;
            $response['code'] = 404;

        }
        return response()->json($response);
    }

    public function eventInvite($request)
    {
        $id = Auth::id();
        $event = $this->event->where('id',$request['event_id']);
        if($event)
        {
            
            if($request['user_id'])
            {
                foreach (explode(',',$request['user_id']) as $key => $userId) {
                    $this->data = [
                        'event_id' => $request['event_id'],
                        'user_id' => (isset($userId) ? $userId : null),
                    ];
                    $this->noti = [
                        'from_user_id'=>$id,
                        'to_user_id' => (isset($userId) ? $userId : null),
                        'invited_event_id'=>$request['event_id'],
                        'notification_type'=>'invite-in-event',
                        'notification_time'=> now(),
                        'notification_read'=>0,
                        'is_read'=> 0
                    ];

                    $noti = $this->notification->requestNoti(
                        'from_user_id',
                        $id,
                        'to_user_id',
                        $userId,
                        'notification_type',
                        'invite-in-event'
                    );

                    $this->eventInvite->store($this->data);
                    if($noti)
                    {
                        $this->notification->destroy($noti[0]['id']);
                    }
                    $this->notification->store($this->noti);
                    // echo "<pre>";
                    // print_r($this->data);
                }
            }
            if($request['group_id'])
            {
                foreach (explode(',',$request['group_id']) as $key => $groupId) {
                    $this->data = [
                        'event_id' => $request['event_id'],
                        'group_id' => (isset($groupId) ? $groupId : null),
                    ];

                    $this->noti = [
                        'group_id' => (isset($groupId) ? $groupId : null),
                        'invited_event_id'=>$request['event_id'],
                        'notification_type'=>'invite-in-event',
                        'notification_time'=> now(),
                        'notification_read'=>0,
                        'is_read'=> 0
                    ];

                    $noti = $this->notification->requestNoti(
                        'from_user_id',
                        $id,
                        'group_id',
                        $groupId,
                        'notification_type',
                        'invite-in-event'
                    );

                    $this->eventInvite->store($this->data);
                    if($noti)
                    {
                        $this->notification->destroy($noti[0]['id']);
                    }
                    $this->notification->store($this->noti);
                    // echo "<pre>";
                    // print_r($this->data);
                }
            }
        // exit();
            $response['message'] = 'You invited in this event!';
            $response['status'] = true;
            $response['code'] = 201;
        }
        else {
            $response['message'] = 'No event with this name was found!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function eventConnected($id)
    {
        $user = Auth::id();
        $eventInvite = $this->eventInvite->twoWhere('event_id',$id,'user_id',$user);
        // echo "<pre>";
        // print_r($eventInvite);
        // exit();
        if($eventInvite)
        {
            if($eventInvite[0]['connected'] == null || $eventInvite[0]['connected'] == 0)
            {
                $this->data['connected'] = 1;
                $response['message'] = 'You connected this event!';
            }
            else
            {
                $this->data['connected'] = 0;
                $response['message'] = 'You disconnected this event!';
            }
            $data = $this->eventInvite->edit('id',$this->data,$eventInvite[0]['id']);
        }
        else
        {
            $this->data = [
                'event_id' => $id,
                'user_id' => $user,
                'connected' =>1
            ];
            $response['message'] = 'You connected this event!';
            $data = $this->eventInvite->store($this->data);
        }
        $response['status'] = true;
        return response()->json($response,201);
    }

}