<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Models\FriendRelation;
use App\Models\Interest;
use App\Models\Post;
use App\Models\PostStatus;
use App\Models\SpotDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $getUsers = FriendRelation::where(function ($query) use ($user){
            $query->where('to_user_id',$user->id)->orWhere('from_user_id',$user->id);
        })->where('relation_status',1)->get()->toArray();
        $friends = '';
        if($getUsers)
        {
            $user_id_array = [];
            foreach ($getUsers as $key) {
                array_push($user_id_array,$key['from_user_id']);
                array_push($user_id_array,$key['to_user_id']);
            }

            $user_id_array = array_unique($user_id_array);
            if (($key = array_search($user->id, $user_id_array)) !== false) {
                unset($user_id_array[$key]);
            }
            $friends = User::select([
                'id',
                'user_profile',
                'user_slug',
                'unique_id',
                'user_status',
                DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
            ])->whereIn('id',$user_id_array)->get();
        }

        $interest = Interest::where('status', 1)->where(function($query){
            $query->where('show_in',0)->orWhere('show_in',2);
        })->get();

        $post = $this->getAllPost();

        return view('ibigo-web.home',compact('friends','interest','post'));
    }

    public function friendPost($id)
    {
        $user = FriendRelation::where(function ($query) use ($id){
            $query->where('to_user_id',$id)->orWhere('from_user_id',$id);
        })->where('relation_status',1)->get()->toArray();

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

    public function friendsFortag($ids)
    {
        $user = User::select([
            'id',
            'user_profile',
            'user_slug',
            'unique_id',
            DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
        ])->whereIn('id',$ids)->limit(2)->get()->toArray();

        return $user;
    }

    public function getAllPost()
    {
        $id = Auth::id();
        $friendIds = [];
        $friendPost = $this->friendPost($id);
        if($friendPost != null)
        {
            $friendIds = $friendPost;
        }
        $post = Post::whereIn('user_id', $friendIds)
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
        // echo "<pre>";
        // print_r($post);
        // exit();
        $allPost = [];
        $loaded_posts_ids = [];
        $ids_for_posts = [];
        foreach ($post as $key => $value) {
            
            // $values = $this->values($value);
            array_push($loaded_posts_ids,$value['id']);
            // echo "<pre>";
            // print_r($value);

            // $allPost[] = $values;
        }
        // exit();
        $postStatus = PostStatus::whereIn('post_id',$loaded_posts_ids)
        ->where(function ($query) use ($id)
        {
            $query->where('status',0)
            ->orWhere('status',1)
            ->orWhere(function ($query1) use ($id){
                $query1->where('status',2)->where('user_id',$id);
            });
        })
        ->get()->toArray();

        // echo "<pre>";
        // print_r($postStatus);
        // exit();
        if($postStatus)
        {
            foreach ($postStatus as $status)
            {
                array_push($ids_for_posts,$status['post_id']);
            }
        }
        $ids_for_posts = array_unique($ids_for_posts);
        // echo "<pre>";
        // print_r($ids_for_posts);
        // exit();
        $getPost = Post::with([
            'status.user',
            'postLike',
            'postLike.user',
            'postComment',
            'postComment.user',
            'postImages:post_id,id,post_images',
            'postVideos:post_id,id,post_videos',
            'postAudios:post_id,id,post_audios',
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
        ])
        ->whereIn('id',$ids_for_posts)
        ->where(function ($q) use ($id){
            $q->whereHas('status',function ($query){
                $query->where('status',1)->where('user_id',null);
            })
            ->orWhereHas('status',function ($query) use ($id){
                $query->where('status',2)->where('user_id',$id);
            })
            ->orWhereHas('status',function ($query2){
                $query2->where('status',0)->where('user_id',null);
            });
        })
        ->orWhere('user_id',$id)
        ->orderBy('created_at', 'DESC')
        ->get()->toArray();
        // echo "<pre>";
        // print_r($getPost);
        // exit();
        if(count($getPost) > 0)
        {
            foreach ($getPost as $key => $value) {
                
                $taggedUserIds = explode(',',$value['tagged_user_id']); 
                $tagged_friends = $this->friendsFortag($taggedUserIds);
                // echo "<pre>";
                // print_r($tagged_friends);
                
                $value['tagged_user'] = $tagged_friends;

                // echo "<pre>";
                // print_r($values);
                // echo "<pre>";
                // print_r($value->spotPost);
                // exit();
                $allPost[$key]['id'] = $value['id'];
                
                $allPost[$key]['share_with'] = '';
                // $allPost[$key]['tagged_user'] = '';
                foreach ($value['status'] as $key2 =>$status) 
                {
                    if($status['status'] == 0)
                    {
                        $allPost[$key]['share_with'] = 'Publicly';
                    }
                    else if($status['status'] == 1)
                    {
                        $allPost[$key]['share_with'] = 'Friends';
                    }
                    else{
                        $allPost[$key]['share_with'] = 'People';
                    }
                }
                $allPost[$key]['spot_id'] = $value['spot_id'];
                $allPost[$key]['checkin_id'] = $value['checkin_id'];
                $allPost[$key]['review_id'] = $value['review_id'];
                $allPost[$key]['planning_id'] = $value['planning_id'];
                $allPost[$key]['user_id'] = $value['user_post']['id'];
                $allPost[$key]['user_profile'] = $value['user_post']['user_profile'];
                $allPost[$key]['unique_id'] = $value['user_post']['unique_id'];
                $allPost[$key]['user_slug'] = $value['user_post']['user_slug'];
                $allPost[$key]['fullname'] = $value['user_post']['fullname'];
                $allPost[$key]['title'] = $value['title'];
                $allPost[$key]['description'] = $value['description'];
                $allPost[$key]['how_long'] = Carbon::parse($value['created_at'])->diffForHumans();
                $allPost[$key]['tagged_user'] = $value['tagged_user'];
                $allPost[$key]['likes_count'] = count($value['post_like']);
                $allPost[$key]['post_comment'] = $value['post_comment'];
                $allPost[$key]['post_comment']['comments_count'] = count($value['post_comment']);
                $allPost[$key]['post_images'] = $value['post_images'];
                $allPost[$key]['post_videos'] = $value['post_videos'];
                $allPost[$key]['post_audios'] = $value['post_audios'];
                $allPost[$key]['status'] = $value['status'];
                // echo "<pre>";
                // print_r($response);
                // exit();
                if($value['spot_id'])
                {
                    if($value['spot_post'])
                    {
                        $allPost[$key]['spot'] = $value['spot_post'];
                        $allPost[$key]['spot']['spot_review'] = $value['spot_review'];
                        $allPost[$key]['spot']['count_like'] = 0;
                        $allPost[$key]['spot']['count_connected'] = 0;
                        $allPost[$key]['spot']['count_review'] = 0;

                        $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                        ->where('spot_id',$value['spot_id'])->get()->toArray();
                        $avg_rating = null;
                        if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                            $avg_rating = 0;
                        }else{
                            $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                        }
                        $allPost[$key]['spot']['avg_rating'] = $avg_rating;
                        if($value['spot_post']){
                            foreach ($value['spot_post']['spot_detail'] as $key2 => $value2) {
                                if($value2['spot_id'])
                                {
                                    $likeUser = SpotDetail::select('user_id')
                                    ->where('spot_id',$value2['spot_id'])
                                    ->where('like','=',1)->get()->toArray();

                                    $connectUser = SpotDetail::select('user_id')
                                    ->where('spot_id',$value2['spot_id'])
                                    ->where('connected','=',1)->get()->toArray();

                                    $reviewUser = SpotDetail::select('user_id')
                                    ->where('spot_id',$value2['spot_id'])
                                    ->where('review','!=',null)->get()->toArray();
                        
                                    // echo "<pre>";
                                    // print_r(count($likeUser));
                                    $allPost[$key]['spot']['count_like'] = count($likeUser);
                                    $allPost[$key]['spot']['count_connected'] = count($connectUser);
                                    $allPost[$key]['spot']['count_review'] = count($reviewUser);
                                }
                            }
                        }
                    }
                }
                if($value['checkin_id'])
                {
                    if($value['checkin_post'])
                    {
                        $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                    ->where('spot_id',$value['checkin_id'])->get()->toArray();
                    
                    $avg_rating = null;
                    if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                        $avg_rating = 0;
                    }else{
                        $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                    }
                        $allPost[$key]['checkin'] = $value['checkin_post'];
                        $allPost[$key]['checkin']['avg_rating'] = $avg_rating;
                        $allPost[$key]['checkin']['spot_review'] = $value['spot_review'];
                        $allPost[$key]['checkin']['count_like'] = 0;
                        $allPost[$key]['checkin']['count_connected'] = 0;
                        $allPost[$key]['checkin']['count_review'] = 0;
                        if($value['spot_post']){
                            foreach ($value['checkin_post']['spot_detail'] as $key2 => $value2) {
                                if($value2['spot_id'])
                                {
                                    $likeUser = SpotDetail::select('user_id')
                                    ->where('spot_id',$value2['spot_id'])
                                    ->where('like','=',1)->get()->toArray();

                                    $connectUser = SpotDetail::select('user_id')
                                    ->where('spot_id',$value2['spot_id'])
                                    ->where('connected','=',1)->get()->toArray();

                                    $reviewUser = SpotDetail::select('user_id')
                                    ->where('spot_id',$value2['spot_id'])
                                    ->where('review','!=',null)->get()->toArray();
                        
                                    // echo "<pre>";
                                    // print_r(count($likeUser));
                                    $allPost[$key]['checkin']['count_like'] = count($likeUser);
                                    $allPost[$key]['checkin']['count_connected'] = count($connectUser);
                                    $allPost[$key]['checkin']['count_review'] = count($reviewUser);
                                }
                            }
                        }
                    }
                }
                if($value['planning_id'])
                {
                    if($value['planning_post'])
                    {
                        $allPost[$key]['start_date'] = Carbon::parse($value['planning_post']['start_date_time'])->format('M d,Y');
                        if($value['planning_post']['end_date_time'])
                        {
                            $allPost[$key]['end_date'] = Carbon::parse($value['planning_post']['end_date_time'])->format('M d,Y');
                        }
                        else{
                            $allPost[$key]['end_date'] = '';
                        }
                        $allPost[$key]['day'] = Carbon::parse($value['planning_post']['start_date_time'])->format('D');
                        $allPost[$key]['date'] = Carbon::parse($value['planning_post']['start_date_time'])->format('d');
                        $allPost[$key]['planning_id'] = $value['planning_post']['id'];
                        $allPost[$key]['start_date_time'] = Carbon::parse($value['planning_post']['start_date_time'])->format('Y-m-d h:i:s A');
                        $allPost[$key]['end_date_time'] = Carbon::parse($value['planning_post']['end_date_time'])->format('Y-m-d h:i:s A');
                        if($value['planning_post']['spot_id'])
                        {
                            $allPost[$key]['like_user'] = '';
                            $likeUser = SpotDetail::with(['user'])->select('user_id')
                            ->where('spot_id',$value['planning_post']['spot']['id'])
                            ->where('like',1)->get()->toArray();
                
                            // echo "<pre>";
                            // print_r(count($likeUser));
                            $allPost[$key]['like_user'] = $likeUser;

                            $allPost[$key]['planning_spot'] = $value['planning_post']['spot'];
                            $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                            ->where('spot_id',$value['planning_post']['spot']['id'])->get()->toArray();
                        
                            $avg_rating = null;
                            if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                                $avg_rating = 0;
                            }else{
                                $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                            }
                            $value['avg_rating'] = $avg_rating;
                            $allPost[$key]['planning_spot']['avg_rating'] = $value['avg_rating'];
                            $allPost[$key]['planning_event'] = [];
                        }
                        else if($value['planning_post']['event_id'])
                        {
                            $allPost[$key]['planning_spot'] = [];
                            $allPost[$key]['planning_event'] = $value['planning_post']['event'];
                        }
                    }
                }
                $allPost[$key]['review_spot'] = '';
                if($value['review_id'])
                {
                    if($value['review_post'])
                    {
                        $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                        ->where('spot_id',$value['review_post']['spot']['id'])->get()->toArray();
                        
                        $avg_rating = null;
                        if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                            $avg_rating = 0;
                        }else{
                            $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating']);
                        }
                        $allPost[$key]['avg_rating'] = $avg_rating;
                        $allPost[$key]['review_id'] = $value['review_post']['id'];
                        $allPost[$key]['review_date_time'] = Carbon::parse($value['review_post']['review_date_time'])->format('Y-m-d h:i:s A');
                        $allPost[$key]['rating'] = $value['review_post']['rating'];
                        $allPost[$key]['connected'] = ($value['review_post']['connected'] == 1)?'Connected':'Not Connected';
                        $allPost[$key]['like'] = ($value['review_post']['like'] == 1)?'Like':'Dislike';
                        $allPost[$key]['review_spot'] = $value['review_post']['spot'];
                        $allPost[$key]['review_spot']['images'] = $value['review_post']['spot_detail_photos'];
                        $allPost[$key]['review_spot']['videos'] = $value['review_post']['spot_detail_videos'];
                    }
                }

            }
        }
        // echo "<pre>";
        // print_r($allPost);
        // exit();
        return $allPost;
    }
}
