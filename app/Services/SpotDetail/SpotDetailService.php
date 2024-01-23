<?php 

namespace App\Services\SpotDetail;

use App\Repositories\SpotDetail\SpotDetailInterface;
use App\Repositories\SpotDetailPhoto\SpotDetailPhotoInterface;
use App\Repositories\SpotDetailVideo\SpotDetailVideoInterface;
use App\Repositories\SpotInvite\SpotInviteInterface;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use App\Models\SpotDetail;
use App\Repositories\Post\PostInterface;
use App\Repositories\Spot\SpotInterface;
use App\Repositories\SpotImage\SpotImageInterface;
use App\Repositories\SpotVideo\SpotVideoInterface;
use App\Repositories\PostImage\PostImageInterface;
use App\Repositories\PostVideo\PostVideoInterface;
use App\Repositories\PostStatus\PostStatusInterface;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class SpotDetailService
{
    private $spotDetail;
    private $spotInvite;
    private $post;
    private $spot;
    private $spotImage;
    private $spotVideo;
    private $postImage;
    private $postVideo;
    private $postStatus;
    private $spotDetailPhoto;
    private $spotDetailVideo;
    private $notification;
    private $user;
    private $validator;
    private $response;
    private $request;
    private $data = [];
    private $noti = [];
    private $postData = [];
    private $postStatusData = [];


    public function __construct(
        Validator $validator,
        SpotDetailInterface $spotDetail,
        SpotInviteInterface $spotInvite,
        SpotInterface $spot,
        SpotImageInterface $spotImage,
        SpotVideoInterface $spotVideo,
        UserInterface $user,
        PostInterface $post,
        PostImageInterface $postImage,
        PostVideoInterface $postVideo,
        PostStatusInterface $postStatus,
        NotificationInterface $notification,
        SpotDetailPhotoInterface $spotDetailPhoto,
        SpotDetailVideoInterface $spotDetailVideo,
        Response $response,
        Request $request
    )
    {
        $this->spotDetail = $spotDetail;
        $this->spotInvite = $spotInvite;
        $this->notification = $notification;
        $this->user = $user;
        $this->post = $post;
        $this->spotVideo = $spotVideo;
        $this->spotImage = $spotImage;
        $this->spot = $spot;
        $this->postImage = $postImage;
        $this->postVideo = $postVideo;
        $this->postStatus = $postStatus;
        $this->spotDetailPhoto = $spotDetailPhoto;
        $this->spotDetailVideo = $spotDetailVideo;
        $this->response = $response;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function rating($value,$users_id_array)
    {
        $user = $this->user->allFriends(
            'id',
            $users_id_array,
            [
                'id',
                'user_profile',
                'user_slug',
                'unique_id',
                DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
            ],
        );
        $value['like_users'] = $user;

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
        $value['avg_rating'] = $avg_rating;

        return $value;
    }

    public function get()
    {
        $id = Auth::id();
        $likeSpot = $this->spotDetail->likeSpot(
        [
            'spot.ownerImages',
            'spot.ownerVideos',
            'spot.userSpot'
        ],
            'like',
            1,
            'connected',
            'user_id',
            $id,
            [
                'spot_id',
            ]
        );
        $response['like_connected_spots'] = [];
        // $response['like'] = [];
        // $response['connected'] = [];
        // $response['review'] = [];
        if($likeSpot)
        {
            foreach($likeSpot as $key => $value)
            {
                $likeUser = $this->spotDetail->likeUser(
                    'spot_id',
                    $value['spot_id'],
                    'like',
                    '=',
                    1,
                    'user_id',
                );
                // $connectUser = $this->spotDetail->likeUser(
                //     'spot_id',
                //     $value['spot_id'],
                //     'connected',
                //     '=',
                //     1,
                //     'user_id',
                // );
                // $reviewUser = $this->spotDetail->likeUser(
                //     'spot_id',
                //     $value['spot_id'],
                //     'review',
                //     '!=',
                //     null,
                //     'user_id',
                // );
                $users_id_array = [];
                foreach ($likeUser as $v) {
                    array_push($users_id_array, $v['user_id']);
                }
                $values = $this->rating($value,$users_id_array);

                $response['like_connected_spots'][] = $values;
                // $response['like'][] = count($likeUser);
                // $response['connected'][] = count($connectUser);
                // $response['review'][] = count($reviewUser);
            }
            // echo "<pre>";
            // print_r($rating);
            // exit();
        }
        $response['status'] = true;
        return response()->json($response,201);
    }

    public function spotMedia($request)
    {
        $user = Auth::user();
        if($user)
        {
            $spot = $this->spot->show($request['id']);
            if($spot->user_id == $user->id)
            {
                if(isset($request['review_photo']))
                {
                    foreach (explode(',',$request['review_photo']) as $image)
                    {
                        $this->data['spot_id'] = $request['id'];
                        $this->data['images'] = $image;
                        $this->spotImage->store($this->data);
                    }
                }

                if(isset($request['review_video']))
                {
                    foreach ($request['review_video'] as $video)
                    {
                        $this->data['spot_id'] = $request['id'];
                        $this->data['videos'] = $video;
                        $this->spotVideo->store($this->data);
                    }
                }
                // echo "<pre>";
                // print_r('$spot');
                // exit();
                $response['message'] = 'Your Media has been created successfully!';
                $response['status'] = true;
                return response()->json($response,201);
            }
            else{
                // echo "<pre>";
                // print_r($spot);
                // exit();
                $id = Auth::id();
                $sameReview = $this->spotDetail
                ->checkUser('spot_id',$request['id'],'user_id',$id);
                $this->data = [
                    'spot_id'=>$request['id'],
                    'user_id'=>$id,
                ];
                if($sameReview)
                {
                    $review = $this->spotDetail->edit('id',$this->data,$sameReview[0]['id']);
                    // echo "<pre>";
                    // print_r($review);
                    // exit();
                    $review_id = $sameReview[0]['id'];
                }
                else
                {
                    $review = $this->spotDetail->store($this->data);
                    $review_id = $review->id;
                    // echo "<pre>";
                    // print_r($review);
                    // exit();
                }
                if($review)
                {

                    if(isset($request['review_photo']))
                    {
                        foreach (explode(',',$request['review_photo']) as $image)
                        {
                            $this->data['spot_detail_id'] = $review_id;
                            $this->data['review_photo'] = $image;
                            $this->spotDetailPhoto->store($this->data);
                        }
                    }

                    if(isset($request['review_video']))
                    {
                        foreach ($request['review_video'] as $video)
                        {
                            $this->data['spot_detail_id'] = $review_id;
                            $this->data['review_video'] = $video;
                            $this->spotDetailVideo->store($this->data);
                        }
                    }
                }  
                $response['message'] = 'Your Media has been created successfully!';
                $response['status'] = true;
                return response()->json($response,201); 
            }
        }
        else
        {
            $response['message'] = 'Authenticated Error!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function create($request)
    {
        $id = Auth::id();
        $sameReview = $this->spotDetail
        ->checkUser('spot_id',$request['id'],'user_id',$id);
        if($sameReview)
        {
            $this->data = [
                'spot_id'=>$request['id'],
                'user_id'=>$id,
                'rating'=>isset($request['rating']) ? $request['rating'] : $sameReview[0]['rating'],
                'review'=>isset($request['review']) ? $request['review'] : $sameReview[0]['review'],
                'review_date_time'=>(isset($request['review']) || isset($request['rating'])) ? now() : $sameReview[0]['review_date_time'],
            ];
            $review = $this->spotDetail->edit('id',$this->data,$sameReview[0]['id']);
            // echo "<pre>";
            // print_r($review);
            // exit();
            $review_id = $sameReview[0]['id'];
        }
        else
        {
            $this->data = [
                'spot_id'=>$request['id'],
                'user_id'=>$id,
                'rating'=>isset($request['rating']) ? $request['rating'] : null,
                'review'=>isset($request['review']) ? $request['review'] : null,
                'review_date_time'=>(isset($request['review']) || isset($request['rating'])) ? now() : null,
            ];
            $review = $this->spotDetail->store($this->data);
            $review_id = $review->id;
            // echo "<pre>";
            // print_r($review);
            // exit();
        }
        if($review)
        {

            if(isset($request['review_photo']))
            {
                foreach (explode(',',$request['review_photo']) as $image)
                {
                    $this->data['spot_detail_id'] = $review_id;
                    $this->data['review_photo'] = $image;
                    $this->spotDetailPhoto->store($this->data);
                }
            }

            if(isset($request['review_video']))
            {
                foreach ($request['review_video'] as $video)
                {
                    $this->data['spot_detail_id'] = $review_id;
                    $this->data['review_video'] = $video;
                    $this->spotDetailVideo->store($this->data);
                }
            }
            
            $this->postData = [
                'user_id' => $id,
                'description'=>isset($request['review']) ? $request['review'] : null,
                'review_id'=>$review_id
            ]; 
            $post = $this->post->store($this->postData);
            
            if(isset($request['review_photo']))
            {
                foreach (explode(',',$request['review_photo']) as $image)
                {
                    $this->data['post_id'] = $post->id;
                    $this->data['post_images'] = $image;
                    $this->postImage->store($this->data);
                }
            }

            if(isset($request['review_video']))
            {
                foreach ($request['review_video'] as $video)
                {
                    $this->data['post_id'] = $post->id;
                    $this->data['post_videos'] = $video;
                    $this->postVideo->store($this->data);
                }
            }

            $this->postStatusData = [
                'post_id' => $post->id,
                'status'=>0
            ];

            $this->postStatus->store($this->postStatusData);

            $response['message'] = 'Your review has been created successfully!';
            $response['status'] = true;
            return response()->json($response,201);
        }
        else
        {
            $response['message'] = 'Something went wrong!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function edit($request)
    {
        $spot_detail = $this->spotDetail->where('id',$request['id']);
        // echo "<pre>";
        // print_r($spot_detail);
        // exit();
        $this->data = [
            'rating'=>isset($request['rating']) ? $request['rating'] : $spot_detail[0]['rating'],
            'review'=>isset($request['review']) ? $request['review'] : $spot_detail[0]['review'],
            'review_date_time'=>(isset($request['review']) || isset($request['rating'])) ? now() : $spot_detail[0]['review_date_time'],
        ];
        $review = $this->spotDetail->edit('id',$this->data,$request['id']);
        $review_id = $request['id'];
        if($review)
        {
            if(isset($request['review_photo']))
            {
                $this->spotDetailPhoto->delete('spot_detail_id',$review_id);
                foreach (explode(',',$request['review_photo']) as $image)
                {
                    $this->data['spot_detail_id'] = $review_id;
                    $this->data['review_photo'] = $image;
                    $this->spotDetailPhoto->store($this->data);
                }
            }

            if(isset($request['review_video']))
            {
                $this->spotDetailVideo->delete('spot_detail_id',$review_id);
                foreach (explode(',',$request['review_video']) as $video)
                {
                    $this->data['spot_detail_id'] = $review_id;
                    $this->data['review_video'] = $video;
                    $this->spotDetailVideo->store($this->data);
                }
            }


            $this->data = [
                'user_id' => $id,
                'description'=>isset($request['review']) ? $request['review'] : null,
                'review_id'=>$review_id
            ]; 
            $post = $this->post->edit('review_id',$this->data,$request['id']);
            
            if(isset($request['review_photo']))
            {
                $this->postImage->delete('post_id',$post->id);
                foreach (explode(',',$request['review_photo']) as $image)
                {
                    $this->data['post_id'] = $post->id;
                    $this->data['post_images'] = $image;
                    $this->postImage->store($this->data);
                }
            }

            if(isset($request['review_video']))
            {
                $this->postVideo->delete('post_id',$post->id);
                foreach ($request['review_video'] as $video)
                {
                    $this->data['post_id'] = $post->id;
                    $this->data['post_videos'] = $video;
                    $this->postVideo->store($this->data);
                }
            }
            $response['message'] = 'Your review has been updated successfully!';
            $response['status'] = true;
            return response()->json($response,201);
        }
        else
        {
            $response['message'] = 'Something went wrong!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function delete($id)
    {
        $deleteReview = $this->spotDetail->destroy($id);
        if($deleteReview)
        {
            $this->spotDetailPhoto->delete('spot_detail_id',$id);
            $this->spotDetailVideo->delete('spot_detail_id',$id);
        
            $response['message'] = 'Your review has been deleted successfully!';
            $response['status'] = true;
            return response()->json($response,201);
        }
        else
        {
            $response['message'] = 'Something went wrong!';
            $response['status'] = false;
            return response()->json($response,400);
        }
    }

    public function likeSpot($id)
    {
        $user = Auth::id();
        $spot_detail = $this->spotDetail->checkUser('spot_id',$id,'user_id',$user);
        // echo "<pre>";
        // print_r($spot_detail);
        // exit();
        if($spot_detail)
        {
            if($spot_detail[0]['like'] == null || $spot_detail[0]['like'] == 0)
            {
                $this->data['like'] = 1;
                $response['message'] = 'You like this spot!';
            }
            else
            {
                $this->data['like'] = 0;
                $response['message'] = 'You dislike this spot!';
            }
            $data = $this->spotDetail->edit('id',$this->data,$spot_detail[0]['id']);
        }
        else
        {
            $this->data = [
                'spot_id' => $id,
                'user_id' => $user,
                'like' =>1
            ];
            $response['message'] = 'You like this spot!';
            $data = $this->spotDetail->store($this->data);
        }
        $response['status'] = true;
        return response()->json($response,201);
    }


    public function connectedSpot($id)
    {
        $user = Auth::id();
        $spot_detail = $this->spotDetail->checkUser('spot_id',$id,'user_id',$user);
        // echo "<pre>";
        // print_r($spot_detail);
        // exit();
        if($spot_detail)
        {
            if($spot_detail[0]['connected'] == null || $spot_detail[0]['connected'] == 0)
            {
                $this->data['connected'] = 1;
                $response['message'] = 'You connected this spot!';
            }
            else
            {
                $this->data['connected'] = 0;
                $response['message'] = 'You disconnected this spot!';
            }
            $data = $this->spotDetail->edit('id',$this->data,$spot_detail[0]['id']);
        }
        else
        {
            $this->data = [
                'spot_id' => $id,
                'user_id' => $user,
                'connected' =>1
            ];
            $response['message'] = 'You connected this spot!';
            $data = $this->spotDetail->store($this->data);
        }
        $response['status'] = true;
        return response()->json($response,201);
    }

    public function inviteFriends($request)
    {
        $user = Auth::id();
        foreach (explode(',',$request['invited_user_id']) as $key => $invited_user_id) {
            $this->data = [
                'spot_id' => $request['spot_id'],
                'from_user_id'=>$user,
                'invited_user_id' =>$invited_user_id
            ];
            // echo "<pre>";
            // print_r($invitedIds[$key]);
            $spotDetail = $this->spotInvite->threeWhere(
                'invited_user_id',
                $invited_user_id,
                'spot_id',
                $request['spot_id'],
                'from_user_id',
                $user
            );
            
            $this->noti = [
                'from_user_id'=>$user,
                'to_user_id'=>$invited_user_id,
                'invited_spot_id'=>$request['spot_id'],
                'notification_type'=>'invite-in-spot',
                'notification_time'=> now(),
                'notification_read'=>0,
                'is_read'=> 0
            ];

            if($spotDetail)
            {
                $response['message'] = 'You already invited this user';
                $response['status'] = false;
            }
            else {
                $this->spotInvite->store($this->data);
                $this->notification->store($this->noti);
                $response['message'] = 'You Invited Your Friends!';
                $response['status'] = true;
            }
        }
        // exit();
        return response()->json($response,201);
    }

    public function addReply($request)
    {
        $user = Auth::user();
        if($user)
        {
            $spotDetail = $this->spotDetail->where('id',$request['spot_id']);
            // echo "<pre>";
            // print_r($spotDetail);
            // exit();
            if($spotDetail)
            {
                $this->data = [
                    'spot_id' => $spotDetail[0]['spot_id'],
                    'review'=> isset($request['review']) ? $request['review'] : null,
                    'review_date_time'=>(isset($request['review'])) ? now() : null,
                    'user_id' => $spotDetail[0]['spot_id']
                ];
                $spotReply = $this->spotDetail->store($this->data);
                $response['message'] = 'Reply add successfully';
                $response['status'] = true;
                $response['code'] = 200;
            }
            else
            {
                $response['message'] = 'No review found!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else {
            $response['message'] = 'Error Authenticate!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function editReply($request)
    {
        $user = Auth::user();
        if($user)
        {
            $spotDetail = $this->spotDetail->where('id',$request['id']);
            // echo "<pre>";
            // print_r($spotDetail);
            // exit();
            if($spotDetail)
            {
                $this->data = [
                    'review'=> isset($request['review']) ? $request['review'] : $spotDetail[0]['review'],
                    'review_date_time'=>(isset($request['review'])) ? now() : $spotDetail[0]['review_date_time']
                ];
                $spotReply = $this->spotDetail->edit('id',$this->data,$request['id']);
                $response['message'] = 'Reply update successfully';
                $response['status'] = true;
                $response['code'] = 200;
            }
            else
            {
                $response['message'] = 'No review found!';
                $response['status'] = false;
                $response['code'] = 401;
            }
        }
        else {
            $response['message'] = 'Error Authenticate!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }

    public function deleteReply($id)
    {
        $user = Auth::user();
        if($user)
        {
            $this->spotDetail->destroy($id);
            $response['message'] = 'Reply deleted successfully';
            $response['status'] = true;
            $response['code'] = 200;
        }
        else {
            $response['message'] = 'Error Authenticate!';
            $response['status'] = false;
            $response['code'] = 404;
        }
        return response()->json($response);
    }
}