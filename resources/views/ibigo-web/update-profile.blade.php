@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | '.$user[0]['first_name']. ' '.$user[0]['last_name'])
@section('content')

    <div class="page-content">
        <div class="container">
            <div class="card card-style shadow-profile-card bg-6" data-card-height="50vh" style="background-image: url(@if($user[0]['user_cover']){{asset('storage/images/user/cover/'.$user[0]['user_cover'])}}@else{{asset('ibigo-web/images/empty.png')}}@endif);">

                <div class="card-top">


                    <div class="upload-btn-wrapper-2 mt-3">
                        <form id="imageUploadForm" enctype="multipart/form-data" action="{{url('/upload-cover')}}" method="post">
                            @csrf
                            <label class="btn-2 cover" for="btn"><input id="btn" type="file" name="user_cover" /><i class="fas fa-pen mx-1"></i>Edit</label>
                            <button class="btn-2 upload-btn" type="submit">Upload</button>
                        </form>
                    </div>
                </div>
                <div class="card-bottom ml-3 mr-3">

                    <h1 class="font-40 line-height-xl color-white">{{$user[0]['first_name']}}<br>
                    {{$user[0]['last_name']}}</h1>
                    <p class="color-white opacity-60"><i class="fas fa-user-alt mr-2"></i>{{$user[0]['age']}} yr. Zwolle</p>
                    <p class="color-white opacity-80 font-15 mb-3">
                        {{$user[0]['user_about']}}
                    </p>

                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <div class="card card-style">
                <div class="content mb-4">
                    <div class="row mb-0 text-center">
                        <div class="col-6">
                            <h1 class="mb-n1">{{$user[0]['friends_count']}}</h1>
                            <a href="friends.html" class=" font-12" style="color:gray;">Vrienden</a>
                        </div>
                        <div class="col-6">
                            <h1 class="mb-n1">{{$user[0]['review_count']}}</h1>
                            <p class="font-10 mb-0 pb-0">Reviews</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mb-4 mt-4">
                    <h2>About Me</h2>
                    <p>{{$user[0]['user_about']}}</p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mb-3 mt-3">
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
            <div class="card card-style">
                <div class="content mb-3 mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <h4>Favoriete Plek</h4>
                                <p class="ml-auto">Alles zien</p>
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
                            <div class="d-flex">
                                <h4>Spot Reviewd</h4>
                               <a href="shadow user profile-reviews.html" class="ml-auto"><p class="ml-auto"> Alles bekijken Review</p></a>
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



        </div>
        </div>
        <!-- Page content ends here-->


    </div>

    @endsection
