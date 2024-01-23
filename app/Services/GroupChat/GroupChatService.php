<?php 

namespace App\Services\GroupChat;

use App\Repositories\Group\GroupInterface;
use App\Repositories\GroupChat\GroupChatInterface;
use App\Repositories\GroupUser\GroupUserInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\User\UserInterface;
use App\Services\FriendRelation\FriendRelationService;
use App\Services\Post\PostService;
use App\Repositories\Chat\ChatInterface;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Str;

class GroupChatService
{
    private $noti =[];
    private $data =[];
    private $group;
    private $groupChat;
    private $notification;
    private $groupUser;
    private $chat;
    private $user;
    private $validator;
    private $friendRelationService;
    private $postService;
    private $response;
    private $request;

    public function __construct(
        Validator $validator,
        GroupInterface $group,
        GroupChatInterface $groupChat,
        GroupUserInterface $groupUser,
        NotificationInterface $notification,
        UserInterface $user,
        ChatInterface $chat,
        FriendRelationService $friendRelationService,
        PostService $postService,
        Response $response,
        Request $request
    )
    {
        $this->group = $group;
        $this->groupChat = $groupChat;
        $this->groupUser = $groupUser;
        $this->notification = $notification;
        $this->user = $user;
        $this->friendRelationService = $friendRelationService;
        $this->postService = $postService;
        $this->chat = $chat;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function get(){
        $user = Auth::user();
        if($user)
        {
            $group = $this->groupUser->relationalGroup(
                ['group.groupChat.user'],
                'user_id',$user->id,'group_status',3
            );
            if($group)
            {
                $response['group'] = [];
                foreach($group as $key => $value)
                {
                    $response['group'][$key]['group_id'] = $value['group']['id'];
                    $response['group'][$key]['group_name'] = $value['group']['group_name'];
                    $response['group'][$key]['group_slug'] = $value['group']['group_slug'];
                    $response['group'][$key]['group_unique_id'] = $value['group']['group_unique_id'];
                    $response['group'][$key]['group_profile'] = $value['group']['group_profile'];
                    $response['group'][$key]['group_cover'] = $value['group']['group_cover'];
                    if($value['group']['group_chat'])
                    {
                        $response['group'][$key]['last_message']['user_id'] = $value['group']['group_chat'][0]['user']['id'];
                        $response['group'][$key]['last_message']['name'] = $value['group']['group_chat'][0]['user']['fullname'];
                        $response['group'][$key]['last_message']['profile'] = $value['group']['group_chat'][0]['user']['user_profile'];
                        $response['group'][$key]['last_message']['user_slug'] = $value['group']['group_chat'][0]['user']['user_slug'];
                        $response['group'][$key]['last_message']['message_id'] = $value['group']['group_chat'][0]['id'];
                        $response['group'][$key]['last_message']['message'] = $value['group']['group_chat'][0]['message'];
                        $response['group'][$key]['last_message']['message_date'] = Carbon::parse($value['group']['group_chat'][0]['message_date_time'])->format('Y-m-d');
                        $response['group'][$key]['last_message']['message_time'] = Carbon::parse($value['group']['group_chat'][0]['message_date_time'])->format('h:i:s A');
                    }
                    else{
                        $response['group'][$key]['last_message'] = [];
                    }
                }
                $response['status'] = true;
                $response['status_code'] = 201;
            }
            else{
                $response['message'] = 'No Group Found!';
                $response['status'] = false;
                $response['status_code'] = 400;
            }
        }
        else{
            $response['message'] = 'Unauthorized User!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function create($request)
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'group_id'=>$request['group_id'],
                'user_id'=>$user->id,
                'message'=>$request['message'],
                'message_date_time'=>now()
            ];
            $this->groupChat->store($this->data);
            $response['message'] = 'Message Sent';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Unauthorized User!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function find($groupId){
        $user = Auth::user();
        if($user)
        {
            $group = $this->group->showGroup(
                'id',$groupId,
                ['groupChat.user'],
            );
            // echo "<pre>";
            // print_r($group);
            // exit();
            if($group)
            {
                $response['group'] = [];
                $response['group']['group_id'] = $group[0]['id'];
                $response['group']['group_name'] = $group[0]['group_name'];
                $response['group']['group_slug'] = $group[0]['group_slug'];
                $response['group']['group_cover'] = $group[0]['group_cover'];
                $response['group']['group_unique_id'] = $group[0]['group_unique_id'];
                $response['group']['group_profile'] = $group[0]['group_profile'];
                $response['group']['user_message'] = [];
                foreach ($group[0]['group_chat'] as $key => $value) {
                    $response['group']['user_message'][$key]['user_id'] = $value['user']['id'];
                    $response['group']['user_message'][$key]['name'] = $value['user']['fullname'];
                    $response['group']['user_message'][$key]['profile'] = $value['user']['user_profile'];
                    $response['group']['user_message'][$key]['user_slug'] = $value['user']['user_slug'];
                    $response['group']['user_message'][$key]['message_id'] = $value['id'];
                    $response['group']['user_message'][$key]['message'] = $value['message'];
                    $response['group']['user_message'][$key]['message_date'] = Carbon::parse($value['message_date_time'])->format('Y-m-d');
                    $response['group']['user_message'][$key]['message_time'] = Carbon::parse($value['message_date_time'])->format('h:i:s A');
                }
                $response['status'] = true;
                $response['status_code'] = 201;
            }
            else{
                $response['message'] = 'No Group Found!';
                $response['status'] = false;
                $response['status_code'] = 400;
            }
        }
        else{
            $response['message'] = 'Unauthorized User!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function delete($messageId)
    {
        $user = Auth::user();
        if($user)
        {
            $this->groupChat->destroy($messageId);
            $response['message'] = 'Message has been deleted';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Unauthorized User!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function deleteAll($groupId)
    {
        $user = Auth::user();
        if($user)
        {
            $this->groupChat->delete('group_id',$groupId);
            $response['message'] = 'Chat has been deleted';
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else{
            $response['message'] = 'Unauthorized User!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }
}