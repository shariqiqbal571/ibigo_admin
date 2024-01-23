<?php 

namespace App\Services\Group;

use App\Repositories\Group\GroupInterface;
use App\Repositories\Post\PostInterface;
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

class GroupService
{
    private $noti =[];
    private $data =[];
    private $group;
    private $groupChat;
    private $notification;
    private $groupUser;
    private $chat;
    private $post;
    private $user;
    private $validator;
    private $friendRelationService;
    private $postService;
    private $response;
    private $request;

    public function __construct(
        Validator $validator,
        GroupInterface $group,
        PostInterface $post,
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
        $this->post = $post;
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

    public function groups()
    {
        $data = $this->group->groupIndex(
            ['id','user_id','group_name','group_slug','group_profile'],
            ['adminGroup','groupUsers.user']
        );
        if($data)
        {
            $response['group'] = $data;
            $response['status'] = true;
            return response()->json($response,200);
        }
        else
        {
            $response['message'] = 'No Groups';
            $response['status'] = false;
            return response()->json($response,401);
        }
    }

    public function create($request)
    {   
        $id= Auth::id();
        $validator = $this->validator->make($request,[
            'group_name'=>'required'
        ]);
        if($validator->fails())
        {
            $response['message'] = $validator->errors();
            $response['status'] = false;
            return response()->json($response,401);
        }
        else
        {
            $this->data['user_id'] = $id;
            $this->data['group_name'] = $request['group_name'];
            $this->data['group_unique_id'] = Str::uuid();
            $this->data['group_slug'] = Str::slug($request['group_name'].' '.Str::random('6'),'-');
            $this->data['group_description'] = isset($request['group_description'])?$request['group_description']:null;
            $this->data['group_profile'] = isset($request['group_profile'])?$request['group_profile']:null;
            $this->data['group_cover'] = isset($request['group_cover'])?$request['group_cover']:null;
            
            $data = $this->group->store($this->data);
            // if($data)
            // {
            //     $this->data = [
            //         'group_id' => $data->id,
            //         'user_id' => $id,
            //     ];
            //     $this->groupChat->store($this->data);
            // }
            if($request['user_id'])
            {
                foreach ($request['user_id'] as $user)
                {
                    $this->data = [
                        'group_id' => $data->id,
                        'user_id' => $user,
                        'invited_by' => $id,
                        'group_status' => 0,
                        'is_admin'=>'Member'
                    ];
                    $this->groupUser->store($this->data);

                    $this->noti = [
                        'from_user_id'=>$id,
                        'to_user_id'=>$user,
                        'invited_group_id' =>$data->id,
                        'notification_type'=>'invite-in-group',
                        'notification_time'=> now(),
                        'notification_read'=>0,
                        'is_read'=> 0
                    ];
                    $this->notification->store($this->noti);
                }
            }

            if($request['admin_id'])
            {
                foreach ($request['admin_id'] as $admin)
                {
                    $this->data = [
                        'group_id' => $data->id,
                        'user_id' => $admin,
                        'invited_by' => $id,
                        'group_status' => ($admin == $id)? 3:0,
                        'is_admin'=>'Admin'
                    ];
                    $this->groupUser->store($this->data);
                    
                    if($admin != $id)
                    {
                        $this->noti = [
                            'from_user_id'=>$id,
                            'to_user_id'=>$admin,
                            'invited_group_id' =>$data->id,
                            'notification_type'=>'invite-in-group-as-an-admin',
                            'notification_time'=> now(),
                            'notification_read'=>0,
                            'is_read'=> 0
                        ];
                        $this->notification->store($this->noti);
                    }
                }
            }

            $response['id'] = $data->id;
            $response['message'] = 'Group created successfully';
            $response['status'] = true;
            return response()->json($response,200);
        }
    }

    public function group($id) {
        $data = $this->group->showGroup(
            'id',
            $id,
            [
                'adminGroup',
                'groupUsers.user',
            ],
        );

        $post = $this->post->getAllGroupPosts('group_id','shared_group_id',$id,[
            'postImages:post_id,post_images',
            'postVideos:post_id,post_videos',
            'postAudios:post_id,post_audios',
            'userPost',
            'spotPost.userSpot',
            'spotPost.spotDetail.user',
            'spotPost.spotDetail.spotDetailPhotos',
            'spotPost.spotDetail.spotDetailVideos',
            'eventPost.user',
            'postLike:post_id,user_id',
            'postLike.user',
            'postComment',
            'postComment.user',
            'sharedPost.postImages:post_id,post_images',
            'sharedPost.postVideos:post_id,post_videos',
            'sharedPost.postAudios:post_id,post_audios',
            'sharedPost.userPost',
            'sharedPost.spotPost.userSpot',
            'sharedPost.spotPost.spotDetail.user',
            'sharedPost.spotPost.spotDetail.spotDetailPhotos',
            'sharedPost.spotPost.spotDetail.spotDetailVideos',
            'sharedPost.eventPost.user',
            'sharedPost.postLike:post_id,user_id',
            'sharedPost.postLike.user',
            'sharedPost.postComment',
            'sharedPost.postComment.user',
        ]);
        $user = Auth::user();
        if($user)
        {
            if($data)
            {
                $data[0]['post'] = [];
                if(count($post) > 0){
                    $data[0]['post'] = $post;
                }

                $response['data'] = $data;
                $shared_user = [];
                foreach ($data as $key => $value) {
                    $value['created_at'] = Carbon::parse($value['created_at'])->format('M,d Y h:i:s A');
                    $value['updated_at'] = Carbon::parse($value['updated_at'])->format('M,d Y h:i:s A');
                    // echo "<pre>";
                    // print_r($value['post'][$key]['shared_user_id']);
                    if($value['post'])
                    {   
                        foreach ($value['post'] as $key2 => $post) {
                            // $value['post'][$key2]['shared_user'] = [];
                            $value['post'][$key2]['tagged_user'] = [];
                            // $value['post'][$key2]['shared_group'] = [];
                            $value['post'][$key2]['count_like'] = null;
                            $value['post'][$key2]['count_comment'] = null;
                            $value['post'][$key2]['created_at'] = Carbon::parse($post['created_at'])->format('M,d Y h:i:s A');
                            $value['post'][$key2]['updated_at'] = Carbon::parse($post['updated_at'])->format('M,d Y h:i:s A');
                            // if($post['shared_user_id'])
                            // {
                            //     $sharedUserIds = explode(',',$post['shared_user_id']); 
                            //     $shared_friends = $this->postService->getFriends($sharedUserIds);
                            //     // echo "<pre>";
                            //     // print_r($shared_friends);
                                
                            //     $value['post'][$key2]['shared_user'] = $shared_friends;
                            // }
                
                            if($post['tagged_user_id'])
                            {
                                $taggedUserIds = explode(',',$post['tagged_user_id']); 
                                $tagged_friends = $this->postService->getFriends($taggedUserIds);
                                // echo "<pre>";
                                // print_r($tagged_friends);
                                
                                $value['post'][$key2]['tagged_user'] = $tagged_friends;
                            }
                                
                            // if($post['shared_group_id'])
                            // {
                            //     // echo "<pre>";
                            //     // print_r($post['shared_group_id']);
                            //     $sharedGroupIds = explode(',',$post['shared_group_id']); 
                            //     $shared_friends = $this->postService->getGroup($sharedGroupIds);
                            //     // echo "<pre>";
                            //     // print_r($shared_friends);
                                
                            //     $value['post'][$key2]['shared_group'] = $shared_friends;
                            // }
                            if($post['post_like'])
                            {
                                $value['post'][$key2]['count_like'] = count($post['post_like']);
                            }
                            if($post['post_comment'])
                            {
                                $value['post'][$key2]['count_comment'] = count($post['post_comment']);
                            }
                            $response['data'] = $value;
                        }
                    }
                    // exit();
                    // $response['data'] = $value;
                }
                    // exit();
                    $response['status'] = true;
                return response()->json($response,200);
            }
        }
        else
        {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            return response()->json($response,40);
        }
    }

    public function usersGroups()
    {
        $id = Auth::id();
        $group = $this->group->showAllGroups(
            ['adminGroup','groupUsers.user'],
            'user_id',
            $id,
            'group_status',
            3,
            'groupUsers'
        );
        if($group){
            $response['groups'] = $group;
            $response['status'] = true;
            return response()->json($response,200);
        }
        else
        {
            $response['message'] = 'No Group!';
            $response['status'] = false;
            return response()->json($response,401);
        }
    }

    public function edit($request)
    {
        $id = Auth::id();
        $user = $this->group->groupShow('user_id',$id,'id',$request['id']);

        if($user)
        {
            if($request['group_name'])
            {
                $this->data['group_name'] = $request['group_name'];
                $this->data['group_slug'] = Str::slug($request['group_name'],'-');
                $response['message'] = 'Group name changed successfully';
                $response['status'] = true;
            }
            if($request['group_description'])
            {
                $this->data['group_description'] = $request['group_description'];
                $response['message'] = 'Group description changed successfully';
                $response['status'] = true;
            }
            if($request['group_profile'])
            {
                $this->data['group_profile'] = $request['group_profile'];
                $response['message'] = 'Group profile changed successfully';
                $response['status'] = true;
            }
            if($request['group_cover'])
            {
                $this->data['group_cover'] = $request['group_cover'];
                $response['message'] = 'Group cover changed successfully';
                $response['status'] = true;
            }
            $data = $this->group->edit('id',$this->data,$request['id']);
            return response()->json($response,200);
            }
        else
        {
            $response['message'] = 'You are not to allow to change anything!';
            $response['status'] = false;
            return response()->json($response,401);
        }
            
    }

    public function delete($id)
    {   
        $user_id = Auth::id();
        $user = $this->group->groupShow('user_id',$user_id,'id',$id);
        if($user)
        {
            $this->group->destroy($id);
            $this->groupUser->delete('group_id',$id);
            $this->groupChat->delete('group_id',$id);
    
            $response['message'] = 'Group has been deleted successfully';
            $response['status'] = true;
            $response['code'] = 201;
        }
        else
        {
            $response['message'] = 'You are not admin!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function getGroupOrUser($id)
    {
        $user = Auth::user();
        if($user)
        {
            $messageUser = $this->user->where('id',$id);
            $anotherUser = $messageUser[0];
            if(count($messageUser) > 0)
            {
                $groupOrUser = $this->chat->groupOrUser(
                    [
                        'toUser',
                        'fromUser'
                    ],
                    'from_user_id',
                    'to_user_id',
                    $user->id,
                    $anotherUser['id']
                );
            }
            else 
            {
                $groupOrUser = $this->group->where('id',$id);
            }
            $response['messages'] = $groupOrUser;
            $response['another_user'] = $anotherUser;
            $response['status'] = true;
            $response['status_code'] = 201;
            // echo "<pre>";
            // print_r($messageUser);
            // exit();

        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['status_code'] = 404;
        }
        return response()->json($response);
    }

    public function getSearchGroup($request)
    {
        $search = $request['search'];

        $data = $this->group->searchGroups(
            ['id','user_id','group_name','group_slug','group_profile'],
            ['adminGroup','groupUsers.user'],
            'group_name',
            $search
        );
        if($data)
        {
            $response['data'] = $data;
            $response['status'] = true;
            return response()->json($response,200);
        }
        else
        {
            $response['message'] = 'No Groups Found!';
            $response['status'] = false;
            return response()->json($response,401);
        }
    }
}