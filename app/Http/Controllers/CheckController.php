<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Interest;
use App\Models\User;
use App\Models\Spot;
use App\Models\SpotDetail;
use App\Models\Group;
use App\Models\GroupChat;
use App\Models\GoToList;
use App\Models\FriendRelation;
use App\Models\GroupUser;
use App\Models\Planning;
use App\Models\Chat;
use App\Models\EventInvite;
use App\Models\Post;
use App\Models\PostAudio;
use App\Models\PostImage;
use App\Models\PostStatus;
use App\Models\PostVideo;
use App\Models\Page;
use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Time\Time;
use Illuminate\Support\Str;

class CheckController extends Controller
{
    private $time;
    public function __construct(Time $time)
    {
        $this->time = $time;
        $this->middleware('auth');
    }

    public function getFriends($id)
    {
        $getUsers = FriendRelation::where(function ($query) use ($id){
            $query->where('to_user_id',$id)->orWhere('from_user_id',$id);
        })->where('relation_status',1)->get()->toArray();
        if($getUsers)
        {
            $user_id_array = [];
            foreach ($getUsers as $key) {
                array_push($user_id_array,$key['from_user_id']);
                array_push($user_id_array,$key['to_user_id']);
            }

            $user_id_array = array_unique($user_id_array);
            if (($key = array_search($id, $user_id_array)) !== false) {
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

            return $friends;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $friends = $this->getFriends($user->id);
        return view('ibigo-web/home',compact('friends'));
    }

    public function profile()
    {
        $user = Auth::user();
        $friends = $this->getFriends($user->id);
        $interest = Interest::where('status',1)->where(function ($query){
            $query->where('show_in',0)->orWhere('show_in',2);
        })->get();

        $notification = Notification::with([
            'fromUser','group','event','spot.userSpot','post'
        ])->where('to_user_id',$user->id)->orderBy('id','DESC')->get()->toArray();
        if($notification)
        {
            foreach($notification as $key => $value)
            {
                $notification[$key]['how_long'] = Carbon::parse($value['created_at'])->diffForHumans();
            }
        }
        // echo "<pre>";
        // print_r($notification);
        // exit();
        return view('ibigo-web/profile', compact('user','interest','notification','friends'));
    }


    public function updateProfile()
    {
        $auth = Auth::user();
        $user = $this->user($auth->unique_id,$auth->user_slug);
        // echo "<pre>";
        // print_r($user);
        // exit();
        return view('ibigo-web/update-profile',compact('user'));
    }

    public function testing($id,$slug)
    {

        $event = Event::with(['user','eventInvites.user','connectedPeople'])
        ->where('event_unique_id',$id)
        ->where('event_slug',$slug)
        ->get()->toArray();

        if($event)
        {
            $event[0]['start_date_time'] = Carbon::parse($event[0]['start_date_time'])->format('M d,Y, h:i:s A');
            $event[0]['end_date_time'] = Carbon::parse($event[0]['end_date_time'])->format('M d,Y, h:i:s A');
            $event[0]['connect_count'] = count($event[0]['connected_people']);
        }

     //echo '<pre>'; print_r($event); echo '</pre>'; die('--- CALL ---');

        return view('ibigo-web/single-event',compact('event'));
    }

    public function user($id,$slug)
    {
        $user = User::with([
            'likeSpot.spot.userSpot',
            'reviewSpot.spot.userSpot',
            'photosVideos.spotDetailPhotos',
            'photosVideos.spotDetailVideos',
        ])->where('unique_id',$id)->where('user_slug',$slug)->get()->toArray();

        $user_interests = explode(',',$user[0]['user_interests']);
        $interest = Interest::select(['id','title','image'])->whereIn('id',$user_interests)->get()->toArray();
        $user[0]['user_interests'] = $interest;

        $friends = $this->getFriends($user[0]['id']);
        if($user[0]['review_spot'])
        {
            $user[0]['review_count'] = count($user[0]['review_spot']);
        }
        else{
            $user[0]['review_count'] = 0;
        }
        if($friends)
        {
            $user[0]['friends_count'] = count($friends);
        }
        else{
            $user[0]['friends_count'] = 0;
        }
        if($user[0]['birth_date'])
        {
            $user[0]['age'] = Carbon::parse($user[0]['birth_date'])->diff(Carbon::now())->y;
        }
        else{
            $user[0]['age'] = '';
        }

        return $user;
    }

    public function friendRelation($auth,$user)
    {
        $friends = FriendRelation::where(function ($q) use ($auth,$user){
            $q->where('from_user_id',$auth)
            ->where('to_user_id',$user);
        })
        ->orWhere(function ($q2) use ($auth,$user){
            $q2->where('from_user_id',$user)
            ->where('to_user_id',$auth);
        })->get()->toArray();
        return $friends;
    }

    public function people($id,$slug)
    {
        $auth = Auth::user();
        $user = $this->user($id,$slug);
        $friends = $this->friendRelation($auth->id,$user[0]['id']);
        // echo "<pre>";
        // print_r($friends);
        // exit();
        return view('ibigo-web/people',compact('user','friends'));
    }

    public function userReview($id,$slug)
    {
        $user = User::with(['reviewSpotsAll.spot.userSpot'])
        ->where('unique_id',$id)->where('user_slug',$slug)->get()->toArray();

        if($user[0]['birth_date'])
        {
            $user[0]['age'] = Carbon::parse($user[0]['birth_date'])->diff(Carbon::now())->y;
        }
        if($user[0]['review_spots_all'])
        {
            foreach($user[0]['review_spots_all'] as $key => $reviewSpot)
            {
                $user[0]['review_spots_all'][$key]['date_time'] = Carbon::parse($reviewSpot['created_at'])->format('M, d Y H:i A');
            }
        }
        // echo "<pre>";
        // print_r($user);
        // exit();
        return view('ibigo-web/user-review',compact('user'));
    }

    public function chat()
    {
        $user = Auth::user();
        if($user)
        {
            $chatFriends = [];
            $friends = $this->getFriends($user->id);
            if($friends)
            {
                foreach ($friends as $key => $value) {
                    $recent = Chat::where(function ($query1) use ($value){
                        $query1->where('to_user_id',$value['id'])->orWhere('from_user_id',$value['id']);
                    })
                    ->orderBy('created_at','DESC')
                    ->get()
                    ->unique('to_user_id')
                    ->groupBy('to_user_id')->groupBy('from_user_id')
                    ->toArray();

                    $readOrNot = Chat::where('from_user_id',$value['id'])
                    ->where('to_user_id',$user->id)
                    ->where('is_read',0)
                    ->get()->toArray();

                    $friends[$key]['message'] = '';
                    foreach ($recent as $key2 => $value2) {
                        $friends[$key]['message'] = $value2[0][0]['message'];
                        // echo "<pre>";
                        // print_r($value2);
                    }
                    $friends[$key]['count'] = count($readOrNot);
                    if($friends[$key]['message'] != null || $friends[$key]['message'] != '') 
                    {
                        $chatFriends[$key]['id'] = $friends[$key]['id'];
                        $chatFriends[$key]['unique_id'] = $friends[$key]['unique_id'];
                        $chatFriends[$key]['user_slug'] = $friends[$key]['user_slug'];
                        $chatFriends[$key]['fullname'] = $friends[$key]['fullname'];
                        $chatFriends[$key]['user_status'] = $friends[$key]['user_status'];
                        $chatFriends[$key]['user_profile'] = $friends[$key]['user_profile'];
                        $chatFriends[$key]['message'] =  Str::words($friends[$key]['message'], 8, ' ...');
                        $chatFriends[$key]['count'] = $friends[$key]['count'];
                    }
                }
            }
            // echo "<pre>";
            // print_r($chatFriends);
            // exit();
        }
        return view('ibigo-web/chats',compact('friends','chatFriends'));
    }


    public function search()
    {
        return view('ibigo-web/search');
    }


    public function mobile()
    {
        return view('ibigo-web/mobile');
    }

    public function singleGroup($id,$slug)
    {
        $group = Group::with([
            'requestedUser.user',
            'groupUsers.user',
            'post.userPost',
            'post.postImages',
            'post.postVideos',
            'post.postAudios',
            'post.postLike',
            'post.postComment.user'
        ])->where('group_unique_id', $id)->where('group_slug',$slug)->get()->toArray();
        $group[0]['group_users_count'] = 0;
        if($group[0]['group_users'])
        {
            $group[0]['group_users_count'] = count($group[0]['group_users']);
        }

        if($group[0]['post'])
        {
            foreach($group[0]['post'] as $key => $value)
            {
                $current = strtotime( $value['created_at'] );
                $group[0]['post'][$key]['time'] = $this->time->timePrevious($current);
            }
        }

        // echo "<pre>";
        // print_r($group);
        // exit();

        return view('ibigo-web/single-group',compact('group'));
    }

    public function makeRejectMember(Request $request, $id)
    {
        $groupUser = GroupUser::where('group_id',$id)->where('user_id',$request->user_id)->get()->toArray();
        // echo "<pre>";
        // print_r($groupUser);
        // exit();
        if($groupUser)
        {
            $makeMember = GroupUser::find($groupUser[0]['id']);
            $makeMember->group_status = $request->status;
            $makeMember->save();
        }
        return redirect()->back();
    }

    public function plan()
    {
        $user = Auth::user();
        $routeName = request()->route()->uri;
        $friends = $this->getFriends($user->id);
        $goToList = GoToList::with(['spot.userSpot','spot.likeSpot.user'])
        ->where('user_id',$user->id)
        ->get()->toArray();
        if($goToList)
        {
            foreach($goToList as $key =>$value)
            {

                $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                ->where('spot_id',$value['spot']['id'])->get()->toArray();
                $avg_rating = null;
                if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                    $avg_rating = 0;
                }else{
                    $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                }
                $goToList[$key]['spot']['rating'] = $avg_rating;
            }
        }

        $planning = Planning::with(['spot.userSpot','event'])
        ->where('user_id',$user->id)
        ->where('start_date_time','>=',now())
        ->orderBy('id','DESC')
        ->get()->toArray();

        if($planning)
        {
            foreach ($planning as $key => $plannings)
            {
                $planning[$key]['start_date'] = Carbon::parse($plannings['start_date_time'])->format('M d,Y');
                if($plannings['end_date_time'])
                {
                    $planning[$key]['end_date'] = Carbon::parse($plannings['end_date_time'])->format('M d,Y');
                }
                else{
                    $planning[$key]['end_date'] = '';
                }
                $planning[$key]['day'] = Carbon::parse($plannings['start_date_time'])->format('D');
                $planning[$key]['date'] = Carbon::parse($plannings['start_date_time'])->format('d');
            }
        }

        $likeConnected = Spot::select([
            'id',
            'user_id',
            'business_name',
        ])
        ->with(['userSpot'])
        ->whereHas('spotDetail',function ($query) use ($user){
            $query->where('user_id',$user->id)->where(function ($query2){
                $query2->where('like',1)->orWhere('connected',1);
            });
        })
        ->get()->toArray();

        $spot = Spot::select([
            'id',
            'user_id',
            'business_name',
        ])
        ->with(['userSpot'])
        ->whereHas('spotDetail',function ($query) use ($user){
            $query->where('user_id',$user->id)->where(function ($query2){
                $query2->where('like',0)->where('connected',0);
            });
        })->orWhereDoesntHave('spotDetail')
        ->get()->toArray();

        $event = Event::with(['user'])->where('user_id',$user->id)
        ->orWhereHas('eventInvites',function ($query) use ($user){
            $query->where('user_id',$user->id);
        })
        ->where('start_date_time','>',now())
        ->get()->toArray();
        // echo "<pre>";
        // print_r($spot);
        // exit();
        return view('ibigo-web/plans',compact('routeName','goToList','planning','friends','spot','likeConnected','event'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createGroup(Request $request)
    {

        $id = Auth::id();


        $group = new Group;
        $group->user_id = $id;
        $group->group_name = $request->group_name;
        $group->group_slug = Str::slug($request->group_name, '-');
        $group->group_unique_id = Str::uuid();

        if ($request->hasFile('group_cover')) {
            $destination1 = 'public/images/group/group_cover';
            $image1 = $request->file('group_cover');
            $cover = time() . rand(1, 1000) . $image1->getClientOriginalName();
            $path1 = $image1->storeAs($destination1, $cover);
            $group->group_cover = $cover;
        }

        if ($request->hasFile('group_profile')) {
            $destination2 = 'public/images/group/group_profile';
            $image2 = $request->file('group_profile');
            $profile = time() . rand(1, 1000) . $image2->getClientOriginalName();
            $path2 = $image2->storeAs($destination2, $profile);
            $group->group_profile = $profile;
        }
        $group->save();


        if ($request->tagged_user_id) {
            foreach ($request->tagged_user_id as $users) {
                $groupUser = new GroupUser;
                $groupUser->user_id =  $users;
                $groupUser->group_id =  $group->id;
                $groupUser->invited_by =  $id;
                $groupUser->group_status =  0;
                $groupUser->is_admin =  "Member";
                $groupUser->save();
            
                $noti = new Notification;
                $noti->from_user_id = $id;
                $noti->to_user_id = $users;
                $noti->invited_group_id = $group->id;
                $noti->notification_type = 'invite-in-group';
                $noti->notification_time = now();
                $noti->notification_read = 0;
                $noti->is_read = 0;
                $noti->save();
            }
        }

        if($request->admin_id)
        {
            $adminIds = [];
            foreach ($request->admin_id as $admin)
            {
                $adminIds[] = $admin;
            }
        }
        $adminIds[] = $id;
        if($adminIds)
        {
            foreach ($adminIds as $key => $ids)
            {
                $groupUser = new GroupUser;
                $groupUser->user_id =  $ids;
                $groupUser->group_id =  $group->id;
                $groupUser->invited_by =  $id;
                $groupUser->group_status =  ($ids === $id)?3:0;
                $groupUser->is_admin =  "Admin";
                $groupUser->save();
                if($ids != $id)
                {
                    $noti = new Notification;
                    $noti->from_user_id = $id;
                    $noti->to_user_id = $ids;
                    $noti->invited_group_id = $group->id;
                    $noti->notification_type = 'invite-in-group-as-an-admin';
                    $noti->notification_time = now();
                    $noti->notification_read = 0;
                    $noti->is_read = 0;
                    $noti->save();
                }
            }
        }


        return redirect('/groups')->with('success', 'Groups has been added successfully!');
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function friendsGroupsSpots(Request $request)
    {
        $user = Auth::user();
        $routeName = request()->route()->uri;

        $friends = $this->getFriends($user->id);

        $groups =  Group::whereHas('groupUsers',function ($query) use ($user) {
            $query->where('user_id',$user->id)->where('group_status',3);
        })->get();

        $spots = Spot::select([
            'id',
            'user_id',
            'business_name',
            DB::raw("CONCAT(street_no,' ',postal_code, ' ',city) AS full_address"),
            'latitude',
            'longitude',
            'short_description',
            'rating'
        ])
        ->with(['userSpot','spotDetail'])
        ->whereHas('spotDetail',function ($query) use ($user){
            $query->where('user_id',$user->id)->where(function ($query2){
                $query2->where('like',1)->orWhere('connected',1);
            });
        })
        ->get()->toArray();
        if($spots)
        {
            foreach ($spots as $key => $value) {
                if($value['spot_detail'])
                {
                    $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                    ->where('spot_id',$value['id'])->get()->toArray();
                    $avg_rating = null;
                    if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                        $avg_rating = 0;
                    }else{
                        $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                    }
                    $spots[$key]['rating'] = $avg_rating;

                    foreach ($value['spot_detail'] as $key2 => $spotDetail) {
                        $likeUser = SpotDetail::with(['user'])->where('spot_id',$spotDetail['spot_id'])->where('like',1)->get()->toArray();
                        $spots[$key]['spot_detail'] = $likeUser;
                    }
                }
            }
        }
        $event = Event::with(['user'])->where('user_id',$user->id)
        ->orWhereHas('eventInvites',function ($query) use ($user){
            $query->where('user_id',$user->id);
        })
        ->where('start_date_time','>',now())
        ->get()->toArray();

        if($event)
        {
            foreach ($event as $key => $events)
            {
                $event[$key]['start_date'] = Carbon::parse($events['start_date_time'])->format('d M');
                $event[$key]['start_time'] = Carbon::parse($events['start_date_time'])->format('h:i A');
                $event[$key]['end_date'] = Carbon::parse($events['end_date_time'])->format('d M');
                $event[$key]['end_time'] = Carbon::parse($events['end_date_time'])->format('h:i A');
                $event[$key]['day'] = Carbon::parse($events['start_date_time'])->format('D');
                $event[$key]['date'] = Carbon::parse($events['start_date_time'])->format('d');
            }
        }

        // echo "<pre>";
        // print_r($spots);
        // exit();
        return view('ibigo-web/friends',compact('friends','routeName','groups','spots','event'));
    }

    public function changeUserInterest(Request $request,$id){
        $auth = Auth::user();
        $user = User::where('id',$auth->id)->whereRaw('FIND_IN_SET(?,user_interests)', [$id])->get()->toArray();
        if($user)
        {
            $user_id_array = [];
            foreach (explode(',',$user[0]['user_interests']) as $key) {
                array_push($user_id_array,$key);
            }

            if (($key = array_search($id, $user_id_array)) !== false) {
                unset($user_id_array[$key]);
            }
            $newUser = User::find($auth->id);
            $newUser->user_interests = implode(',',$user_id_array);
            $newUser->save();
        }
        else{
            $user_id_array = [];
            array_push($user_id_array,$auth->user_interests);
            array_push($user_id_array,$id);
            $newUser = User::find($auth->id);
            $newUser->user_interests = implode(',',$user_id_array);
            $newUser->save();
        }
        return redirect()->back();
    }

    public function updateNotiStatus($id)
    {
        $noti = Notification::find($id);
        $noti->is_read = 1;
        $noti->save();
        return redirect()->back();
    }

    public function getSingleChat($id)
    {
        $user = Auth::user();
        if($user)
        {
            $chats = Chat::where(function ($query) use ($user,$id){
                $query->where('from_user_id',$user->id)->where('to_user_id',$id);
            })
            ->orWhere(function ($query2) use ($user,$id){
                $query2->where('from_user_id',$id)->where('to_user_id',$user->id);
            })
            ->get()->toArray();
            if($chats){
                $arr =[];
                foreach ($chats as $key => $value) {
                    $chats[$key]['message_time'] = Carbon::parse($value['message_date_time'])->format('h:m A');
                    // $chats[$key]['message_date'] = Carbon::parse($value['message_date_time'])->format('d M Y');
                    array_push($arr,Carbon::parse($value['message_date_time'])->format('d M Y'));
                }
                $arr = array_unique($arr);
                foreach ($arr as $key => $value) 
                {
                    $chats[$key]['message_date'] = $value;
                }
            }
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

    public function messageSend(Request $request)
    {
        $user = Auth::user();
        if($user)
        {
            $chat = new Chat;
            $chat->from_user_id = $user->id;
            $chat->to_user_id = $request->user_id;
            $chat->message = $request->message;
            $chat->message_date_time = Carbon::now();
            $chat->is_read = 0;
            $chat->save();

            $response['message'] = 'Message Sent!';
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

    public function uploadCover(Request $request)
    {
        $auth = Auth::user();
        if($auth)
        {
            $user = User::find($auth->id);
            if($request->hasFile('user_cover'))
            {
                $destination = 'public/images/user/cover';
                $image = $request->file('user_cover');
                $cover = Str::uuid().$image->getClientOriginalName();
                $path = $image->storeAs($destination, $cover);
                $user->user_cover = $cover;
                $user->save();
            }
            return redirect()->back();
        }
    }

    public function createEvent(Request $request)
    {
        $user = Auth::user();
        if($user)
        {
            $event = new Event;
            $event->event_title = $request->event_title;
            $event->event_slug = Str::slug($request->event_title,'-');
            $event->event_unique_id = Str::uuid();
            $event->start_date_time = new Carbon($request->start_date.$request->start_hours.$request->start_mins);
            $event->end_date_time = new Carbon($request->end_date.$request->end_hours.$request->end_mins);
            $event->event_location = $request->location;
            $event->event_description = $request->description;
            $event->user_id = $user->id;
            $event->save();

            if ($request->tagged_user_id) {
                foreach ($request->tagged_user_id as $users) {
                    $eventInvite = new EventInvite;
                    $eventInvite->user_id =  $users;
                    $eventInvite->event_id =  $event->id;
                    $eventInvite->save();
                
                    $noti = new Notification;
                    $noti->from_user_id = $user->id;
                    $noti->to_user_id = $users;
                    $noti->invited_event_id = $event->id;
                    $noti->notification_type = 'invite-in-event';
                    $noti->notification_time = now();
                    $noti->notification_read = 0;
                    $noti->is_read = 0;
                    $noti->save();
                }
            }

            if ($request->group_id) {
                foreach ($request->group_id as $group) {
                    $eventInvite = new EventInvite;
                    $eventInvite->group_id =  $group;
                    $eventInvite->event_id =  $event->id;
                    $eventInvite->save();
                
                    $noti = new Notification;
                    $noti->from_user_id = $user->id;
                    $noti->group_id = $group;
                    $noti->invited_event_id = $event->id;
                    $noti->notification_type = 'invite-in-event';
                    $noti->notification_time = now();
                    $noti->notification_read = 0;
                    $noti->is_read = 0;
                    $noti->save();
                }
            }

            return back()->with('success','Event Created Successfully');
        }
    }

    public function createGoTo(Request $request)
    {
        $user = Auth::user();
        if($user)
        {
            if($request->spot_id)
            {
                GoToList::where('user_id',$user->id)->delete();
                foreach($request->spot_id as $spotId)
                {
                    $goTo = new GoToList;
                    $goTo->user_id =  $user->id;
                    $goTo->spot_id = $spotId;
                    $goTo->is_liked = 0;
                    $goTo->save();
                }
            }
            return back()->with('success','Add Spot in Goto List Successfully');
        }
    }

    public function createPlan(Request $request)
    {
        $user = Auth::user();
        if($user)
        {
            $plan = new Planning;
            if($request->spot_id)
            {
                $plan->planning_title = $request->title;
                $plan->user_id = $user->id;
                $plan->spot_id = $request->spot_id;
                $plan->start_date_time = new Carbon($request->date_time);
            }
            else if($request->event_id)
            {
                $event = Event::find($request->event_id);
                $plan->planning_title = $event->event_title;
                $plan->planning_description = $event->event_description;
                $plan->user_id = $user->id;
                $plan->event_id = $request->event_id;
                $plan->start_date_time = $event->start_date_time;
                $plan->end_date_time = $event->end_date_time;
                // echo "<pre>";
                // print_r($event);
                // exit();
            }
            $plan->save();
            return back()->with('success','Plan successfully added!');
        }
    }

    public function spots() 
    {
        $spots = Spot::select([
            'id',
            'user_id',
            'business_name',
            'business_type',
            DB::raw("CONCAT(street_no,' ',postal_code, ' ',city) AS full_address"),
            'latitude',
            'longitude',
            'short_description',
            'rating'
        ])
        ->with(['userSpot','spotDetail'])
        ->get()->toArray();
        if($spots)
        {
            foreach ($spots as $key => $value) {
                if($value['spot_detail'])
                {
                    $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                    ->where('spot_id',$value['id'])->get()->toArray();
                    $avg_rating = null;
                    if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                        $avg_rating = 0;
                    }else{
                        $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                    }
                    $spots[$key]['rating'] = $avg_rating;

                    foreach ($value['spot_detail'] as $key2 => $spotDetail) {
                        $likeUser = SpotDetail::with(['user'])->where('spot_id',$spotDetail['spot_id'])->where('like',1)->get()->toArray();
                        $spots[$key]['spot_detail'] = $likeUser;
                    }
                }
            }
        }
        $interest = Interest::where('status', 1)->where(function($query){
            $query->where('show_in',0)->orWhere('show_in',2);
        })->get();
        // echo "<pre>";
        // print_r($spots);
        // exit();
        return view('ibigo-web/search',compact('spots','interest'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([

        'title' => 'required',
        'description' => 'required',
        ]);

        $post = new Post;
        $post->user_id = Auth::id();
        $post->spot_id = isset($request->spot_id) ? $request->spot_id : null;
        $post->group_id = isset($request->group_id) ? $request->group_id : null;
        $post->event_id = isset($request->event_id) ? $request->event_id : null;
        $post->title = isset($request->title) ? $request->title : null;
        $post->description = isset($request->description) ? $request->description : null;

        // $post->shared_group_id = $request->shared_group_id;
        // $post->shared_user_id = $request->shared_user_id;
        //$post->tagged_user_id = $request->tagged_user_id; // comma seperated
        $tagged_user_id = [];

        if ($request->tagged_user_id) {
            foreach ($request->tagged_user_id as $key => $tagged_user_ids) {
                $tagged_user_id[] = $tagged_user_ids;
            }
            $post->tagged_user_id = implode(',', $tagged_user_id);
        }

        $post->checkin_id = $request->checkin_id;
        $post->review_id = $request->review_id;
        $post->planning_id = $request->planning_id;
        $post->spot_review = $request->spot_review;

        $post->save();

        $post_id = $post->id;

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $photos) {
                $data = new PostImage;
                $data->post_id =  $post_id;
                $destination = 'public/images/post_image';
                $image_name = time() . rand(1, 1000) . $photos->getClientOriginalName();
                $path = $photos->storeAs($destination, $image_name);
                $data->post_images =  $image_name;
                $data->save();
            }
        }

        if ($request->hasFile('video')) {
            foreach ($request->video as $videos) {
                $data = new PostVideo;
                $data->post_id =  $post_id;
                $destination = 'public/videos/post/videos/video.mp4';
                $post_video = time() . rand(1, 1000) . $videos->getClientOriginalName();
                $path = $videos->storeAs($destination, $post_video);
                $data->post_videos =  $post_video;
                $data->save();
            }
        }

        if ($request->hasFile('audio')) {
            foreach ($request->audio as $audios) {
                $data = new PostAudio;
                $data->post_id =  $post_id;
                $destination = 'public/audios/post/audios/audio.mp3';
                $post_audio = time() . rand(1, 1000) . $audios->getClientOriginalName();
                $path = $audios->storeAs($destination, $post_audio);
                $data->post_audios =    $post_audio;
                $data->save();
            }
        }

        $data = new PostStatus;
        if($request->status == 1){
            $data->post_id =  $post_id;
            $data->user_id = null;
            $data->status = 1;
            $data->save();

        }else if($request->status == 2){
            if($request->user_id){
                foreach($request->user_id as $user_ids){
                    $data = new PostStatus;
                    $data->post_id =  $post_id;
                    $data->user_id = $user_ids;
                    $data->status = 2;
                    $data->save();
                }
            }
        }else{
            $data->post_id =  $post_id;
            $data->user_id = null;
            $data->status = 0;
            $data->save();
        }

        return redirect('/')->with('success', 'Post Save successfully!');

    }

    public function findFriends(Request $request)
    {
        $user = Auth::user();
        $friends = FriendRelation::where(function ($query) use ($user){
            $query->where('to_user_id',$user->id)->orWhere('from_user_id',$user->id);
        })
        ->where('relation_status',1)
        ->get();

        if($friends)
        {
            $user_id_array = [];
            foreach ($friends as $value) {
                array_push($user_id_array,$value['from_user_id']);
                array_push($user_id_array,$value['to_user_id']);
            }

            $user_id_array = array_unique($user_id_array);
            if (($key = array_search($user->id, $user_id_array)) !== false) {
                unset($user_id_array[$key]);
            }

            $friendUsers = User::select([
                'id',
                'user_profile',
                DB::raw("CONCAT(first_name,' ',last_name) AS fullname")
                ])
                ->whereIn('id',$user_id_array)
                ->where(function ($query) use ($request){
                    $query->where('first_name','LIKE','%'.$request->taggedUsers.'%')
                    ->orWhere('last_name','LIKE','%'.$request->taggedUsers.'%');
                })
                ->get()->toArray();

            $response = array(
                'status' => 'success',
                'friends' => $friendUsers,
            );
            return response()->json($response,201);
        }
    }


    public function searchInput(Request $request){

        $search = Spot::with(['userSpot'])->where('business_name','LIKE','%'.$request->search.'%')->select([
            'id',
            'user_id',
            'business_name',
            DB::raw("CONCAT(street_no ,' ',postal_code,' ',city) AS full_address"),
        ])->get()->toArray();
        $response = array(
            'status' => 'success',
            'data' => $search,
        );
        return response()->json($response,201);
    }

    public function findSpot($id)
    {

        $search = Spot::with(['userSpot','spotDetail.user'])->where('id',$id)->select([

            'id',
            'user_id',
            'business_name',
            'short_description',
            'rating',
        ])->get()->toArray();

        foreach($search as $key => $value)
        {
            $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
            ->where('spot_id',$value['id'])->get()->toArray();
            $avg_rating = null;
            if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                $avg_rating = 0;
            }else{
                $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
            }
            $search[$key]['rating'] = $avg_rating;
        }
        $response = array(
            'status' => 'success',
            'search' => $search,
        );
        return response()->json($response,201);
    }

    public function searchSpots(Request $request) 
    {
        $user_id = Auth::id();
        $search = $request->search;
        $spots = Spot::select([
            'id',
            'user_id',
            'business_name',
            'business_type',
            DB::raw("CONCAT(street_no,' ',postal_code, ' ',city) AS full_address"),
            'latitude',
            'longitude',
            'short_description',
            'rating'
        ])
        ->with(['userSpot','spotDetail.user'])
        ->where('business_name','like','%'.$search.'%')
        ->get()->toArray();
        if($spots)
        {
            foreach ($spots as $key => $value) {
                if($value['spot_detail'])
                {
                    $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
                    ->where('spot_id',$value['id'])->get()->toArray();
                    $avg_rating = null;
                    if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                        $avg_rating = 0;
                    }else{
                        $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
                    }
                    $spots[$key]['rating'] = $avg_rating;

                    foreach ($value['spot_detail'] as $key2 => $spotDetail) {
                        $likeUser = SpotDetail::with(['user'])->where('spot_id',$spotDetail['spot_id'])->where('like',1)->get()->toArray();
                        $spots[$key]['spot_detail'] = $likeUser;
                    }
                }
            }
        }
        $groups = Group::with(['members.user','groupStatus'])
        ->where('group_name','like','%'.$search.'%')
        ->get()->toArray();

        if($groups)
        {
            foreach ($groups as $key => $group)
            {
                $groups[$key]['member_count'] = count($group['members']) - 5;
            }
        }

        $users = User::with(['to','from'])
        ->where('id','!=',$user_id)
        ->where(function($query) use ($search){
            $query->where('first_name','like','%'.$search.'%')
            ->orWhere('last_name','like','%'.$search.'%');
        })
        ->where('user_type','normal')->get()->toArray();
        // echo "<pre>";
        // print_r($users);
        // exit();
        $response = array(
            'status' => 'success',
            'spots' => $spots,
            'groups' => $groups,
            'users' => $users
        );
        return response()->json($response,201);
    }

    public function spotReview($id,$slug)
    {
        $spot = Spot::select([
            'id',
            'user_id',
            'business_name',
            'latitude',
            'longitude',
            'short_description',
            'rating',
            DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")])
        ->with(['userSpot','ratings.user'])
        ->whereHas('userSpot',function ($query) use ($id,$slug){
            $query->where('unique_id',$id)->where('user_slug',$slug);
        })
        ->get()->toArray();

        if($spot)
        {
            $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
            ->where('spot_id',$spot[0]['id'])->get()->toArray();
            $avg_rating = null;
            if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                $avg_rating = 0;
            }else{
                $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
            }
            $spot[0]['rating'] = $avg_rating;
        }
        if($spot[0]['ratings'])
        {
            foreach($spot[0]['ratings'] as $key => $reviewSpot)
            {
                $spot[0]['ratings'][$key]['date_time'] = Carbon::parse($reviewSpot['created_at'])->format('M, d Y H:i A');
            }
        }

        return view('ibigo-web/spot-review',compact('spot'));
    }

    public function singleSpot($id,$slug)
    {
        $user = Auth::user();
        $spot = Spot::select([
            'id',
            'user_id',
            'business_name',
            'latitude',
            'longitude',
            'short_description',
            'rating',
            DB::raw("CONCAT(street_no,' ',postal_code,' ',city) AS full_address")
        ])->with(['userSpot',
            'spotDetail.user',
            'spotDetail.spotDetailPhotos',
            'spotDetail.spotDetailVideos',
            'reviews.user',
            'likesSpot.user',
            'connected',
        ])
        ->whereHas('userSpot',function ($query) use ($id,$slug){
            $query->where('unique_id',$id)->where('user_slug',$slug);
        })
        ->get()->toArray();

        if($spot)
        {
            $likeConnected = SpotDetail::where('spot_id',$spot[0]['id'])
            ->where('user_id',$user->id)
            ->select('like','connected')
            ->get()->toArray();

            $spot[0]['like_connected'] = $likeConnected;

            $rating = SpotDetail::select(DB::raw('sum(rating) as rating_sum'),DB::raw('count(id) as count_rating'))
            ->where('spot_id',$spot[0]['id'])->get()->toArray();
            $avg_rating = null;
            if ($rating[0]['rating_sum']==0 || $rating[0]['count_rating']==0) {
                $avg_rating = 0;
            }else{
                $avg_rating =  round($rating[0]['rating_sum']/$rating[0]['count_rating'], 1);
            }
            $spot[0]['rating'] = $avg_rating;
        }

        $user_interests = explode(',',$spot[0]['user_spot']['user_interests']);
        $interest = Interest::select(['id','title','image'])->whereIn('id',$user_interests)->get()->toArray();
        $spot[0]['user_spot']['user_interests'] = $interest;

        $spot[0]['review_count'] = count($spot[0]['reviews']);
        $spot[0]['connected_count'] = count($spot[0]['connected']);
        // echo "<pre>";
        // print_r($spot);
        // exit();
        return view('ibigo-web/single-spot',compact('spot'));
    }

    public function passwordStore(Request $request)
    {
        $user= Auth::user();
        $validate = $request->validate([
            'old_password' =>'required',
            'password' => 'required|string|max:30|min:8',
            'confirm_password'=>'required|string|max:30|min:8'
        ]);
        $data =  User::find($user->id);
        
        if(!Hash::check($request->old_password,$data->password)){
            return back()->with('error','The specified password does not match.');
        }
        else
        {
            if($request->password == $request->confirm_password)
            {
                $data->password = Hash::make($request->password);
                
                $data->save();
                return redirect('/profile')->with('success','Password changed Successfully.');
            }
            else
            {
                return back()->with('notmatch','Password is not matching');
            }
        }

    }

    public function updateUserProfile(Request $request, $id)
    {

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->user_about = $request->user_about;

            if ($request->hasFile('user_profile')) {
                $destination = 'public/images/user/profile';
                $image = $request->file('user_profile');
                $image_name = time() . rand(1, 1000) . $image->getClientOriginalName();
                $path = $image->storeAs($destination, $image_name);
                $user->user_profile = $image_name;
            }

        $user->save();
        return redirect()->back()->with('success', 'Your Profile has been Update!');
    }

    public function informationPages($id)
    {
        $page = Page::where('page_status',$id)->get();
        if($page)
        {
            $response['pages'] = $page;
            $response['status'] = true;
            $response['status_code'] = 201;
        }
        else {
            $response['message'] = 'No Page Information Found!';
            $response['status'] = false;
            $response['status_code'] = 400;
        }
        return response()->json($response);
    }

    public function pages($id,$slug)
    {
        $page = Page::where('page_unique_id',$id)->where('page_slug',$slug)->first();
        return view('ibigo-web/page',compact('page'));
    }

    public function notifications($auth,$id,$type)
    {
        $noti = Notification::where('from_user_id',$auth->id)
        ->where('to_user_id',$id)
        ->where('notification_type',$type)
        ->get()->toArray();

        if($noti)
        {
            Notification::destroy($noti[0]['id']);
        }

        if($type == 'accept-request')
        {
            Notification::where('from_user_id',$id)
            ->where('to_user_id',$auth->id)
            ->where('notification_type','friend-request')
            ->delete();
        }

        $notification = new Notification;
        $notification->from_user_id = $auth->id;
        $notification->to_user_id = $id;
        $notification->notification_type = $type;
        $notification->notification_time = now();
        $notification->notification_read = 0;
        $notification->is_read = 0;
        $notification->save();

        return $notification;
    }


    public function send($id)
    {
        $auth = Auth::user();
        $user = $this->friendRelation($auth->id,$id);
        
        if(!$user)
        {
            $send = new FriendRelation;
            $send->from_user_id = $auth->id;
            $send->to_user_id = $id;
            $send->relation_status = 0;
            $send->save();
            $this->notifications($auth,$id,'friend-request');
        }
        else if($user[0]['relation_status'] != 1)
        {
            $send = FriendRelation::find($user[0]['id']);
            $send->from_user_id = $auth->id;
            $send->to_user_id = $id;
            $send->relation_status = 0;
            $send->save();
            $this->notifications($auth,$id,'friend-request');
        }
        return back()->with('success','You send a request.');
    }



    public function accept($id)
    {
        $auth = Auth::user();
        $user = $this->friendRelation($auth->id,$id);
        
        if($user)
        {
            if($user[0]['relation_status'] == 0)
            {
                $this->notifications($auth,$id,'accept-request');
                $send = FriendRelation::find($user[0]['id']);
                $send->relation_status = 1;
                $send->save();
            }
        }
        return back()->with('success','You accept a request.');
    }

    public function reject($id)
    {
        $auth = Auth::user();
        $user = $this->friendRelation($auth->id,$id);

        if($user)
        {
            if($user[0]['relation_status'] == 0)
            {
                $this->notifications($auth,$id,'reject-request');

                $send = FriendRelation::find($user[0]['id']);
                $send->relation_status = 2;
                $send->save();
            }
        }
        return back()->with('success','You reject a request.');
    }

    public function unfriend($id)
    {
        $auth = Auth::user();
        $user = $this->friendRelation($auth->id,$id);

        if($user)
        {
            if($user[0]['relation_status'] == 1)
            {
                $send = FriendRelation::find($user[0]['id']);
                $send->relation_status = 3;
                $send->save();
            }
        }
        return back()->with('success','You unfriend the user.');
    }

    public function cancel($id)
    {
        $auth = Auth::user();
        $user = $this->friendRelation($auth->id,$id);

        if($user)
        {
            if($user[0]['relation_status'] == 0)
            {
                $send = FriendRelation::find($user[0]['id']);
                $send->relation_status = 3;
                $send->save();
            }
        }
        return back()->with('success','You cancel a request.');
    }

    public function likeSpot($id)
    {
        $user = Auth::user();
        $likeConnected = SpotDetail::where('spot_id',$id)
        ->where('user_id',$user->id)
        ->get()->toArray();
        if($likeConnected)
        {
            $like = SpotDetail::where('user_id',$user->id)->where('spot_id',$id)->first();
            if($likeConnected[0]['like'] == 0)
            {
                $like->like = 1;
            }
            else{
                $like->like = 0;
            }
        }
        else{
            $like = new SpotDetail;
            $like->user_id = $user->id;
            $like->spot_id = $id;
            $like->like = 1;
        }
        $like->save();
        $msg = '';
        if($like->like == 1)
        {
            $msg = 'like';
        }
        else{
            $msg = 'dislike';
        }
        return back()->with('success','You '.$msg.' this spot.');
    }

    public function connectedSpot($id)
    {
        $user = Auth::user();
        $likeConnected = SpotDetail::where('spot_id',$id)
        ->where('user_id',$user->id)
        ->get()->toArray();
        if($likeConnected)
        {
            $connected = SpotDetail::where('user_id',$user->id)->where('spot_id',$id)->first();
            if($likeConnected[0]['connected'] == 0)
            {
                $connected->connected = 1;
            }
            else{
                $connected->connected = 0;
            }
        }
        else{
            $connected = new SpotDetail;
            $connected->user_id = $user->id;
            $connected->spot_id = $id;
            $connected->connected = 1;
        }
        $connected->save();
        $msg = '';
        if($connected->connected == 1)
        {
            $msg = 'connected';
        }
        else{
            $msg = 'disconnect';
        }
        return back()->with('success','You '.$msg.' with this spot.');
    }

    public function groupChat()
    {
        $user = Auth::user();
        if($user)
        {
            $chatGroup = [];
            $groups =  Group::whereHas('groupUsers',function ($query) use ($user) {
                $query->where('user_id',$user->id)->where('group_status',3);
            })->get()->toArray();
            if($groups)
            {
                foreach ($groups as $key => $value) {
                    $recent = GroupChat::where('group_id',$value['id'])
                    ->orderBy('created_at','DESC')
                    ->get()
                    ->toArray();

                    $readOrNot = GroupChat::where('group_id',$value['id'])
                    ->where('is_read',0)
                    ->orWhere('is_read',NULL)
                    ->get()->toArray();

                    $groups[$key]['message'] = '';
                    if($recent)
                    {
                        $groups[$key]['message'] = $recent[0]['message'];
                    }
                    $groups[$key]['count'] = count($readOrNot);
                    if($groups[$key]['message'] != null || $groups[$key]['message'] != '') 
                    {
                        $chatGroup[$key]['id'] = $groups[$key]['id'];
                        $chatGroup[$key]['group_name'] = $groups[$key]['group_name'];
                        $chatGroup[$key]['group_profile'] = $groups[$key]['group_profile'];
                        $chatGroup[$key]['message'] =  Str::words($groups[$key]['message'], 8, ' ...');
                        $chatGroup[$key]['count'] = $groups[$key]['count'];
                    }
                }
            }
            // echo "<pre>";
            // print_r($groups);
            // exit();
        }
        return view('ibigo-web/group-chat',compact('groups','chatGroup'));
    }

    public function getSingleGroupChat($id)
    {
        $user = Auth::user();
        if($user)
        {
            $chats = GroupChat::with(['user'])->where('group_id',$id)
            ->get()->toArray();
            if($chats){
                $arr =[];
                foreach ($chats as $key => $value) {
                    $chats[$key]['message_time'] = Carbon::parse($value['message_date_time'])->format('h:m A');
                    // $chats[$key]['message_date'] = Carbon::parse($value['message_date_time'])->format('d M Y');
                    array_push($arr,Carbon::parse($value['message_date_time'])->format('d M Y'));
                }
                $arr = array_unique($arr);
                foreach ($arr as $key => $value) 
                {
                    $chats[$key]['message_date'] = $value;
                }
            }
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

    public function groupMessageSend(Request $request)
    {
        $user = Auth::user();
        if($user)
        {
            $chat = new GroupChat;
            $chat->group_id = $request->group_id;
            $chat->user_id = $user->id;
            $chat->message = $request->message;
            $chat->message_date_time = Carbon::now();
            $chat->is_read = 0;
            $chat->save();

            $response['message'] = 'Message Sent!';
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
    
}