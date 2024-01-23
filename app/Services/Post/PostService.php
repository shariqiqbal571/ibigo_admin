<?php 

namespace App\Services\Post;

use App\Repositories\Post\PostInterface;
use App\Repositories\PostLike\PostLikeInterface;
use App\Repositories\SpotDetail\SpotDetailInterface;
use App\Repositories\PostComment\PostCommentInterface;
use App\Repositories\PostImage\PostImageInterface;
use App\Repositories\PostVideo\PostVideoInterface;
use App\Repositories\PostAudio\PostAudioInterface;
use App\Repositories\PostStatus\PostStatusInterface;
use App\Repositories\FriendRelation\FriendRelationInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Group\GroupInterface;
use App\Repositories\GroupUser\GroupUserInterface;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class PostService
{
    private $post;
    private $postLike;
    private $spotDetail;
    private $postComment;
    private $postImage;
    private $postVideo;
    private $postAudio;
    private $postStatus;
    private $friendRelation;
    private $user;
    private $notification;
    private $group;
    private $groupUser;
    private $validator;
    private $response;
    private $request;
    private $data = [];
    private $noti = [];
    private $status = [];

    public function __construct(
        Validator $validator,
        PostInterface $post,
        PostLikeInterface $postLike,
        SpotDetailInterface $spotDetail,
        PostCommentInterface $postComment,
        PostImageInterface $postImage,
        PostVideoInterface $postVideo,
        PostAudioInterface $postAudio,
        PostStatusInterface $postStatus,
        FriendRelationInterface $friendRelation,
        NotificationInterface $notification,
        UserInterface $user,
        GroupInterface $group,
        GroupUserInterface $groupUser,
        Response $response,
        Request $request
    )
    {
        $this->post = $post;
        $this->postLike = $postLike;
        $this->spotDetail = $spotDetail;
        $this->postComment = $postComment;
        $this->postImage = $postImage;
        $this->postVideo = $postVideo;
        $this->postAudio = $postAudio;
        $this->postStatus = $postStatus;
        $this->friendRelation = $friendRelation;
        $this->notification = $notification;
        $this->user = $user;
        $this->group = $group;
        $this->groupUser = $groupUser;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function getGroup($sharedUserIds)
    {
        $groups = $this->group
        ->getGroupPost(
            'id',
            $sharedUserIds,
            ['id','group_name','group_slug','group_unique_id']
        );
        if($groups)
        {
            return $groups;
        }
    }

    public function getFriends($sharedUserIds)
    {
        $id = Auth::id();
        $user = $this->friendRelation
        ->getFriendPost('to_user_id','relation_status','from_user_id',$sharedUserIds,1);
        // echo "<pre>";
        // print_r($user);
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
            ->allFriends(
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
            // echo "<pre>";
            // print_r($friends);
            // exit();
            return $friends;
        }
    }

    public function friendPost($id)
    {
        $user = $this->friendRelation
        ->getFriends('to_user_id','relation_status','from_user_id',$id,1);

        if($user)
        {
            $user_id_array = [];
            foreach ($user as $key) {
                array_push($user_id_array,$key['from_user_id']);
                array_push($user_id_array,$key['to_user_id']);
            }

            $user_id_array = array_unique($user_id_array);

            return $user_id_array;
        }
    }

    public function friends($id)
    {
        $user = $this->friendRelation
        ->getFriends('to_user_id','relation_status','from_user_id',$id,1);
        // echo "<pre>";
        // print_r($user);
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
            ->allFriends(
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
            // echo "<pre>";
            // print_r($friends);
            // exit();
            return $friends;
        }
    }

    public function friendsFortag($ids)
    {
        $user = $this->user->allFriends(
            'id',
            $ids,
            [
                'id',
                'user_profile',
                'user_slug',
                'unique_id',
                DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
            ],
        );

        return $user;
    }

    public function values($value)
    {
        $sharedUserIds = explode(',',$value['shared_user_id']); 
        $shared_friends = $this->friendsFortag($sharedUserIds);
        // echo "<pre>";
        // print_r($shared_friends);
        
        $value['shared_user'] = $shared_friends;

        $taggedUserIds = explode(',',$value['tagged_user_id']); 
        $tagged_friends = $this->friendsFortag($taggedUserIds);
        // echo "<pre>";
        // print_r($tagged_friends);
        
        $value['tagged_user'] = $tagged_friends;
        
        $sharedGroupIds = explode(',',$value['shared_group_id']); 
        $shared_friends = $this->getGroup($sharedGroupIds);
        // echo "<pre>";
        // print_r($shared_friends);
        
        $value['shared_group'] = $shared_friends;

        $countLike = count($value['post_like']);
        $value['count_like'] = $countLike;
    
        $countComment = count($value['post_comment']);
        $value['count_comment'] = $countComment;

        return $value;
    }

    public function spotReviews($post)
    {
        
            // exit();
        return $response;
    }

    public function spotGroupPost($checkId)
    {
        $id = Auth::id();
        $friendIds = [];
        $friendPost = $this->friendPost($id);
        if($friendPost != null)
        {
            $friendIds = $friendPost;
        }
        $post = $this->post->post
        ([
        ],$checkId,'!=',null,'user_id',$friendIds,'status',$id);
        $response['posts'] = [];
        $loaded_posts_ids = [];
        $ids_for_posts = [];
        foreach ($post as $key => $value) {
            
            // $values = $this->values($value);
            array_push($loaded_posts_ids,$value['id']);
            // echo "<pre>";
            // print_r($value);

            // $response['posts'][] = $values;
        }
        // exit();
        $postStatus = $this->postStatus->getPostStatus(
            'post_id',
            $loaded_posts_ids,$id
        );
        foreach ($postStatus as $status)
        {
            array_push($ids_for_posts,$status['post_id']);
        }
        $ids_for_posts = array_unique($ids_for_posts);
        $getPost = $this->post->post
        ([
            'status.user',
            'postLike',
            'postLike.user',
            'postComment',
            'postComment.user',
            'postImages:post_id,post_images',
            'postVideos:post_id,post_videos',
            'postAudios:post_id,post_audios',
            'userPost',
            'spotPost.userSpot',
            'spotPost.spotDetail',
            'groupPost',
            'groupPost.groupUsers',
            'eventPost',
        ],$checkId,'!=',null,'id',$ids_for_posts,'status',$id);
        foreach ($getPost as $key => $value) {
            
            $values = $this->values($value);
            $rating = $this->spotDetail->ratings(
                'DB::raw',
                'rating',
                'rating_sum',
                'id',
                'count_rating',
                'spot_id',
                $value['spot_id']
            );

            $avg_rating = null;
            if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                $avg_rating = 0;
            }else{
                $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
            }
            $values['spot_post']['avg_rating'] = $avg_rating;
            // echo "<pre>";
            // print_r($spotReviews);
            $response['posts'][] = $values;
        }
        // exit();
        // $response['posts'] = $getPost;
        if($checkId == 'user_id'){
            $response['loaded_posts_ids'] = [];
            $response['loaded_posts_ids'][] = $ids_for_posts;
        }

        $response['status'] = true;
        return response()->json($response,201);
    }

    public function getUserPost()
    {
        $id = Auth::id();
        $friendIds = [];
        $friendPost = $this->friendPost($id);
        if($friendPost != null)
        {
            $friendIds = $friendPost;
        }
        $post = $this->post->userPost
        ([
            'status.user',
            'postLike',
            'postLike.user',
            'postComment',
            'postComment.user',
            'postImages:post_id,post_images',
            'postVideos:post_id,post_videos',
            'postAudios:post_id,post_audios',
            'userPost'
        ],'spot_id','group_id','event_id',null,'user_id',$friendIds,'status',$id);
        // echo "<pre>";
        // print_r($spotPost);
        // exit();
        $response['posts'] = [];
        $shared_user = [];
        foreach ($post as $key => $value) {
            
            $values = $this->values($value);
            
            $response['posts'][] = $values;
        }

        $response['status'] = true;
        return response()->json($response,201);
    }

    public function getcheckinPost()
    {
        return $this->spotGroupPost('spot_id');
    }

    public function getGroupPost()
    {
        return $this->spotGroupPost('group_id');
    }

    public function getSpotPost()
    {
        $id = Auth::id();
        $businessUser = $this->user->twoWhere('id',$id,'user_type','business',['id']);
        if($businessUser)
        {

            $friendIds = [];
            $friendPost = $this->friendPost($id);
            if($friendPost != null)
            {
                $friendIds = $friendPost;
            }
            // echo "<pre>";
            // print_r($businessUser);
            // exit();
            $post = $this->post->businessPost
            ([
                'status.user',
                'postLike',
                'postLike.user',
                'postComment',
                'postComment.user',
                'postImages:post_id,post_images',
                'postVideos:post_id,post_videos',
                'postAudios:post_id,post_audios',
                'userPost',
                'spotPost',
                'spotPost.userSpot',
                'groupPost',
                'groupPost.groupUsers',
                'eventPost',
            ],'userPost','user_type','business','user_id',$friendIds,'status',$id);
            // echo "<pre>";
            // print_r($spotPost);
            // exit();
            $response['posts'] = [];
            $loaded_posts_ids = [];
            foreach ($post as $key => $value) {
                
                $values = $this->values($value);
                
                array_push($loaded_posts_ids,$value['id']);
    
                $response['posts'][] = $values;
            }
    
            $response['status'] = true;
        }
        else
        {
            $response['message'] = 'You are not a business user';
            $response['status'] = false;
            $response['status_code'] = 404;

        }
        return response()->json($response,201);
    }

    public function get()
    {
        return $this->spotGroupPost('user_id');
    }

    public function create($request)
    {
        $validator = $this->validator->make($request,[
            'post_videos'=>'max:102400',
            'post_audios'=>'max:102400'
        ]);
        if($validator->passes())
        {
            $id = Auth::id();
            $this->data = [
                'user_id' => $id,
                'spot_id' => isset($request['spot_id']) ? $request['spot_id'] : null,
                'group_id' => isset($request['group_id']) ? $request['group_id'] : null,
                'event_id' => isset($request['event_id']) ? $request['event_id'] : null,
                'checkin_id' => isset($request['checkin_id']) ? $request['checkin_id'] : null,
                'title' => isset($request['title']) ? $request['title'] : null,
                'description' => isset($request['description']) ? $request['description'] : null,
                'tagged_user_id'=> isset($request['tagged_user_id']) ? $request['tagged_user_id'] : null,
                'spot_review'=> isset($request['spot_review']) ? $request['spot_review'] : null,
            ];

            $post = $this->post->store($this->data);
            $post_id = $post->id;
            if($post)
            {
                if(isset($request['post_images']))
                {
                    foreach (explode(',',$request['post_images']) as $image)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_images'] = $image;
                        $this->postImage->store($this->data);
                    }
                }

                if(isset($request['post_videos']))
                {
                    foreach ($request['post_videos'] as $video)
                    {
                        // $destination = 'public/videos/post/videos';
                        // $post_videos = uniqid().$video->getClientOriginalName();
                        // $video->move($destination,$post_videos);
                        $this->data['post_id'] = $post_id;
                        $this->data['post_videos'] = $video;
                        $this->postVideo->store($this->data);
                    }
                }

                if(isset($request['post_audios']))
                {
                    foreach ($request['post_audios'] as $audio)
                    {
                        // $destination = 'public/audios/post/audios';
                        // $post_audios = uniqid().$audio->getClientOriginalName();
                        // $audio->move($destination,$post_audios);
                        $this->data['post_id'] = $post_id;
                        $this->data['post_audios'] = $audio;
                        $this->postAudio->store($this->data);
                    }
                }

                if(isset($request['record_images']))
                {
                    foreach (explode(',',$request['record_images']) as $image)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_images'] = $image;
                        $this->postImage->store($this->data);
                    }
                }

                if(isset($request['record_videos']))
                {
                    foreach ($request['record_videos'] as $video)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_videos'] = $video;
                        $this->postVideo->store($this->data);
                    }
                }

                if(isset($request['record_audios']))
                {
                    foreach ($request['record_audios'] as $audio)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_audios'] = $audio;
                        $this->postAudio->store($this->data);
                    }
                }
                if(isset($request['tagged_user_id']))
                {
                    foreach (explode(',',$request['tagged_user_id']) as $key => $value) {
                        $this->noti = [
                            'post_id' => $post_id,
                            'from_user_id'=>$id,
                            'to_user_id'=>$value,
                            'notification_type'=>'tagged-in-the-post',
                            'notification_time'=> now(),
                            'notification_read'=>0,
                            'is_read'=> 0
                        ];
                        $this->notification->store($this->noti);
                    }
                }

                if(isset($request['user_ids']))
                {
                    foreach (explode(',',$request['user_ids']) as $key => $value) {
                        $this->status = [
                            'post_id' => $post_id,
                            'user_id' => $value,
                            'status'=>($request['status'] != 2) ? 2 : $request['status']
                        ];
                        $this->postStatus->store($this->status);
                    }
                }
                else {
                    $this->status = [
                        'post_id' => $post_id,
                        'user_id' => null,
                        'status'=>isset($request['status'])?$request['status'] :0
                    ];
                    $this->postStatus->store($this->status);
                }
                $response['message'] = 'Your post has been created successfully!';
                $response['status'] = true;
                return response()->json($response,201);
            }
            else
            {
                $response['message'] = 'Unauthenticate Error!';
                $response['status'] = false;
                return response()->json($response,400);
            }
        }
        else
        {
            $response['message'] = $validator->errors();
            $response['status'] = false;
            return response()->json($response,404);
        }
    }

    public function view($request)
    {
        $post = $this->post->relationPost
        ([
            'postImages:post_id,post_images',
            'postVideos:post_id,post_videos',
            'postAudios:post_id,post_audios',
            'userPost',
            'spotPost',
            'spotPost.userSpot',
            'groupPost',
            'groupPost.groupUsers',
            'eventPost',
            'postLike',
            'postLike.user',
            'postComment',
            'postComment.user',
        ],'id',$request);
        $response['post'] = [];
        $shared_user = [];
        foreach ($post as $key => $value) {
           
            $sharedUserIds = explode(',',$value['shared_user_id']); 
            $shared_friends = $this->getFriends($sharedUserIds);
            // echo "<pre>";
            // print_r($shared_friends);
            
            $value['shared_user'] = $shared_friends;

            $taggedUserIds = explode(',',$value['tagged_user_id']); 
            $tagged_friends = $this->getFriends($taggedUserIds);
            // echo "<pre>";
            // print_r($tagged_friends);
            
            $value['tagged_user'] = $tagged_friends;
            
            $sharedGroupIds = explode(',',$value['shared_group_id']); 
            $shared_friends = $this->getGroup($sharedGroupIds);
            // echo "<pre>";
            // print_r($shared_friends);
            
            $value['shared_group'] = $shared_friends;

            $response['post'] = $value;
        }

        $response['status'] = true;
        return response()->json($response,201);
    }


    public function edit($request)
    {
        $id = Auth::id();
        $post_id = $request['id'];
        $user_post = $this->post->wherePost('id',$post_id,'user_id',$id);
        // echo "<pre>";
        // print_r($user_post);
        // exit();
        if($user_post)
        {
            $this->data = [
                'spot_id' => isset($request['spot_id']) ? $request['spot_id'] : $user_post[0]['spot_id'],
                'group_id' => isset($request['group_id']) ? $request['group_id'] : $user_post[0]['group_id'],
                'event_id' => isset($request['event_id']) ? $request['event_id'] : $user_post[0]['event_id'],
                'checkin_id' => isset($request['checkin_id']) ? $request['checkin_id'] : $user_post[0]['checkin_id'],
                'title' => isset($request['title']) ? $request['title'] : $user_post[0]['title'],
                'description' => isset($request['description']) ? $request['description'] : $user_post[0]['description'],
                'tagged_user_id'=> isset($request['tagged_user_id']) ? $request['tagged_user_id'] : $user_post[0]['tagged_user_id'],
                'spot_review'=> isset($request['spot_review']) ? $request['spot_review'] : $user_post[0]['spot_review'],
            ];

            $post = $this->post->edit('id',$this->data,$post_id);
            if($post)
            {
                if(isset($request['post_images']))
                {
                    $this->postImage->delete('post_id',$post_id);
                    foreach (explode(',',$request['post_images']) as $image)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_images'] = $image;
                        $this->postImage->store($this->data);
                    }
                }

                if(isset($request['post_videos']))
                {
                    $this->postVideo->delete('post_id',$post_id);
                    foreach (explode(',',$request['post_videos']) as $video)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_videos'] = $video;
                        $this->postVideo->store($this->data);
                    }
                }

                if(isset($request['post_audios']))
                {
                    $this->postAudio->delete('post_id',$post_id);
                    foreach (explode(',',$request['post_audios']) as $audio)
                    {
                        $this->data['post_id'] = $post_id;
                        $this->data['post_audios'] = $audio;
                        $this->postAudio->store($this->data);
                    }
                }

                if(isset($request['user_ids']))
                {
                    $this->postStatus->delete('post_id',$post_id);
                    foreach (explode(',',$request['user_ids']) as $key => $value) {
                        $this->status = [
                            'post_id' => $post_id,
                            'user_id' => $value,
                            'status'=>($request['status'] != 2) ? 2 : $request['status']
                        ];
                        $this->postStatus->store($this->status);
                    }
                }
                else {
                    $this->postStatus->delete('post_id',$post_id);
                    $this->status = [
                        'post_id' => $post_id,
                        'user_id' => null,
                        'status'=>isset($request['status'])?$request['status'] :0
                    ];
                    $this->postStatus->store($this->status);
                }
    
                $response['message'] = 'Your post has been created successfully!';
                $response['status'] = true;
                return response()->json($response,201);
            }
            else
            {
                $response['message'] = 'Unauthenticate Error!';
                $response['status'] = false;
                return response()->json($response,400);
            }
        }
        else
        {
            $response['message'] = 'You are not allowed to change your post!';
            $response['status'] = false;
            return response()->json($response,404);
        }
        
    }

    public function delete($id)
    {
        $user_id = Auth::id();
        $user_post = $this->post->wherePost('id',$id,'user_id',$user_id);
        if($user_post)
        {
            $this->post->destroy($id);
            $this->postImage->delete('post_id',$id);
            $this->postVideo->delete('post_id',$id);
            $this->postAudio->delete('post_id',$id);
            $this->postLike->delete('post_id',$id);
            $this->postComment->delete('post_id',$id);
            $response['message'] = 'Your post has been delete successfully!';
            $response['status'] = true;
            return response()->json($response,201);
        }
        else
        {
            $response['message'] = 'Unauthenticate Error!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function like($id)
    {
        $user_id = Auth::id();
        $postLike = $this->postLike->wherePost('post_id',$id,'user_id',$user_id);
        // echo "<pre>";
        // print_r($postLike);
        // exit();
        if($postLike)
        {
            if($postLike[0]['like'] == null || $postLike[0]['like'] == 0)
            {
                $this->data['like'] = 1;
                $response['message'] = 'You like this post!';
            }
            else
            {
                $this->data['like'] = 0;
                $response['message'] = 'You dislike this post!';
            }
            $data = $this->postLike->edit('id',$this->data,$postLike[0]['id']);
        }
        else
        {
            $this->data = [
                'post_id' => $id,
                'user_id' => $user_id,
                'like' =>1
            ];
            $response['message'] = 'You like this post!';
            $data = $this->postLike->store($this->data);
        }
        $response['status'] = true;
        return response()->json($response,201);
    }

    public function comment($request)
    {
        $user_id = Auth::id();
        $this->data = [
            'post_id' => $request['post_id'],
            'user_id' => $user_id,
            'comment' =>$request['comment']
        ];
        $data = $this->postComment->store($this->data);
        $response['comment'] = $data->comment;
        $response['status'] = true;
        return response()->json($response,201);
    }

    public function updateComment($request)
    {
        $user_id = Auth::id();
        $postComment = $this->postComment->wherePost('id',$request['id'],'user_id',$user_id);
        // echo "<pre>";
        // print_r($postComment);
        // exit();
        if($postComment)
        {
            $this->data = [
                'comment'=>$request['comment']
            ];
            $data = $this->postComment->edit('id',$this->data,$postComment[0]['id']);
            $response['comment'] = $request['comment'];
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'This is not your comment!';
            $response['status'] = false;
            $response['code'] = 400;
        }
        return response()->json($response,201);

    }

    public function deleteComment($id)
    {
        $user_id = Auth::id();
        $postComment = $this->postComment->wherePost('id',$id,'user_id',$user_id);

        if($postComment)
        {
            $this->postComment->destroy($postComment[0]['id']);
            $response['message'] = 'Comment deleted successfully!';
            $response['status'] = true;
            $response['code'] = 201;
        }
        else{
            $response['message'] = 'This is not your comment!';
            $response['status'] = false;
            $response['code'] = 400;
        }
        return response()->json($response,201);
        
    }

    public function getRecentUser()
    {
        $id = Auth::id();
        $friends = $this->friends($id);
        $groups = $this->groupUser->relationalGroup(
            [
                'group',
            ],
            'user_id',$id,'group_status',3);
        // echo "<pre>";
        // print_r($groups);
        // exit();
        $response['recent_users'] = $friends;
        $response['recent_groups'] = $groups;
        $response['status'] = true;
        $response['code'] = 200;
        return response()->json($response);
    }

    public function getSharePost($id)
    {
        $post = $this->post->where('id',$id);
        if($post)
        {
            $shared_user = [];
            $response['post'] = [];
            foreach ($post as $key => $value) {
               
                $sharedUserIds = explode(',',$value['shared_user_id']); 
                $shared_friends = $this->getFriends($sharedUserIds);
                // echo "<pre>";
                // print_r($shared_friends);
                
                $value['shared_user'] = $shared_friends;
                
                $sharedGroupIds = explode(',',$value['shared_group_id']); 
                $shared_friends = $this->getGroup($sharedGroupIds);
                // echo "<pre>";
                // print_r($shared_friends);
                
                $value['shared_group'] = $shared_friends;
    
                $response['post'] = $value;
            }
    
        }   
        else {
            $response['post'] = [];
        }
        // echo "<pre>";
        // print_r($post);
        // exit();
            $response['status'] = true;
            $response['code'] = 200;
        return response()->json($response);
    }

    public function sendShareUpdate($request,$id)
    {
        $user = Auth::user();
        if($user)
        {
            // echo "<pre>";
            // print_r($request);
            // exit();
            $this->post->edit('id',$request,$id);
            $this->data[] = $id;
            return $this->view($this->data);
        }
    }

    public function getAllPost($take)
    {
        $id = Auth::id();
        $friendIds = [];
        $friendPost = $this->friendPost($id);
        if($friendPost != null)
        {
            $friendIds = $friendPost;
        }
        $post = $this->post->homePost('user_id',$friendIds);
        // echo "<pre>";
        // print_r($post);
        // exit();
        $response['posts'] = [];
        $loaded_posts_ids = [];
        $ids_for_posts = [];
        foreach ($post as $key => $value) {
            
            // $values = $this->values($value);
            array_push($loaded_posts_ids,$value['id']);
            // echo "<pre>";
            // print_r($value);

            // $response['posts'][] = $values;
        }
        // exit();
        $postStatus = $this->postStatus->getPostStatus(
            'post_id',
            $loaded_posts_ids,$id
        );
        foreach ($postStatus as $status)
        {
            array_push($ids_for_posts,$status['post_id']);
        }
        $ids_for_posts = array_unique($ids_for_posts);
        $getPost = $this->post->getAllPostHome
        ([
            'status.user',
            'postLike',
            'postLike.user',
            'postComment',
            'postComment.user',
            'postImages:post_id,post_images',
            'postVideos:post_id,post_videos',
            'postAudios:post_id,post_audios',
            'userPost',
            'spotPost.ownerImages',
            'spotPost.ownerVideos',
            'spotPost.userSpot',
            'spotPost.spotDetail.user',
            'checkinPost.userSpot',
            'checkinPost.spotDetail',
            'reviewPost.spot.userSpot',
            'reviewPost.spot.ownerImages',
            'reviewPost.spot.ownerVideos',
            'reviewPost.spotDetailPhotos',
            'reviewPost.spotDetailVideos',
            'planningPost.event',
            'planningPost.spot.ownerImages',
            'planningPost.spot.ownerVideos',
            'planningPost.spot.userSpot',
            'planningPost.spot.spotDetail.spotDetailPhotos',
            'planningPost.spot.spotDetail.spotDetailVideos',
        ],'id',$ids_for_posts,'status','user_id','group_id','event_id',null,$id,0,$take);
        // echo "<pre>";
        // print_r($getPost);
        // exit();
        foreach ($getPost as $key => $value) {

            $taggedUserIds = explode(',',$value->tagged_user_id); 
            $tagged_friends = $this->friendsFortag($taggedUserIds);
            // echo "<pre>";
            // print_r($tagged_friends);
            
            $value['tagged_user'] = $tagged_friends;

            // echo "<pre>";
            // print_r($values);
            // echo "<pre>";
            // print_r($value->spotPost);
            // exit();
            $response['posts'][$key]['id'] = $value->id;
            foreach ($value->status as $status) 
            {
                if($status->status == 0)
                {
                    $response['posts'][$key]['share_with'] = 'Public Post';
                }
                else if($status->status == 1)
                {
                    $response['posts'][$key]['share_with'] = 'Friends Post';
                }
                else{
                    $response['posts'][$key]['share_with'] = count($value->status).' Friends';
                }
            }
            $response['posts'][$key]['spot_id'] = $value->spot_id;
            $response['posts'][$key]['checkin_id'] = $value->checkin_id;
            $response['posts'][$key]['review_id'] = $value->review_id;
            $response['posts'][$key]['planning_id'] = $value->planning_id;
            $response['posts'][$key]['user_id'] = $value->userPost->id;
            $response['posts'][$key]['user_profile'] = $value->userPost->user_profile;
            $response['posts'][$key]['user_slug'] = $value->userPostuser_slug;
            $response['posts'][$key]['fullname'] = $value->userPost->fullname;
            $response['posts'][$key]['title'] = $value->title;
            $response['posts'][$key]['description'] = $value->description;
            $response['posts'][$key]['updated_at_time'] = Carbon::parse($value->updated_at)->format('h:i:s A');
            $response['posts'][$key]['updated_at_date'] = Carbon::parse($value->updated_at)->format('Y-m-d');
            $response['posts'][$key]['created_at_time'] = Carbon::parse($value->created_at)->format('h:i:s A');
            $response['posts'][$key]['created_at_date'] = Carbon::parse($value->created_at)->format('Y-m-d');
            $response['posts'][$key]['tagged_user'] = $value['tagged_user'];
            $response['posts'][$key]['likes_count'] = count($value->postLike);
            $response['posts'][$key]['user_like'] = 0;
            if($value->postLike)
            {
                foreach($value->postLike as $key2 => $value2)
                {
                    if($value2->user_id == $id)
                    {
                        $response['posts'][$key]['user_like'] = $value2->like;
                    }
                }
            }
            $response['posts'][$key]['post_comment'] = $value->postComment;
            $response['posts'][$key]['post_comment']['comments_count'] = count($value->postComment);
            $response['posts'][$key]['post_images'] = $value->postImages;
            $response['posts'][$key]['post_videos'] = $value->postVideos;
            $response['posts'][$key]['post_audios'] = $value->postAudios;
            // echo "<pre>";
            // print_r($response);
            // exit();
            if($value->spot_id)
            {
                $response['posts'][$key]['spot'] = $value->spotPost;
                $response['posts'][$key]['spot']['spot_review'] = $value->spot_review;
                $response['posts'][$key]['spot']['count_like'] = 0;
                $response['posts'][$key]['spot']['count_connected'] = 0;
                $response['posts'][$key]['spot']['count_review'] = 0;

                $rating = $this->spotDetail->ratings(
                    'DB::raw',
                    'rating',
                    'rating_sum',
                    'id',
                    'count_rating',
                    'spot_id',
                    $value->spot_id
                );
                $avg_rating = null;
                if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                    $avg_rating = 0;
                }else{
                    $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                }
                $response['posts'][$key]['spot']['avg_rating'] = $avg_rating;
                if($value->spotPost){
                    foreach ($value->spotPost->spotDetail as $key2 => $value2) {
                        if($value2->spot_id)
                        {
                            $likeUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2->spot_id,
                                'like',
                                '=',
                                1,
                                'user_id',
                            );
                            $connectUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2->spot_id,
                                'connected',
                                '=',
                                1,
                                'user_id',
                            );
                            $reviewUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2->spot_id,
                                'review',
                                '!=',
                                null,
                                'user_id',
                            );
                
                            // echo "<pre>";
                            // print_r(count($likeUser));
                            $response['posts'][$key]['spot']['count_like'] = count($likeUser);
                            $response['posts'][$key]['spot']['count_connected'] = count($connectUser);
                            $response['posts'][$key]['spot']['count_review'] = count($reviewUser);
                        }
                    }
                }
            }
            if($value->checkin_id)
            {
                $rating = $this->spotDetail->ratings(
                    'DB::raw',
                    'rating',
                    'rating_sum',
                    'id',
                    'count_rating',
                    'spot_id',
                    $value->checkin_id
                );
                $avg_rating = null;
                if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                    $avg_rating = 0;
                }else{
                    $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                }
                $response['posts'][$key]['checkin'] = $value->checkinPost;
                $response['posts'][$key]['checkin']['avg_rating'] = $avg_rating;
                $response['posts'][$key]['checkin']['spot_review'] = $value->spot_review;
                $response['posts'][$key]['checkin']['count_like'] = 0;
                $response['posts'][$key]['checkin']['count_connected'] = 0;
                $response['posts'][$key]['checkin']['count_review'] = 0;
                if($value->spotPost){
                    foreach ($value->checkinPost->spotDetail as $key2 => $value2) {
                        if($value2->spot_id)
                        {
                            $likeUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2->spot_id,
                                'like',
                                '=',
                                1,
                                'user_id',
                            );
                            $connectUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2->spot_id,
                                'connected',
                                '=',
                                1,
                                'user_id',
                            );
                            $reviewUser = $this->spotDetail->likeUser(
                                'spot_id',
                                $value2->spot_id,
                                'review',
                                '!=',
                                null,
                                'user_id',
                            );
                
                            // echo "<pre>";
                            // print_r(count($likeUser));
                            $response['posts'][$key]['checkin']['count_like'] = count($likeUser);
                            $response['posts'][$key]['checkin']['count_connected'] = count($connectUser);
                            $response['posts'][$key]['checkin']['count_review'] = count($reviewUser);
                        }
                    }
                }
            }
            if($value->planning_id)
            {
                if($value->planningPost)
                {
                    $response['posts'][$key]['planning_id'] = $value->planningPost->id;
                    $response['posts'][$key]['start_date_time'] = Carbon::parse($value->planningPost->start_date_time)->format('Y-m-d h:i:s A');
                    $response['posts'][$key]['end_date_time'] = Carbon::parse($value->planningPost->end_date_time)->format('Y-m-d h:i:s A');
                    if($value->planningPost->spot_id)
                    {
                        $response['posts'][$key]['planning_spot'] = $value->planningPost->spot;
                        $rating = $this->spotDetail->ratings(
                            'DB::raw',
                            'rating',
                            'rating_sum',
                            'id',
                            'count_rating',
                            'spot_id',
                            $value->planningPost->spot->id
                        );
                        $avg_rating = null;
                        if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                            $avg_rating = 0;
                        }else{
                            $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                        }
                        $value['avg_rating'] = $avg_rating;
                        $response['posts'][$key]['planning_spot']['avg_rating'] = $value['avg_rating'];
                        $response['posts'][$key]['planning_event'] = [];
                    }
                    else if($value->planningPost->event_id)
                    {
                        $response['posts'][$key]['planning_spot'] = [];
                        $response['posts'][$key]['planning_event'] = $value->planningPost->event;
                    }
                }
            }
            if($value->review_id)
            {
                if($value->reviewPost)
                {
                    $response['posts'][$key]['review_id'] = $value->reviewPost->id;
                    $response['posts'][$key]['review_date_time'] = Carbon::parse($value->reviewPost->review_date_time)->format('Y-m-d h:i:s A');
                    $response['posts'][$key]['rating'] = $value->reviewPost->rating;
                    $response['posts'][$key]['connected'] = ($value->reviewPost->connected == 1)?'Connected':'Not Connected';
                    $response['posts'][$key]['like'] = ($value->reviewPost->like == 1)?'Like':'Dislike';
                    $response['posts'][$key]['review_spot'] = $value->reviewPost->spot;
                    $response['posts'][$key]['review_spot']['images'] = $value->reviewPost->spotDetailPhotos;
                    $response['posts'][$key]['review_spot']['videos'] = $value->reviewPost->spotDetailVideos;
                }
            }

        }
        // $response['posts'] = $getPost;

        $response['status'] = true;
        return response()->json($response,201);
    }

    public function share($request)
    {
        $user = Auth::user();
        if($user)
        {
            $group = $this->group->showAllGroups(
                [],
                'user_id',
                $user->id,
                'group_status',
                3,
                'groupUsers'
            );
            $post = $this->post->where('id',$request['post_id']);
            if($post)
            {
                $validator = $this->validator->make($request,[
                    'post_videos'=>'max:102400',
                    'post_audios'=>'max:102400'
                ]);
                if($validator->passes())
                {
                    $groupIds = [];
                    $idsGroup = '';
                    if(count($group) > 0)
                    {
                        foreach($group as $groups)
                        {
                            $groupIds[] = $groups['id'];
                        }
                        $idsGroup = implode(',', $groupIds);
                    }
                    $this->data = [
                        'user_id' => $user->id,
                        'spot_id' => isset($request['spot_id']) ? $request['spot_id'] : null,
                        'group_id' => isset($request['group_id']) ? $request['group_id'] : null,
                        'event_id' => isset($request['event_id']) ? $request['event_id'] : null,
                        'checkin_id' => isset($request['checkin_id']) ? $request['checkin_id'] : null,
                        'title' => isset($request['title']) ? $request['title'] : null,
                        'description' => isset($request['description']) ? $request['description'] : null,
                        'shared_group_id' => $idsGroup,
                        'tagged_user_id' => isset($request['tagged_user_id']) ? $request['tagged_user_id'] : null,
                        'spot_review' => isset($request['spot_review']) ? $request['spot_review'] : null,
                        'parent_id' => isset($request['post_id']) ? $request['post_id'] : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
        
                    $post = $this->post->store($this->data);
                    $post_id = $post->id;
                    if($post)
                    {
                        if(isset($request['post_images']))
                        {
                            foreach (explode(',',$request['post_images']) as $image)
                            {
                                $this->data['post_id'] = $post_id;
                                $this->data['post_images'] = $image;
                                $this->postImage->store($this->data);
                            }
                        }
        
                        if(isset($request['post_videos']))
                        {
                            foreach ($request['post_videos'] as $video)
                            {
                                // $destination = 'public/videos/post/videos';
                                // $post_videos = uniqid().$video->getClientOriginalName();
                                // $video->move($destination,$post_videos);
                                $this->data['post_id'] = $post_id;
                                $this->data['post_videos'] = $video;
                                $this->postVideo->store($this->data);
                            }
                        }
        
                        if(isset($request['post_audios']))
                        {
                            foreach ($request['post_audios'] as $audio)
                            {
                                // $destination = 'public/audios/post/audios';
                                // $post_audios = uniqid().$audio->getClientOriginalName();
                                // $audio->move($destination,$post_audios);
                                $this->data['post_id'] = $post_id;
                                $this->data['post_audios'] = $audio;
                                $this->postAudio->store($this->data);
                            }
                        }
        
                        if(isset($request['record_images']))
                        {
                            foreach (explode(',',$request['record_images']) as $image)
                            {
                                $this->data['post_id'] = $post_id;
                                $this->data['post_images'] = $image;
                                $this->postImage->store($this->data);
                            }
                        }
        
                        if(isset($request['record_videos']))
                        {
                            foreach ($request['record_videos'] as $video)
                            {
                                $this->data['post_id'] = $post_id;
                                $this->data['post_videos'] = $video;
                                $this->postVideo->store($this->data);
                            }
                        }
        
                        if(isset($request['record_audios']))
                        {
                            foreach ($request['record_audios'] as $audio)
                            {
                                $this->data['post_id'] = $post_id;
                                $this->data['post_audios'] = $audio;
                                $this->postAudio->store($this->data);
                            }
                        }
                        if(isset($request['tagged_user_id']))
                        {
                            foreach (explode(',',$request['tagged_user_id']) as $key => $value) {
                                $this->noti = [
                                    'post_id' => $post_id,
                                    'from_user_id'=>$user->id,
                                    'to_user_id'=>$value,
                                    'notification_type'=>'tagged-in-the-post',
                                    'notification_time'=> now(),
                                    'notification_read'=>0,
                                    'is_read'=> 0
                                ];
                                $this->notification->store($this->noti);
                            }
                        }
        
                        if(isset($request['user_ids']))
                        {
                            foreach (explode(',',$request['user_ids']) as $key => $value) {
                                $this->status = [
                                    'post_id' => $post_id,
                                    'user_id' => $value,
                                    'status'=>($request['status'] != 2) ? 2 : $request['status']
                                ];
                                $this->postStatus->store($this->status);
                            }
                        }
                        else {
                            $this->status = [
                                'post_id' => $post_id,
                                'user_id' => null,
                                'status'=>isset($request['status'])?$request['status'] :0
                            ];
                            $this->postStatus->store($this->status);
                        }
                        $response['message'] = 'Your post has been created successfully!';
                        $response['status'] = true;
                        return response()->json($response,201);
                    }
                    else
                    {
                        $response['message'] = 'No post!';
                        $response['status'] = false;
                        return response()->json($response,400);
                    }
                }
                else
                {
                    $response['message'] = $validator->errors();
                    $response['status'] = false;
                    return response()->json($response,404);
                }
            }
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 401;
        }
        return response()->json($response);
    }

    public function getAllGroupPost($id)
    {
        $user = Auth::user();
        if($user)
        {
            $post = $this->post->getAllGroupPosts('group_id','shared_group_id',$id,
            [
                'sharedUser',
                'status.user',
                'postLike',
                'postLike.user',
                'postComment',
                'postComment.user',
                'postImages:post_id,post_images',
                'postVideos:post_id,post_videos',
                'postAudios:post_id,post_audios',
                'userPost',
                'spotPost.ownerImages',
                'spotPost.ownerVideos',
                'spotPost.userSpot',
                'spotPost.spotDetail.user',
                'checkinPost.userSpot',
                'checkinPost.spotDetail',
                'reviewPost.spot.userSpot',
                'reviewPost.spot.ownerImages',
                'reviewPost.spot.ownerVideos',
                'reviewPost.spotDetailPhotos',
                'reviewPost.spotDetailVideos',
                'planningPost.event',
                'planningPost.spot.ownerImages',
                'planningPost.spot.ownerVideos',
                'planningPost.spot.userSpot',
                'planningPost.spot.spotDetail.spotDetailPhotos',
                'planningPost.spot.spotDetail.spotDetailVideos',
            ]);
            $response['posts'] = [];
            if(count($post) > 0) 
            {
                foreach ($post as $key => $value) {

                    $taggedUserIds = explode(',',$value->tagged_user_id); 
                    $tagged_friends = $this->friendsFortag($taggedUserIds);
                    // echo "<pre>";
                    // print_r($tagged_friends);
                    
                    $value['tagged_user'] = $tagged_friends;

                    // echo "<pre>";
                    // print_r($values);
                    // echo "<pre>";
                    // print_r($value->spotPost);
                    // exit();

                    if($value->shared_user_id)
                    {
                        $response['posts'][$key]['shared_user']['user_id'] = $value->sharedUser->id;
                        $response['posts'][$key]['shared_user']['user_profile'] = $value->sharedUser->user_profile;
                        $response['posts'][$key]['shared_user']['user_slug'] = $value->sharedUser->user_slug;
                        $response['posts'][$key]['shared_user']['fullname'] = $value->sharedUser->fullname;
                    }
                    $response['posts'][$key]['id'] = $value->id;
                    foreach ($value->status as $status) 
                    {
                        if($status->status == 0)
                        {
                            $response['posts'][$key]['share_with'] = 'Public Post';
                        }
                        else if($status->status == 1)
                        {
                            $response['posts'][$key]['share_with'] = 'Friends Post';
                        }
                        else{
                            $response['posts'][$key]['share_with'] = count($value->status).' Friends';
                        }
                    }
                    $response['posts'][$key]['spot_id'] = $value->spot_id;
                    $response['posts'][$key]['checkin_id'] = $value->checkin_id;
                    $response['posts'][$key]['review_id'] = $value->review_id;
                    $response['posts'][$key]['planning_id'] = $value->planning_id;
                    $response['posts'][$key]['user_id'] = $value->userPost->id;
                    $response['posts'][$key]['user_profile'] = $value->userPost->user_profile;
                    $response['posts'][$key]['user_slug'] = $value->userPost->user_slug;
                    $response['posts'][$key]['fullname'] = $value->userPost->fullname;
                    $response['posts'][$key]['title'] = $value->title;
                    $response['posts'][$key]['description'] = $value->description;
                    $response['posts'][$key]['updated_at_time'] = Carbon::parse($value->updated_at)->format('h:i:s A');
                    $response['posts'][$key]['updated_at_date'] = Carbon::parse($value->updated_at)->format('Y-m-d');
                    $response['posts'][$key]['created_at_time'] = Carbon::parse($value->created_at)->format('h:i:s A');
                    $response['posts'][$key]['created_at_date'] = Carbon::parse($value->created_at)->format('Y-m-d');
                    $response['posts'][$key]['tagged_user'] = $value['tagged_user'];
                    $response['posts'][$key]['likes_count'] = count($value->postLike);
                    $response['posts'][$key]['post_comment'] = $value->postComment;
                    $response['posts'][$key]['post_comment']['comments_count'] = count($value->postComment);
                    $response['posts'][$key]['post_images'] = $value->postImages;
                    $response['posts'][$key]['post_videos'] = $value->postVideos;
                    $response['posts'][$key]['post_audios'] = $value->postAudios;
                    
                    // echo "<pre>";
                    // print_r($response);
                    // exit();
                    if($value->spot_id)
                    {
                        $response['posts'][$key]['spot'] = $value->spotPost;
                        $response['posts'][$key]['spot']['spot_review'] = $value->spot_review;
                        $response['posts'][$key]['spot']['count_like'] = 0;
                        $response['posts'][$key]['spot']['count_connected'] = 0;
                        $response['posts'][$key]['spot']['count_review'] = 0;

                        $rating = $this->spotDetail->ratings(
                            'DB::raw',
                            'rating',
                            'rating_sum',
                            'id',
                            'count_rating',
                            'spot_id',
                            $value->spot_id
                        );
                        $avg_rating = null;
                        if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                            $avg_rating = 0;
                        }else{
                            $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                        }
                        $response['posts'][$key]['spot']['avg_rating'] = $avg_rating;
                        if($value->spotPost){
                            foreach ($value->spotPost->spotDetail as $key2 => $value2) {
                                if($value2->spot_id)
                                {
                                    $likeUser = $this->spotDetail->likeUser(
                                        'spot_id',
                                        $value2->spot_id,
                                        'like',
                                        '=',
                                        1,
                                        'user_id',
                                    );
                                    $connectUser = $this->spotDetail->likeUser(
                                        'spot_id',
                                        $value2->spot_id,
                                        'connected',
                                        '=',
                                        1,
                                        'user_id',
                                    );
                                    $reviewUser = $this->spotDetail->likeUser(
                                        'spot_id',
                                        $value2->spot_id,
                                        'review',
                                        '!=',
                                        null,
                                        'user_id',
                                    );
                        
                                    // echo "<pre>";
                                    // print_r(count($likeUser));
                                    $response['posts'][$key]['spot']['count_like'] = count($likeUser);
                                    $response['posts'][$key]['spot']['count_connected'] = count($connectUser);
                                    $response['posts'][$key]['spot']['count_review'] = count($reviewUser);
                                }
                            }
                        }
                    }
                    if($value->checkin_id)
                    {
                        $rating = $this->spotDetail->ratings(
                            'DB::raw',
                            'rating',
                            'rating_sum',
                            'id',
                            'count_rating',
                            'spot_id',
                            $value->checkin_id
                        );
                        $avg_rating = null;
                        if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                            $avg_rating = 0;
                        }else{
                            $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                        }
                        $response['posts'][$key]['checkin'] = $value->checkinPost;
                        $response['posts'][$key]['checkin']['avg_rating'] = $avg_rating;
                        $response['posts'][$key]['checkin']['spot_review'] = $value->spot_review;
                        $response['posts'][$key]['checkin']['count_like'] = 0;
                        $response['posts'][$key]['checkin']['count_connected'] = 0;
                        $response['posts'][$key]['checkin']['count_review'] = 0;
                        if($value->spotPost){
                            foreach ($value->checkinPost->spotDetail as $key2 => $value2) {
                                if($value2->spot_id)
                                {
                                    $likeUser = $this->spotDetail->likeUser(
                                        'spot_id',
                                        $value2->spot_id,
                                        'like',
                                        '=',
                                        1,
                                        'user_id',
                                    );
                                    $connectUser = $this->spotDetail->likeUser(
                                        'spot_id',
                                        $value2->spot_id,
                                        'connected',
                                        '=',
                                        1,
                                        'user_id',
                                    );
                                    $reviewUser = $this->spotDetail->likeUser(
                                        'spot_id',
                                        $value2->spot_id,
                                        'review',
                                        '!=',
                                        null,
                                        'user_id',
                                    );
                        
                                    // echo "<pre>";
                                    // print_r(count($likeUser));
                                    $response['posts'][$key]['checkin']['count_like'] = count($likeUser);
                                    $response['posts'][$key]['checkin']['count_connected'] = count($connectUser);
                                    $response['posts'][$key]['checkin']['count_review'] = count($reviewUser);
                                }
                            }
                        }
                    }
                    if($value->planning_id)
                    {
                        $response['posts'][$key]['planning_id'] = $value->planningPost->id;
                        $response['posts'][$key]['start_date_time'] = Carbon::parse($value->planningPost->start_date_time)->format('Y-m-d h:i:s A');
                        $response['posts'][$key]['end_date_time'] = Carbon::parse($value->planningPost->end_date_time)->format('Y-m-d h:i:s A');
                        if($value->planningPost->spot_id)
                        {
                            $response['posts'][$key]['planning_spot'] = $value->planningPost->spot;
                            $rating = $this->spotDetail->ratings(
                                'DB::raw',
                                'rating',
                                'rating_sum',
                                'id',
                                'count_rating',
                                'spot_id',
                                $value->planningPost->spot->id
                            );
                            $avg_rating = null;
                            if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                                $avg_rating = 0;
                            }else{
                                $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                            }
                            $value['avg_rating'] = $avg_rating;
                            $response['posts'][$key]['planning_spot']['avg_rating'] = $value['avg_rating'];
                            $response['posts'][$key]['planning_event'] = [];
                        }
                        else if($value->planningPost->event_id)
                        {
                            $response['posts'][$key]['planning_spot'] = [];
                            $response['posts'][$key]['planning_event'] = $value->planningPost->event;
                        }
                    }
                    if($value->review_id)
                    {
                        $response['posts'][$key]['review_id'] = $value->reviewPost->id;
                        $response['posts'][$key]['review_date_time'] = Carbon::parse($value->reviewPost->review_date_time)->format('Y-m-d h:i:s A');
                        $response['posts'][$key]['rating'] = $value->reviewPost->rating;
                        $response['posts'][$key]['connected'] = ($value->reviewPost->connected == 1)?'Connected':'Not Connected';
                        $response['posts'][$key]['like'] = ($value->reviewPost->like == 1)?'Like':'Dislike';
                        $response['posts'][$key]['review_spot'] = $value->reviewPost->spot;
                        $response['posts'][$key]['review_spot']['images'] = $value->reviewPost->spotDetailPhotos;
                        $response['posts'][$key]['review_spot']['videos'] = $value->reviewPost->spotDetailVideos;
                    }

                }
            }
            // echo "<pre>";
            // print_r($post);
            // exit();
            $response['status'] = true;
            $response['code'] = 201;
        }
        else {
            $response['message'] = 'Authenticate Error!';
            $response['status'] = false;
            $response['code'] = 401;
        }
        return response()->json($response,201); //
    }
}