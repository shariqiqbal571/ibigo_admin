<?php 

namespace App\Services\Chat;

use App\Repositories\Chat\ChatInterface;
use App\Repositories\User\UserInterface;
use App\Services\FriendRelation\FriendRelationService;
use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ChatService
{
    private $data =[];
    private $chat;
    private $user;
    private $friends;
    private $validator;
    private $response;
    private $request;


    public function __construct(
        Validator $validator,
        ChatInterface $chat,
        UserInterface $user,
        FriendRelationService $friends,
        Response $response,
        Request $request
    )
    {
        $this->chat = $chat;
        $this->user = $user;
        $this->friends = $friends;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function get($id)
    {
        $user = Auth::user();
        if($user)
        {
            $chats = $this->chat->messages(
                'from_user_id',
                'to_user_id',
                $id,
                $user->id,
                'message_date_time',
                'DESC',
            );
            if($chats)
            {
                foreach($chats as $key => $value)
                {
                    if($value['message_type'] == 'image')
                    {
                        $chats[$key]['message'] = 'storage/images/chat/'.$value['message'];
                    }
                }
            }
            // echo "<pre>";
            // print_r($chats);
            // exit();
            $response['message'] = $chats;
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

    public function create($request)
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'from_user_id'=>$user->id,
                'to_user_id'=>$request['to_user_id'],
                'message'=>$request['message'],
                'message_type'=>$request['message_type'],
                'message_date_time'=>$request['message_date_time'],
                'is_read'=>$request['is_read']
            ];
            $chat = $this->chat->store($this->data);
            $response['message'] = 'Message sent!';
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

    public function recent()
    {
        $user = Auth::user();
        if($user)
        {
            $recent = $this->chat->recentChat(
                ['toUser'],
                'from_user_id',
                $user->id,
                'message_date_time',
                'DESC',
                'to_user_id'
            );
            // echo "<pre>";
            // print_r($recent);
            // exit();
            $response['recent_chat'] = $recent;
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

    public function recentFriends()
    {
        $user = Auth::user();
        if($user)
        {
            $friends = $this->friends->getFriends($user->id);
            if($friends)
            {

                foreach ($friends as $key => $value) {
                    $recent = $this->chat->recentFriends(
                        'from_user_id',
                        $user->id,
                        'created_at',
                        'DESC',
                        'to_user_id',
                        $value['id']
                    );
    
                    $readOrNot = $this->chat->read(
                        'from_user_id',
                        $value['id'],
                        'to_user_id',
                        $user->id,
                        'is_read',
                        0
                    );
                    $friends[$key]['message'] = '';
                    if($recent)
                    {
                        foreach ($recent as $key2 => $value2) {
                            if($value2[0][0]['message_type'] == 'image')
                            {
                                $friends[$key]['message'] = 'image';
                                $friends[$key]['message_type'] = $value2[0][0]['message_type'];
                            }
                            else{
                                $friends[$key]['message'] = $value2[0][0]['message'];
                                $friends[$key]['message_type'] = $value2[0][0]['message_type'];
                            }
                            // echo "<pre>";
                            // print_r($value2);
                        }
                    }
                    $friends[$key]['count'] = count($readOrNot);
                }
            }
            $chats = [];
            if($friends)
            {
                foreach ($friends as $key2 => $value)
                {
                    if($value['count'] > 0)
                    {
                        $chats[] = $value;
                    }
                }
            }
            // exit();
            $response['friends'] = $chats;
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

    public function readMessage($request)
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'is_read' => $request['is_read']
            ];
            $this->chat->readMessages(
                'from_user_id',
                $request['from_user_id'],
                'to_user_id',
                $user->id,
                $this->data
            );
            $response['message'] = 'You read all the messages of this user';
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

    public function unreadMessage($request)
    {
        $user = Auth::user();
        if($user)
        {
            $this->data = [
                'is_read' => $request['is_read']
            ];
            $chat = $this->chat->unreadMessage(
                'from_user_id',
                $request['from_user_id'],
                'to_user_id',
                $user->id,
                'id',
                'DESC'
            );
            if($chat)
            {
                $this->chat->edit('id',$this->data,$chat[0]['id']);
                $response['message'] = 'You mark as unread the last message!';
                $response['status'] = true;
                $response['status_code'] = 201;
            }
            else{
                $response['message'] = 'No messages!';
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

    public function deleteChat($id) 
    {
        $user = Auth::user();
        if($user)
        {
            $chat = $this->chat->messages(
                'from_user_id',
                'to_user_id',
                $id,
                $user->id,
                'id',
                'ASC'
            );
            $user_ids = [];
            if(count($chat) > 0)
            {
                $ids = [];
                foreach($chat as $key =>$chats)
                {
                    if(isset($chats['user_chat_delete'])){
                        array_push($user_ids, $chats['user_chat_delete']);
                    }
                    array_push($user_ids, $user->id);
                    $ids = implode(',', $user_ids);
                    $this->data = [
                        'user_chat_delete'=>$ids
                    ];
                    $this->chat->edit('id',$this->data,$chats['id']);
                    // echo "<pre>";
                    // print_r($ids);
                    unset($user_ids);
                    $user_ids = [];
                }
                
            }
            $response['message'] = 'Chat delete successfully!';
            $response['status'] = true;
            $response['status_code'] = 201;
            // exit();
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }
}