@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | '.$user[0]['first_name'] .'  '. $user[0]['last_name'] )
@section('content')


    <div class="page-content">
        <div class="container">
            <div class="card card-style shadow-profile-card">
                <div class="content ">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h1>{{ $user[0]['first_name'] .'  '. $user[0]['last_name'] }}</h1>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <a href="#" data-menu="menu-cart-item" class="">
                                            <p class="text-center"><span class="font-weight-bold color-black">{{$user[0]['friends_count']}}</span> Vrienden</p>
                                        </a>
                                        <a href="#" class="mx-3">
                                            <p class="text-center"><span class="font-weight-bold color-black">{{$user[0]['review_count']}}</span> Review</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 m-auto">
                            @if($user[0]['user_profile'])
                                <div class="text-right">
                                    <img src="{{asset('storage/images/user/profile/'.$user[0]['user_profile'])}}" width="100" height="100" class="rounded-circle">
                                </div>
                            @else
                                <div class="text-right">
                                    <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="100" height="100" class="rounded-circle">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{url('/chat')}}" class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-900 shadow-s bg-magenta-dark">Chats</a>
                        </div>
                        <div class="col-lg-6">
                            @if(!$friends || $friends[0]['relation_status'] == 2 || $friends[0]['relation_status'] == 3)
                            <a href="#" data-menu="menu-option-1">
                                <button class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-900 shadow-s bg-magenta-dark"><i class="fas fa-user-plus mx-2"></i> Add Friend</button>
                            </a>
                            @elseif($friends[0]['relation_status'] == 0)
                            <a href="#" data-menu="menu-option-2">
                                <button class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-900 shadow-s bg-magenta-dark"><i class="fas fa-user-minus mx-2"></i> Cancel Request</button>
                            </a>
                            @elseif($friends[0]['relation_status'] == 1 )
                            <a href="#" data-menu="menu-option-3">
                                <button class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-900 shadow-s bg-magenta-dark"><i class="fas fa-user-times mx-2"></i> Unfriend</button>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="card card-style">
                <div class="content mb-4 mt-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                    <h2 class="mb-3">About Me</h2>
                    {{$user[0]['user_about']}}
                </div>
                <div class="col-lg-6 col-md-6">
                    <h2>Interesses</h2>
                    @if($user[0]['user_interests'])
                        <div class="row mt-4 mb-0">
                            @foreach($user[0]['user_interests'] as $interest)
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="card card-style p-2 text-center">
                                        {{$interest['title']}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                </div>
            </div>
        </div>

            <div class="card card-style">
                <div class="content mb-3 mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex justify-content-between">
                                <h4>Favoriete Plek</h4>
                                <p>Alles zien</p>
                            </div>

                            @if($user[0]['like_spot'])
                                <div class="row mt-4">
                                    @foreach($user[0]['like_spot'] as $likeSpot)
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                            <a href="{{url('/spots/'.$likeSpot['spot']['user_spot']['unique_id'].'/'.$likeSpot['spot']['user_spot']['user_slug'])}}" class="color-black m-auto text-center">
                                                <div>
                                                    @if(strpos($likeSpot['spot']['user_spot']['user_profile'], 'http') === 0)
                                                        <img src="{{$likeSpot['spot']['user_spot']['user_profile']}}" width="100" height="100" class="rounded-circle">
                                                    @else
                                                        <img src="{{asset('storage/images/user/profile/'.$likeSpot['spot']['user_spot']['user_profile'])}}" width="100" height="100" class="rounded-circle">
                                                    @endif
                                                </div>
                                                <p>{{$likeSpot['spot']['business_name']}}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="ng-star-inserted">Nee Favoriete Plek</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex justify-content-between">
                                <h4>Spot Reviewd</h4>
                                <a href="{{url('/user-review/'.$user[0]['unique_id'].'/'.$user[0]['user_slug'])}}">
                                    <p> Alles bekijken Review</p>
                                </a>
                            </div>

                            @if($user[0]['review_spot'])
                                <div class="row mt-4">
                                    @foreach($user[0]['review_spot'] as $reviewSpot)
                                        <div class="col-lg-3 col-md-2 col-sm-3 col-6 position-relative">
                                            <div class="btn-success rounded p-1 rating-btn" style="position: absolute;top: 45%;right:5%;z-index:1;">
                                                <p class="text-light font-weight-bold">{{$reviewSpot['rating']}}</p>
                                            </div>
                                            <a href="{{url('/spots/'.$reviewSpot['spot']['user_spot']['unique_id'].'/'.$reviewSpot['spot']['user_spot']['user_slug'])}}" class="color-black m-auto text-center">
                                                <div>
                                                    @if(strpos($reviewSpot['spot']['user_spot']['user_profile'], 'http') === 0)
                                                        <img src="{{$reviewSpot['spot']['user_spot']['user_profile']}}" width="100" height="100" class="rounded-circle">
                                                    @else
                                                        <img src="{{asset('storage/images/user/profile/'.$reviewSpot['spot']['user_spot']['user_profile'])}}" width="100" height="100" class="rounded-circle">
                                                    @endif
                                                </div>
                                                <p>{{$reviewSpot['spot']['business_name']}}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="ng-star-inserted">Nee reviewd</span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-style bg-theme pb-0 spot-text1-profile2">
                <div class="content">
                    <div class="tab-controls tab-animated tabs-medium tabs-no-border shadow-xl"
                        data-tab-active="color-red-dark border-tab border-red-dark">
                        <a class="color-red-dark border-tab border-red-dark no-click" data-tab="foto"
                            data-tab-active="" href="javascript:void(0)">Foto's</a>
                        <a data-tab="videos"
                            href="javascript:void(0)" class="">Videos</a>
                    </div>
                    <div class="clearfix mb-3"></div>
                    <div class="tab-content w-100" id="foto" style="display: block;">
                        <div class="col-lg-12 spot-gallery-img">
                            @if($user[0]['photos_videos'])
                                <div class="row">
                                    @foreach($user[0]['photos_videos'] as $key =>$photoVideos)
                                        @if($photoVideos['spot_detail_photos'])
                                            @foreach($photoVideos['spot_detail_photos'] as $key =>$photo)
                                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                                    <img src="{{asset('storage/images/review/images/'.$photo['review_photo'])}}" width="100" height="100">
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center font-18">No Foto's</p>
                            @endif



                        </div>
                    </div>
                    <div class="tab-content w-100" id="videos" style="display: none;">
                        <div class="col-lg-12 spot-gallery-img">
                            @if($user[0]['photos_videos'])
                                <div class="row">
                                    @foreach($user[0]['photos_videos'] as $key =>$photoVideos)
                                        @if($photoVideos['spot_detail_videos'])
                                            @foreach($photoVideos['spot_detail_videos'] as $key =>$videos)
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                                    <video controls style="height:120px !important;">
                                                        <source src="{{asset('storage/videos/review/videos/'.$videos['review_video'])}}">
                                                    </video>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center font-18">No Videos</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>




    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
        data-menu-height="480"></div>

        <div id="menu-cart-item" class="menu menu-box-modal rounded-m bg-theme " data-menu-width="200" data-menu-height="200" style="height: 400px; width: 350px; display: block;">
            <div class="menu-title">
                <p class="color-magenta-dark">Sinan Ros </p>
                <h1 class="font-800">Friends</h1>
                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            </div>



        </div>
    </div>
    <div id="menu-option-1" class="menu menu-box-modal rounded-m " data-menu-height="200" data-menu-width="350" style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">

            <p class="color-black font-18">Ibigo.nl says</p>


        </div>
        <div class="content mt-4">
            <p class="pr-3">
                Are you sure you want to send request {{$user[0]['first_name'] .' '. $user[0]['last_name']}} as your friend?
            </p>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="{{url('/send-request/'.$user[0]['id'])}}" class="btn bg-highlight font-600 rounded-s mx-5 cancel-req" style="width: 100px; height: 50px;">OK</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full   font-600 rounded-s cancel-req" style="background-color: gray; width: 100px; height: 50px;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-option-2" class="menu menu-box-modal rounded-m " data-menu-height="200" data-menu-width="350" style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">

            <p class="color-black font-18">Ibigo.nl says</p>


        </div>
        <div class="content mt-4">
            <p class="pr-3">
                Are you sure you want to cancel request {{$user[0]['first_name'] .' '. $user[0]['last_name']}} as your friend?
            </p>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="{{url('/cancel-request/'.$user[0]['id'])}}" class="btn bg-highlight font-600 rounded-s mx-5 cancel-req" style="width: 100px; height: 50px;">OK</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full   font-600 rounded-s cancel-req" style="background-color: gray; width: 100px; height: 50px;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-option-3" class="menu menu-box-modal rounded-m " data-menu-height="200" data-menu-width="350" style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">

            <p class="color-black font-18">Ibigo.nl says</p>


        </div>
        <div class="content mt-4">
            <p class="pr-3">
                Are you sure you want to remove {{$user[0]['first_name'] .' '. $user[0]['last_name']}} as your friend?
            </p>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="{{url('/unfriend/'.$user[0]['id'])}}" class="btn bg-highlight font-600 rounded-s mx-5 cancel-req" style="width: 100px; height: 50px;">OK</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full   font-600 rounded-s cancel-req" style="background-color: gray; width: 100px; height: 50px;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    @endsection
