@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Spot | '.$spot[0]['business_name'])
@section('content')
    <div class="page-content">
        <div class="container">
            <div class="card card-style bg-6 mt-5" data-card-height="50vh"
                style="background-image: url(@if($spot[0]['user_spot']['user_cover']){{asset('storage/images/user/cover/'.$spot[0]['user_spot']['user_cover'])}}@else{{asset('ibigo-web/images/group-bg.png')}}@endif);">
                <div class="card-top">


                </div>
                <div class="card-bottom ml-3 mr-3">

                    <h1 class="font-40 line-height-xl color-white">{{$spot[0]['business_name']}}</h1>
                    @if($spot[0]['rating'])<p class="color-secondary">Ratings: {{$spot[0]['rating']}}</p>@endif
                    <a href="{{url('https://www.google.com/maps/@'.$spot[0]['latitude'].','.$spot[0]['longitude'])}}" target="_blank">
                        <div class="d-flex mt-4 mb-4 ">
                            <i class="fas fa-map-marker-alt color-magenta-dark pt-1 profile-location"></i>
                            <p class="mx-2 color-magenta-dark profile-location">{{$spot[0]['full_address']}}</p>
                        </div>
                    </a>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <div class="card card-style">
                <div class="content mb-4">
                    <div class="row mb-0 text-center">
                        <div class="col-6">
                            <h1 class="mb-n1">{{$spot[0]['review_count']}}</h1>
                            <a href="friends.html" class=" font-12" style="color:gray;">Review</a>
                        </div>
                        <div class="col-6">
                            <div></div>
                            <h1 class="mb-n1">{{$spot[0]['connected_count']}}</h1>
                            <p class="font-10 mb-0 pb-0">Connected</p>
                        </div>
                        <div class="divider divider-margins mt-3 mb-2"></div>

                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <a href="#" data-menu="menu-share"
                                class="btn mb-3 rounded-sm btn-lg bg-magenta-dark font-16" style="width: 100%;">GO</a>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <a href="#" data-menu="menu-call" class="btn rounded-sm mb-3 btn-lg bg-magenta-dark font-16"
                                style="width: 100%;"><i class="fas fa-thumbs-up mx-2"></i>Add Review</a>
                        </div>
                        <div class=" col-sm-12 col-lg-3 ">
                            <a href="{{url('/like-spot/'.$spot[0]['id'])}}" class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark mb-3">
                                @if(!$spot[0]['like_connected'] || $spot[0]['like_connected'][0]['like'] == NULL || $spot[0]['like_connected'][0]['like'] == 0)
                                <i class="far fa-heart"></i>
                                <span>Liked it</span>
                                @else
                                <i class="fas fa-heart"></i>
                                <span>Liked</span>
                                @endif

                            </a>
                            <a style="display: none;"
                                class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark mb-3">
                            </a>
                        </div>
                        <div class="col-sm-12 col-lg-3 ">
                            <a class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark mb-3" href=""
                                style="width: 100%;" data-menu="menu-cart-item">
                                <i class="fas fa-plus"></i>
                                <span>Photos/Videos</span></a>
                        </div>
                        <div class=" col-sm-12 col-lg-3 mt-3">
                            <a href="{{url('/connected-spot/'.$spot[0]['id'])}}" class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark mb-3 Connected">
                                @if(!$spot[0]['like_connected'] || $spot[0]['like_connected'][0]['connected'] == NULL || $spot[0]['like_connected'][0]['connected'] == 0)
                                <i class="fas fa-link"></i>
                                <span>Connect</span>
                                @else
                                <i class="fas fa-link"></i>
                                <span>Connected</span>
                                @endif    
                            </a>
                        </div>
                        <div class=" col-sm-12 col-lg-3 mt-3">
                            <a class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark " href=""
                                data-menu="menu-share-thumbs">
                                <i class="fas fa-car"></i>
                                <span>Parking</span></a>
                        </div>
                    </div>
                </div>

            </div>


            <div class="card card-style">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="content ">
                            <h2>About Me</h2>
                            <p>{{$spot[0]['short_description']}}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 ">
                        <h1 class="mt-3 mb-3 mx-3">Categorieen</h1>
                        @if($spot[0]['user_spot']['user_interests'])
                            @foreach($spot[0]['user_spot']['user_interests'] as $interest)
                            <a href="#" class="btn  btn-xl btn-  rounded-xl text-uppercase  shadow-s color-black mx-2">
                                <p class="font-10">{{$interest['title']}}</p>
                            </a>
                            @endforeach
                        @endif
                    </div>


                </div>
            </div>
            <div class="card card-style">
                <div class="content mb-3 mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex justify-content-between">
                                <h4>Door Vrienden geliked</h4>
                                <p>Alles zien</p>
                            </div>

                            @if($spot[0]['likes_spot'])
                                <div class="row mt-4">
                                    @foreach($spot[0]['likes_spot'] as $likeSpot)
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                            <a href="{{url('/people/'.$likeSpot['user']['unique_id'].'/'.$likeSpot['user']['user_slug'])}}" class="color-black m-auto text-center">
                                                <div>
                                                    @if($likeSpot['user']['user_profile'])
                                                        <img src="{{asset('storage/images/user/profile/'.$likeSpot['user']['user_profile'])}}" width="100" height="100" class="rounded-circle">
                                                    @else
                                                        <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="100" height="100" class="rounded-circle">
                                                    @endif
                                                </div>
                                                <p>{{$likeSpot['user']['fullname']}}</p>
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
                                <h4>Aantal reviews</h4>
                                <a href="{{url('/spot-review/'.$spot[0]['user_spot']['unique_id'].'/'.$spot[0]['user_spot']['user_slug'])}}">
                                    <p> Alles bekijken Review</p>
                                </a>
                            </div>

                            @if($spot[0]['reviews'])
                                <div class="row mt-4">
                                    @foreach($spot[0]['reviews'] as $reviewSpot)
                                        <div class="col-lg-3 col-md-2 col-sm-3 col-6 position-relative">
                                            <div class="btn-success rounded p-1 rating-btn" style="position: absolute;top: 45%;right:5%;z-index:1;">
                                                <p class="text-light font-weight-bold">{{$reviewSpot['rating']}}</p>
                                            </div>
                                            <a href="{{url('/people/'.$reviewSpot['user']['unique_id'].'/'.$reviewSpot['user']['user_slug'])}}" class="color-black m-auto text-center">
                                                <div>
                                                    @if($reviewSpot['user']['user_profile'])
                                                        <img src="{{asset('storage/images/user/profile/'.$reviewSpot['user']['user_profile'])}}" width="100" height="100" class="rounded-circle">
                                                    @else
                                                        <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="100" height="100" class="rounded-circle">
                                                    @endif
                                                </div>
                                                <p>{{$reviewSpot['user']['fullname']}}</p>
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
                        data-tab-active="color-red-dark border-tab border-red-dark"><a
                            class="color-red-dark border-tab border-red-dark no-click" data-tab="foto"
                            data-tab-active="" href="javascript:void(0)">Foto's</a><a data-tab="videos"
                            href="javascript:void(0)" class="">Videos</a></div>
                    <div class="clearfix mb-3"></div>
                    <div class="tab-content w-100" id="foto" style="display: block;">
                        <div class="col-lg-12 spot-gallery-img">
                                <p class="text-center font-18">No Foto's</p>
                        </div>
                    </div>
                    <div class="tab-content w-100" id="videos" style="display: none;">
                        <div class="col-lg-12 spot-gallery-img">
                                <p class="text-center font-18">No Videos</p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-style bg-theme pb-0 spot-text1-profile2">
                <div class="content">
                    <div class="tab-controls tab-animated tabs-medium tabs-no-border shadow-xl"
                        data-tab-active="color-red-dark border-tab border-red-dark"><a
                            class="color-red-dark border-tab border-red-dark no-click" data-tab="foto_by_user"
                            data-tab-active="" href="javascript:void(0)">Foto's by user</a><a data-tab="videos_by_user"
                            href="javascript:void(0)" class="">Videos</a></div>
                    <div class="clearfix mb-3"></div>
                    <div class="tab-content w-100" id="foto_by_user" style="display: block;">
                        <div class="col-lg-12 spot-gallery-img">
                            @if($spot[0]['spot_detail'])
                                <div class="row">
                                    @foreach($spot[0]['spot_detail'] as $key =>$photoVideos)
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

                    <div class="tab-content w-100" id="videos_by_user" style="display: none;">
                        <div class="col-lg-12 spot-gallery-img">
                            @if($spot[0]['spot_detail'])
                                <div class="row">
                                    @foreach($spot[0]['spot_detail'] as $key =>$photoVideos)
                                        @if($photoVideos['spot_detail_videos'])
                                            @foreach($photoVideos['spot_detail_videos'] as $key =>$videos)
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                                                    <video controls style="height:auto !important;">
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

    <!-- Main Menu-->
    <div id="menu-call" class="menu menu-box-modal rounded-m " data-menu-height="650" data-menu-width="350"
        style="display: block; height: 330px; width: 350px;">
        <div class="menu-title">
            <p class="color-magenta-dark">Beoordeling Spot</p>
            <h1>BARACCA</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            <hr>
        </div>
        <div class="content">
            <div class="text-center">
                <div style="background-image: url({{asset('ibigo-web/images/baracca.jpg')}}); width: 100px; height: 100px;"
                    class=" home-img rounded-sm shadow-xl m-auto "></div>
            </div>
            <div class="input-style input-style-1 input-required">
                <span class="color-highlight input-style-1-inactive">Vertal je ervaring</span>
                <em>(required)</em>
                <textarea placeholder="Vertal je ervaring"></textarea>
                <h2>Beoordeel uw ervaring!</h2>


            </div>
            <div class='rating-widget'>

                <!-- Rating Stars Box -->
                <div class='rating-stars text-center'>
                    <ul id='stars'>
                        <li class='star' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                    </ul>
                </div>
            </div>
            <h2>Upload afbeelding en video</h2>
            <div class="d-flex">
                <div class="upload-btn-wrapper-3">
                    <button class="btn-3"><i class="fas fa-file-upload"></i></button>
                    <input type="file" name="myfile" />
                </div>
                <div class="upload-btn-wrapper-3 mx-2">
                    <button class="btn-3"><i class="fas fa-microphone"></i></button>
                    <input type="file" name="myfile" />
                </div>
            </div>
            <a href="#" data-menu="menu-success-2">
               <button class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark mt-4">Delen</button></a>
        </div>
    </div>
    <div id="menu-success-2" class="menu menu-box-bottom rounded-m " data-menu-height="185" data-menu-effect="menu-over"
        style="height: 185px; display: block;">
        <div class="menu-title">
            <i class="fa fa-check-circle scale-box float-left mr-3 ml-3 fa-4x color-green-dark"></i>
            <p class="color-magenta-dark">Review Saved</p>
            <h1>Success</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

    </div>
    <div id="menu-cart-item" class="menu menu-box-modal rounded-m bg-theme " data-menu-width="350"
        data-menu-height="300" style="height: 400px; width: 350px; display: block;">
        <div class="menu-title">
            <p class="color-magenta-dark">Upload afbeelding en video </p>
            <h1 class="font-800">BARACCA</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="divider mb-3"></div>

        <div class="content">
            <div class="upload-btn-wrapper-3 ">
                <button class="btn-3"><i class="fas fa-file-upload"></i></button>
                <input type="file" name="myfile" />
            </div>
        </div>
        <a href="#" data-menu="menu-success-3">
           <button class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark mt-4">Upload</button></a>
    </div>
    <div id="menu-success-3" class="menu menu-box-bottom rounded-m " data-menu-height="185" data-menu-effect="menu-over"
        style="height: 185px; display: block;">
        <div class="menu-title">
            <i class="fa fa-check-circle scale-box float-left mr-3 ml-3 fa-4x color-green-dark"></i>
            <p class="color-magenta-dark">Photo/Video added</p>
            <h1>Success</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

    </div>
    <!-- Share Menu-->


    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
        data-menu-height="480"></div>


    </div>
    <div id="menu-option-2" class="menu menu-box-modal rounded-m   options" data-menu-height="220" data-menu-width="500"
        style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">
            <h1 class="color-black font-20">Go To List</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="divider mb-3"></div>
            <p class="pr-3">
                Do you want to add this spot in go to list ?
            </p>
            <div class="divider mb-3"></div>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-magenta-dark font-600 rounded-s ml-auto "
                        style="width: 100px;">YES</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-red-dark font-600 rounded-s "
                        style="width: 100px;">NO</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-option-3" class="menu menu-box-modal rounded-m  options" data-menu-height="220" data-menu-width="500"
        style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">
            <h1 class="color-black font-20">Add To Plannings</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="divider mb-3"></div>
            <p class="pr-3">
                Do you want to this event to planning?
            </p>
            <div class="divider mb-3"></div>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-magenta-dark font-600 rounded-s ml-auto "
                        style="width: 100px;">YES</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-red-dark font-600 rounded-s "
                        style="width: 100px;">NO</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-option-4" class="menu menu-box-modal rounded-m   options" data-menu-height="180" data-menu-width="500"
        style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">
            <h1 class="color-black font-20">Share Spots</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="divider mb-3"></div>
            <div class="input-style input-style-2 input-required">

                <em><i class="fas fa-caret-down"></i></em>
                <select class="form-control">
                    <option value="default" disabled="" selected="">[Share With]</option>
                    <option value="iOS">Friends</option>
                    <option value="Linux">Groups</option>

                </select>
            </div>
            <div class="divider mb-3"></div>

        </div>
    </div>
    <div id="menu-share-thumbs" class="menu menu-box-modal rounded-m " data-menu-height="320" data-menu-width="350"
        style="height: 320px; width: 350px; display: block;">
        <div class="menu-title">
            <p class="color-magenta-dark">Instruction</p>
            <h1>Parking</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="divider divider-margins"></div>
        <div class="content">
            <p>Parkeergarage in de omgeving</p>
            <div class="divider divider-margins"></div>
            <a href="" class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark close-menu">close</a>
        </div>
    </div>
    <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html" data-menu-height="370">
        <div class="content">
            <div class="divider mb-3"></div>
            <a href="" class="d-flex mb-3" data-menu="menu-option-2">
                <div class="text-center">
                    <i class="fas fa fa-tasks font-12 pt-2 mt-2 bg-facebook  color-white shadow-l rounded-l"
                        style="width: 30px; height: 30px;"></i>

                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2 ">TO DO</h5>

                </div>
                <div class="align-self-center ml-auto font-40 color-black">

                </div>
            </a>
            <div class="divider mb-3"></div>
            <a href="" class="d-flex mb-3" data-menu="menu-option-3">
                <div class="text-center">
                    <i class="fa fa-plus font-12 bg-twitter color-white  mt-2 pt-2 shadow-l rounded-l"
                        style="width: 30px; height: 30px;"></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Add To Plannings</h5>

                </div>

                <div class="align-self-center ml-auto font-40 color-black">

                </div>
            </a>
            <div class="divider mb-3"></div>
            <a href="l" class="d-flex mb-3" data-menu="menu-option-4">
                <div class="text-center">
                    <i class="fa fa-share font-12  bg-linkedin color-white shadow-l rounded-l mt-2 pt-2"
                        style="width: 30px; height: 30px;"></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Delen</h5>

                </div>
                <div class="align-self-center ml-auto font-40 color-black">

                </div>
            </a>
            <div class="divider mb-3"></div>
            <a href="" class="d-flex mb-3" data-menu="menu-option-5">
                <div class="text-center">
                    <i class="fa fa-times font-12 pt-2 mt-2 bg-red-dark color-white shadow-l rounded-l"
                        style="width: 30px; height: 30px;"></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Close</h5>

                </div>
                <div class="align-self-center ml-auto font-40 color-black">

                </div>
            </a>

        </div>
    </div>
@endsection
