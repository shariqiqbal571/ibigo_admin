@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Home')
@section('content')

    <div class="page-content mt-4">
        <div class="container">

            <div class="double-slider owl-carousel owl-no-dots owl-theme" id="owl-carousel">
                @if($interest)
                @foreach($interest as $interests)
                <div class="item">
                    <div data-card-height="220" class="card shadow-xl rounded-m bg-6">
                        <div class="card-bottom text-center">
                            <h4 class="color-white font-800 mb-3">{{$interests->title}}</h4>
                        </div>
                        <div style="width: 100%;  ">
                        @if($interests->image)
                        <img class="slider-img" src="{{asset('storage/images/interests/'.$interests->image)}}" alt="" height="250px"
                                width="100%">
                        @else
                        <img class="slider-img" src="{{asset('ibigo-web/images/empty.png')}}" alt="" height="250px"
                            width="100%">
                        @endif
                        </div>
                        <div class="card-overlay bg-gradient"></div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 ">
                                <a href="#" data-menu="menu-share-thumbs">
                                    <button class="btn btn-lg btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s mt-4 "
                                        style="background-image: url({{asset('ibigo-web/images/cinema.jpg')}})">ADD POST</button>
                                </a>

                            </div>
                            <div class="col-md-6 col-sm-12 ">
                                <a href="#" data-menu="menu-share-thumbs2">
                                    <button class="btn btn-lg btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s mt-4 "
                                        style="background-image: url({{asset('ibigo-web/images/cinema.jpg')}})">Check In</button>
                                </a>

                            </div>

                            <div class="col-sm-12 mt-5">
                                <div class="row">
                                    @if($post)
                                        @foreach($post as $posts)
                                            @if(!$posts['spot_id'] && !$posts['checkin_id'] && !$posts['planning_id'] && !$posts['review_id'])
                                                <div class="col-sm-12">
                                                    <div class="card card-style">
                                                        <div class="content">
                                                            <div class="d-flex">

                                                                <div class="mr-3">

                                                                    <a href="@if($posts['user_id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$posts['unique_id'].'/'.$posts['user_slug'])}} @endif">
                                                                        <div class=" home-img rounded-sm shadow-xl" style="
                                                                                background-image: url(@if($posts['user_profile']) {{asset('storage/images/user/profile/'.$posts['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif );
                                                                                width: 100px;
                                                                                height: 100px;"
                                                                                ></div>
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <p class=" font-500 mb-n1">{{$posts['how_long']}}</p>
                                                                    <div class="d-flex">
                                                                        <h2 class="mr-2 mb-0">{{$posts['fullname']}}</h2>
                                                                        @if($posts['share_with'] == 'People') 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                shared post with {{count($posts['status'])}} friends
                                                                            </button>
                                                                            @if($posts['status'])
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['status'] as $status)
                                                                                    @if($status['user'])
                                                                                        <a class="dropdown-item" href="@if($status['user']['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$status['user']['unique_id'].'/'.$status['user']['user_slug'])}} @endif">{{$status['user']['fullname']}}</a>
                                                                                    @endif 
                                                                                @endforeach
                                                                            </span>   
                                                                            @endif 
                                                                        </span>@endif
                                                                        @if($posts['share_with'] == 'People' && $posts['tagged_user'])
                                                                        <span> and </span>
                                                                        @endif
                                                                        @if($posts['tagged_user']) 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                tagged {{count($posts['status'])}} friends
                                                                            </button>
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['tagged_user'] as $user)
                                                                                        <a class="dropdown-item" href="@if($user['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$user['unique_id'].'/'.$user['user_slug'])}} @endif">{{$user['fullname']}}</a>
                                                                                @endforeach
                                                                            </span>
                                                                        </span>@endif
                                                                    </div>
                                                                    <h4 class="text-secondary text-capitalize">{{$posts['title']}}</h4>
                                                                    <p class="text-secondary">{{$posts['description']}}</p>
                                                                </div>
                                                                <a href="#" data-menu="menu-cart-item" class="color-black ml-auto">
                                                                    <i class="fas fa-ellipsis-v  font-20"></i>
                                                                </a>
                                                            </div>
                                                            <div class="d-flex mt-4 justify-content-between w-100 comment-parent">

                                                                <a class="text-dark btn heart" id="">
                                                                    <i id="" class="far fa-heart font-20 border-heart"></i>
                                                                    <div style="display: none;" class="filled-heart">
                                                                        <div class="d-flex">
                                                                            <i style="color: red;" class="fa fa-heart font-20"></i>
                                                                            <span class="ml-1 font-12 mt-1">You</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="text-dark btn comment-section">
                                                                    <i class="far fa-comment  font-20"></i>
                                                                </a>
                                                            </div>
                                                            @if($posts['post_audios'])
                                                                <div class="row mb-0" style="overflow: hidden; background-color:#fff;">
                                                                    @foreach($posts['post_audios'] as $audios)
                                                                        @if($audios['post_audios'])
                                                                            <div class="col-md-6 p-0">
                                                                                <div style="height:fit-content;background-color: #f1f3f4;">
                                                                                    <audio controls>
                                                                                        <source src="{{asset('storage/audios/post/audios/'.$audios['post_audios'])}}">
                                                                                    </audio>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            @if($posts['post_images'] || $posts['post_videos'])
                                                            <div id="carouselExampleControls{{$posts['id']}}" class="carousel slide bg-black"  data-ride="carousel" data-interval="false">
                                                                <div class="carousel-inner">
                                                                    @if($posts['post_images'])
                                                                        @foreach($posts['post_images'] as $images)
                                                                            @if($images['post_images'])
                                                                                <div class="carousel-item @if($posts['post_images'][0]['id'] == $images['id']) active @endif">
                                                                                    <img style="height:500px;" src="{{asset('storage/images/post/images/'.$images['post_images'])}}" class="d-block w-100" alt="Image has been deleted">
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    @if($posts['post_videos'])
                                                                        @foreach($posts['post_videos'] as $videos)
                                                                            @if($videos['post_videos'])
                                                                                <div class="carousel-item">
                                                                                    <video style="height:500px !important;" controls class="d-block w-100">
                                                                                        <source src="{{asset('storage/videos/post/videos/'.$videos['post_videos'])}}">
                                                                                    </video>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <button style="height:18px;top:50%;" class="carousel-control-prev" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="prev">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </button>
                                                                <button style="height:18px;top:50%;" class="carousel-control-next" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="next">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </button>
                                                            </div>
                                                            @endif
                                                            <div class="comment-box mt-3 mb-4 " style="display: none;">
                                                                <div class="d-flex mb-3 position-relative">
                                                                    <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                width: 40px;
                                                                                height: 40px;"
                                                                                ></div>
                                                                    <div class="comment-detail ml-3 py-2 px-3" style=" background-color: #eee;
                                                                                width:-webkit-fill-available;
                                                                                border-radius: 8px;">
                                                                        <div class="d-flex">
                                                                            <span class="ml-2">1 min ago</span>
                                                                        </div>
                                                                        <p id="comment" class="mb-0">This is a Dummy Comment</p>
                                                                    </div>
                                                                    <div class="dropdown">
                                                                        <button style=" position: absolute;
                                                                                right: 25px;
                                                                                top: 50%;
                                                                                transform: translateY(-50%);"
                                                                            class="dropdown-toggle bg-transparent border-0 font-20"
                                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item btn">Edit</a>
                                                                            <a class="dropdown-item btn">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                width: 40px;
                                                                                height: 40px;"
                                                                                ></div>
                                                                    <input style=" width:-webkit-fill-available;
                                                                                border-radius: 3px;
                                                                                border: 1px solid #eee;
                                                                                line-height: 1;" class="ml-3 py-3 px-2" name=""
                                                                        id="commentTextArea"> <input>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="go-btn">
                                                        <a href="" data-menu="menu-share">
                                                            <button type="button" class="btn btn-light bg-magenta-dark">+Go</button></a>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($posts['spot_id'])
                                                @if($posts['spot'])
                                                    <div class="col-sm-12">
                                                        <div class="card card-style card-bg-img" style="background-image: url({{asset('ibigo-web/images/17.jpg')}})">
                                                            <div class="content m-0">
                                                                <div class="d-flex">
                                                                    <div class="w-25" style="background-color: #fff; position: relative;">
                                                                        <div class="m-auto">
                                                                            <a href="@if($posts['user_id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$posts['unique_id'].'/'.$posts['user_slug'])}} @endif">
                                                                                <div class=" home-img rounded-sm shadow-xl my-5 mx-auto" style="
                                                                                        background-image: url(@if($posts['user_profile']) {{asset('storage/images/user/profile/'.$posts['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif );
                                                                                        width: 100px;
                                                                                        height: 100px;"
                                                                                        ></div>
                                                                            </a>
                                                                        </div>
                                                                        <a class="text-dark btn heart" style="position: absolute; bottom: 0;" id="">
                                                                            <i id="" class="far fa-heart font-20 border-heart"></i>
                                                                            <div style="display: none;" class="filled-heart">
                                                                                <div class="d-flex">
                                                                                    <i style="color: red;" class="fa fa-heart font-20"></i>
                                                                                    <span class="ml-1 font-12 mt-1">You</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <div class="w-75 position-relative">
                                                                        <div class="card-body w-100" style="padding-bottom: 50px;">
                                                                            <p class="color-white font-500 mb-n1">{{$posts['how_long']}}</p>

                                                                            <a href="{{ url('/spots/'.$posts['spot']['user_spot']['unique_id'].'/'.$posts['spot']['user_spot']['user_slug']) }}">
                                                                                <h2 class="color-white pt-1 pb-1">{{$posts['spot']['business_name']}}</h2>
                                                                            </a>
                                                                            <p class="color-white mb-0">
                                                                                <a class="color-highlights mb-0" href="@if($posts['user_id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$posts['unique_id'].'/'.$posts['user_slug'])}} @endif"> {{$posts['fullname']}}</a>
                                                                                <i >shared spot
                                                                                    @if($posts['share_with'] == 'People' || $posts['tagged_user'])
                                                                                        <span>with</span>
                                                                                    @endif
                                                                                    @if($posts['share_with'] == 'People')
                                                                                    <span class="dropdown"> 
                                                                                        <button class="p-0 bg-transparent border-0 text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            {{count($posts['status'])}} friends
                                                                                        </button>
                                                                                        @if($posts['status'])
                                                                                        <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                            @foreach($posts['status'] as $status)
                                                                                                @if($status['user'])
                                                                                                    <a class="dropdown-item" href="@if($status['user']['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$status['user']['unique_id'].'/'.$status['user']['user_slug'])}} @endif">{{$status['user']['fullname']}}</a>
                                                                                                @endif 
                                                                                            @endforeach
                                                                                        </span>   
                                                                                        @endif 
                                                                                    </span>@endif
                                                                                    @if($posts['share_with'] == 'People' && $posts['tagged_user'])
                                                                                    <span>and</span>
                                                                                    @endif
                                                                                    @if($posts['tagged_user']) 
                                                                                    <span class="dropdown">
                                                                                        <button class="p-0 bg-transparent border-0 text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            tagged {{count($posts['status'])}} friends
                                                                                        </button>
                                                                                        <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                            @foreach($posts['tagged_user'] as $user)
                                                                                                    <a class="dropdown-item" href="@if($user['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$user['unique_id'].'/'.$user['user_slug'])}} @endif">{{$user['fullname']}}</a>
                                                                                            @endforeach
                                                                                        </span>
                                                                                    </span>@endif
                                                                                </i> 
                                                                            </p>
                                                                            <h4 class="text-light text-capitalize">{{$posts['title']}}</h4>
                                                                            <p class="text-light">{{$posts['description']}}</p>
                                                                            <a href="{{ url('/spots/'.$posts['spot']['user_spot']['unique_id'].'/'.$posts['spot']['user_spot']['user_slug']) }}"
                                                                                class="btn btn-sm btn-sm mb-3 rounded-xs text-uppercase font-900 shadow-s bg-white color-black mt-3">View
                                                                                Spot</a>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end w-100 comment-parent"
                                                                            style="position: absolute; bottom: 0; z-index: 11;">
                                                                            <a class="color-white btn comment-section mr-2">
                                                                                <i class="far fa-comment  font-20"></i>
                                                                            </a>
                                                                        </div>
                                                                        <a href="#" data-menu="menu-cart-item" class="dot-icon-btn color-white ml-auto">
                                                                            <i class="fas fa-ellipsis-v  font-20"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @if($posts['post_audios'])
                                                                    <div class="row mb-0" style="overflow: hidden; background-color:#fff;">
                                                                        @foreach($posts['post_audios'] as $audios)
                                                                            @if($audios['post_audios'])
                                                                                <div class="col-md-6 p-0">
                                                                                    <div style="height:fit-content;background-color: #f1f3f4;">
                                                                                        <audio controls>
                                                                                            <source src="{{asset('storage/audios/post/audios/'.$audios['post_audios'])}}">
                                                                                        </audio>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                @if($posts['post_images'] || $posts['post_videos'])
                                                                <div id="carouselExampleControls{{$posts['id']}}" class="carousel slide bg-black"  data-ride="carousel" data-interval="false">
                                                                    <div class="carousel-inner">
                                                                        @if($posts['post_images'])
                                                                            @foreach($posts['post_images'] as $images)
                                                                                @if($images['post_images'])
                                                                                    <div class="carousel-item @if($posts['post_images'][0]['id'] == $images['id']) active @endif">
                                                                                        <img style="height:500px;" src="{{asset('storage/images/post/images/'.$images['post_images'])}}" class="d-block w-100" alt="Image has been deleted">
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        @if($posts['post_videos'])
                                                                            @foreach($posts['post_videos'] as $videos)
                                                                                @if($videos['post_videos'])
                                                                                    <div class="carousel-item">
                                                                                        <video style="height:500px !important;" controls class="d-block w-100">
                                                                                            <source src="{{asset('storage/videos/post/videos/'.$videos['post_videos'])}}">
                                                                                        </video>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <button style="height:18px;top:50%;" class="carousel-control-prev" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="prev">
                                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                        <span class="sr-only">Previous</span>
                                                                    </button>
                                                                    <button style="height:18px;top:50%;" class="carousel-control-next" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="next">
                                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        <span class="sr-only">Next</span>
                                                                    </button>
                                                                </div>
                                                                @endif
                                                                <div class="comment-box mt-3 mb-4 " style="display: none;">
                                                                    <div class="d-flex mb-3 position-relative">
                                                                        <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                    width: 40px;
                                                                                    height: 40px;"
                                                                                    ></div>
                                                                        <div class="comment-detail ml-3 py-2 px-3" style=" background-color: #eee;
                                                                                    width:-webkit-fill-available;
                                                                                    border-radius: 8px;">
                                                                            <div class="d-flex">
                                                                                <h6>Shadow User.</h6>
                                                                                <span class="ml-2">1 min ago</span>
                                                                            </div>
                                                                            <p id="comment" class="mb-0">This is a Dummy Comment</p>
                                                                        </div>
                                                                        <div class="dropdown">
                                                                            <button style=" position: absolute;
                                                                                    right: 25px;
                                                                                    top: 50%;
                                                                                    transform: translateY(-50%);"
                                                                                class="dropdown-toggle bg-transparent border-0 font-20"
                                                                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false">
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item btn">Edit</a>
                                                                                <a class="dropdown-item btn">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex">
                                                                        <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                    width: 40px;
                                                                                    height: 40px;"
                                                                                    ></div>
                                                                        <input style=" width:-webkit-fill-available;
                                                                                    border-radius: 3px;
                                                                                    border: 1px solid #eee;
                                                                                    line-height: 1;" class="ml-3 py-3 px-2" name=""
                                                                            id="commentTextArea"><input>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="go-btn">
                                                            <a href="" data-menu="menu-share">
                                                                <button type="button" class="btn btn-light bg-magenta-dark">+Go</button></a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($posts['planning_id'])
                                                <div class="col-sm-12">
                                                    <div class="card card-style">
                                                        <div class="content">
                                                            <div class="d-flex">

                                                                <div class="mr-3">

                                                                <a href="@if($posts['user_id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$posts['unique_id'].'/'.$posts['user_slug'])}} @endif">
                                                                        <div class=" home-img rounded-sm shadow-xl" style="
                                                                                background-image: url(@if($posts['user_profile']) {{asset('storage/images/user/profile/'.$posts['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif );
                                                                                width: 100px;
                                                                                height: 100px;"
                                                                                ></div>
                                                                    </a>
                                                                </div>
                                                                <div class="w-100">
                                                                <p class=" font-500 mb-n1">{{$posts['how_long']}}</p>
                                                                    <div class="d-flex">
                                                                        <h2 class="mr-2 mb-0">{{$posts['fullname']}}</h2>
                                                                        <span>shared planning </span>
                                                                        @if($posts['share_with'] == 'People') 
                                                                        <span class="dropdown">
                                                                            <button class=" bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                 with {{count($posts['status'])}} friends
                                                                            </button>
                                                                            @if($posts['status'])
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['status'] as $status)
                                                                                    @if($status['user'])
                                                                                        <a class="dropdown-item" href="@if($status['user']['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$status['user']['unique_id'].'/'.$status['user']['user_slug'])}} @endif">{{$status['user']['fullname']}}</a>
                                                                                    @endif 
                                                                                @endforeach
                                                                            </span>   
                                                                            @endif 
                                                                        </span>@endif
                                                                        @if($posts['share_with'] == 'People' && $posts['tagged_user'])
                                                                        <span> and </span>
                                                                        @endif
                                                                        @if($posts['tagged_user']) 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                tagged {{count($posts['status'])}} friends
                                                                            </button>
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['tagged_user'] as $user)
                                                                                        <a class="dropdown-item" href="@if($user['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$user['unique_id'].'/'.$user['user_slug'])}} @endif">{{$user['fullname']}}</a>
                                                                                @endforeach
                                                                            </span>
                                                                        </span>@endif
                                                                    </div>
                                                                    <h4 class="text-secondary text-capitalize">{{$posts['title']}}</h4>
                                                                    <p class="text-secondary">{{$posts['description']}}</p>
                                                                </div>

                                                                <a href="#" data-menu="menu-cart-item" class="color-black ml-auto">
                                                                    <i class="fas fa-ellipsis-v  font-20"></i>
                                                                </a>

                                                            </div>
                                                            @if($posts['planning_spot'])
                                                            <div class="card card-style my-3">
                                                                <div class="row mb-0 py-4 pl-3">
                                                                    <div class="col-md-3 col-sm-12 text-center">
                                                                        @if(strpos($posts['planning_spot']['user_spot']['user_profile'], 'http') === 0)
                                                                            <img width="100px" height="100px" class="rounded-lg shadow-xl" src="{{$posts['planning_spot']['user_spot']['user_profile']}}">
                                                                        @else
                                                                            <img width="100px" height="100px" class="rounded-lg shadow-xl" src="{{asset('storage/images/user/profile/'.$posts['planning_spot']['user_spot']['user_profile'])}}">
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-9 col-sm-12 p-0 my-auto">
                                                                        <h4 class="text-secondary text-capitalize">{{$posts['planning_spot']['business_name']}}</h4>
                                                                        <a class="d-flex" href="{{url('https://www.google.com/maps/@'.$posts['planning_spot']['latitude'].','.$posts['planning_spot']['longitude'])}}" target="_blank">
                                                                            <i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>
                                                                            <p class="color-magenta-dark mx-2">{{$posts['planning_spot']['full_address']}}</p>
                                                                        </a>
                                                                        <p><i class="fas fa-calendar-alt mr-1"></i> {{$posts['day']}}, {{$posts['start_date']}}</p>
                                                                        @if($posts['like_user'])
                                                                            @foreach($posts['like_user'] as $user)
                                                                                @if($user['user']['user_profile'])
                                                                                <img style="width:5%;" class="rounded-circle" src="{{asset('storage/images/user/profile/'.$user['user']['user_profile'])}}" alt="" title="{{$user['user']['fullname']}}">
                                                                                @else
                                                                                <img style="width:5%;" class="rounded-circle" src="{{asset('ibigo-web/images/avatars/2m.png')}}" alt="" title="{{$user['user']['fullname']}}">
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="d-flex mt-4 justify-content-between w-100 comment-parent">

                                                                <a class="text-dark btn heart" id="">
                                                                    <i id="" class="far fa-heart font-20 border-heart"></i>
                                                                    <div style="display: none;" class="filled-heart">
                                                                        <div class="d-flex">
                                                                            <i style="color: red;" class="fa fa-heart font-20"></i>
                                                                            <span class="ml-1 font-12 mt-1">You</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="text-dark btn comment-section">
                                                                    <i class="far fa-comment  font-20"></i>
                                                                </a>
                                                            </div>
                                                            <div class="comment-box mt-3 mb-4 " style="display: none;">
                                                                <div class="d-flex mb-3 position-relative">
                                                                    <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                width: 40px;
                                                                                height: 40px;"
                                                                                ></div>
                                                                    <div class="comment-detail ml-3 py-2 px-3" style=" background-color: #eee;
                                                                                width:-webkit-fill-available;
                                                                                border-radius: 8px;">
                                                                        <div class="d-flex">
                                                                            <h6>Shadow User.</h6>
                                                                            <span class="ml-2">1 min ago</span>
                                                                        </div>
                                                                        <p id="comment" class="mb-0">This is a Dummy Comment</p>
                                                                    </div>
                                                                    <div class="dropdown">
                                                                        <button style=" position: absolute;
                                                                                right: 25px;
                                                                                top: 50%;
                                                                                transform: translateY(-50%);"
                                                                            class="dropdown-toggle bg-transparent border-0 font-20"
                                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item btn">Edit</a>
                                                                            <a class="dropdown-item btn">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                width: 40px;
                                                                                height: 40px;"
                                                                                ></div>
                                                                    <input style=" width:-webkit-fill-available;
                                                                                border-radius: 3px;
                                                                                border: 1px solid #eee;
                                                                                line-height: 1;" class="ml-3 py-3 px-2" name=""
                                                                        id="commentTextArea"><input>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="go-btn">
                                                        <a href="" data-menu="menu-share">
                                                            <button type="button" class="btn btn-light bg-magenta-dark">+Go</button></a>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($posts['review_id'])
                                                @if($posts['review_spot'])
                                                    <div class="col-sm-12">
                                                        <div class="card card-style">
                                                            <div class="content">
                                                                <div class="d-flex">

                                                                    <div class="mr-3">

                                                                        <a href="@if($posts['user_id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$posts['unique_id'].'/'.$posts['user_slug'])}} @endif">
                                                                            <div class=" home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url(@if($posts['user_profile']) {{asset('storage/images/user/profile/'.$posts['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif );
                                                                                    width: 100px;
                                                                                    height: 100px;"
                                                                                    ></div>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        <p class=" font-500 mb-n1">{{$posts['how_long']}}</p>
                                                                        <div class="d-flex">
                                                                            <h2 class="mr-2 mb-0">{{$posts['fullname']}} <span class="text-secondary">reviewed</span> {{$posts['review_spot']['business_name']}} </h2>
                                                                        </div>
                                                                        @if($posts['share_with'] == 'People') 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                shared review with {{count($posts['status'])}} friends
                                                                            </button>
                                                                            @if($posts['status'])
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['status'] as $status)
                                                                                    @if($status['user'])
                                                                                        <a class="dropdown-item" href="@if($status['user']['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$status['user']['unique_id'].'/'.$status['user']['user_slug'])}} @endif">{{$status['user']['fullname']}}</a>
                                                                                    @endif 
                                                                                @endforeach
                                                                            </span>   
                                                                            @endif 
                                                                        </span>@endif
                                                                        @if($posts['share_with'] == 'People' && $posts['tagged_user'])
                                                                        <span> and </span>
                                                                        @endif
                                                                        @if($posts['tagged_user']) 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                tagged {{count($posts['status'])}} friends
                                                                            </button>
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['tagged_user'] as $user)
                                                                                        <a class="dropdown-item" href="@if($user['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$user['unique_id'].'/'.$user['user_slug'])}} @endif">{{$user['fullname']}}</a>
                                                                                @endforeach
                                                                            </span>
                                                                        </span>@endif
                                                                        <div class="card card-style my-3">
                                                                            <div class="row mb-0 py-4 pl-3">
                                                                                <div class="col-md-3 col-sm-12 text-center">
                                                                                    @if(strpos($posts['review_spot']['user_spot']['user_profile'], 'http') === 0)
                                                                                        <img width="100px" height="100px" class="rounded-lg shadow-xl" src="{{$posts['review_spot']['user_spot']['user_profile']}}">
                                                                                    @else
                                                                                        <img width="100px" height="100px" class="rounded-lg shadow-xl" src="{{asset('storage/images/user/profile/'.$posts['review_spot']['user_spot']['user_profile'])}}">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-md-9 col-sm-12 p-0 my-auto">
                                                                                    <h4 class="text-secondary text-capitalize">{{$posts['review_spot']['business_name']}}</h4>
                                                                                    <div class="d-flex justify-content-between">
                                                                                        @if($posts['rating']) <span class="text-secondary d-flex mr-3"><i class="fas fa-star mt-1 mr-2" style="color:yellow;"></i> <p>{{$posts['rating']}}</p> </span>@endif
                                                                                        <a class="d-flex" href="{{url('https://www.google.com/maps/@'.$posts['review_spot']['latitude'].','.$posts['review_spot']['longitude'])}}" target="_blank">
                                                                                            <i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>
                                                                                            <p class="color-magenta-dark mx-2">{{$posts['review_spot']['full_address']}}</p>
                                                                                        </a>
                                                                                    </div>
                                                                                    @if($posts['review_spot']['short_description'])<span class="text-secondary"><i class="fas fa-home mr-2"></i> {{$posts['review_spot']['short_description']}}</span>@endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class='text-center'>
                                                                            <i class='fa fa-star font-40' @if($posts['avg_rating'] == 1 || $posts['avg_rating'] == 2 || $posts['avg_rating'] == 3 || $posts['avg_rating'] == 4 || $posts['avg_rating'] == 5) style="color:yellow;" @endif></i>
                                                                            <i class='fa fa-star font-40' @if($posts['avg_rating'] == 2 || $posts['avg_rating'] == 3 || $posts['avg_rating'] == 4 || $posts['avg_rating'] == 5) style="color:yellow;" @endif></i>
                                                                            <i class='fa fa-star font-40' @if($posts['avg_rating'] == 3 || $posts['avg_rating'] == 4 || $posts['avg_rating'] == 5) style="color:yellow;" @endif></i>
                                                                            <i class='fa fa-star font-40' @if($posts['avg_rating'] == 4 || $posts['avg_rating'] == 5) style="color:yellow;" @endif></i>
                                                                            <i class='fa fa-star font-40' @if($posts['avg_rating'] == 5) style="color:yellow;" @endif></i>
                                                                        </div>
                                                                        <h4 class="text-secondary text-capitalize">{{$posts['title']}}</h4>
                                                                        <p class="text-secondary">{{$posts['description']}}</p>
                                                                    </div>
                                                                    <a href="#" data-menu="menu-cart-item" class="color-black ml-auto">
                                                                        <i class="fas fa-ellipsis-v  font-20"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="d-flex mt-4 justify-content-between w-100 comment-parent">

                                                                    <a class="text-dark btn heart" id="">
                                                                        <i id="" class="far fa-heart font-20 border-heart"></i>
                                                                        <div style="display: none;" class="filled-heart">
                                                                            <div class="d-flex">
                                                                                <i style="color: red;" class="fa fa-heart font-20"></i>
                                                                                <span class="ml-1 font-12 mt-1">You</span>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <a class="text-dark btn comment-section">
                                                                        <i class="far fa-comment  font-20"></i>
                                                                    </a>
                                                                </div>
                                                                @if($posts['post_audios'])
                                                                    <div class="row mb-0" style="overflow: hidden; background-color:#fff;">
                                                                        @foreach($posts['post_audios'] as $audios)
                                                                            @if($audios['post_audios'])
                                                                                <div class="col-md-6 p-0">
                                                                                    <div style="height:fit-content;background-color: #f1f3f4;">
                                                                                        <audio controls>
                                                                                            <source src="{{asset('storage/audios/post/audios/'.$audios['post_audios'])}}">
                                                                                        </audio>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                @if($posts['post_images'] || $posts['post_videos'])
                                                                <div id="carouselExampleControls{{$posts['id']}}" class="carousel slide bg-black"  data-ride="carousel" data-interval="false">
                                                                    <div class="carousel-inner">
                                                                        @if($posts['post_images'])
                                                                            @foreach($posts['post_images'] as $images)
                                                                                @if($images['post_images'])
                                                                                    <div class="carousel-item @if($posts['post_images'][0]['id'] == $images['id']) active @endif">
                                                                                        <img style="height:500px;" src="{{asset('storage/images/post/images/'.$images['post_images'])}}" class="d-block w-100" alt="Image has been deleted">
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        @if($posts['post_videos'])
                                                                            @foreach($posts['post_videos'] as $videos)
                                                                                @if($videos['post_videos'])
                                                                                    <div class="carousel-item">
                                                                                        <video style="height:500px !important;" controls class="d-block w-100">
                                                                                            <source src="{{asset('storage/videos/post/videos/'.$videos['post_videos'])}}">
                                                                                        </video>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <button style="height:18px;top:50%;" class="carousel-control-prev" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="prev">
                                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                        <span class="sr-only">Previous</span>
                                                                    </button>
                                                                    <button style="height:18px;top:50%;" class="carousel-control-next" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="next">
                                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        <span class="sr-only">Next</span>
                                                                    </button>
                                                                </div>
                                                                @endif
                                                                <div class="comment-box mt-3 mb-4 " style="display: none;">
                                                                    <div class="d-flex mb-3 position-relative">
                                                                        <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                    width: 40px;
                                                                                    height: 40px;"
                                                                                    ></div>
                                                                        <div class="comment-detail ml-3 py-2 px-3" style=" background-color: #eee;
                                                                                    width:-webkit-fill-available;
                                                                                    border-radius: 8px;">
                                                                            <div class="d-flex">
                                                                                <span class="ml-2">1 min ago</span>
                                                                            </div>
                                                                            <p id="comment" class="mb-0">This is a Dummy Comment</p>
                                                                        </div>
                                                                        <div class="dropdown">
                                                                            <button style=" position: absolute;
                                                                                    right: 25px;
                                                                                    top: 50%;
                                                                                    transform: translateY(-50%);"
                                                                                class="dropdown-toggle bg-transparent border-0 font-20"
                                                                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false">
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item btn">Edit</a>
                                                                                <a class="dropdown-item btn">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex">
                                                                        <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                    width: 40px;
                                                                                    height: 40px;"
                                                                                    ></div>
                                                                        <input style=" width:-webkit-fill-available;
                                                                                    border-radius: 3px;
                                                                                    border: 1px solid #eee;
                                                                                    line-height: 1;" class="ml-3 py-3 px-2" name=""
                                                                            id="commentTextArea"> <input>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="go-btn">
                                                            <a href="" data-menu="menu-share">
                                                                <button type="button" class="btn btn-light bg-magenta-dark">+Go</button></a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($posts['checkin_id'])
                                                @if($posts['checkin'])
                                                    <div class="col-sm-12">
                                                        <div class="card card-style">
                                                            <div class="content">
                                                                <div class="d-flex">
                                                                    <div class="mr-3">

                                                                        <a href="@if($posts['user_id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$posts['unique_id'].'/'.$posts['user_slug'])}} @endif">
                                                                            <div class=" home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url(@if($posts['user_profile']) {{asset('storage/images/user/profile/'.$posts['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif );
                                                                                    width: 100px;
                                                                                    height: 100px;"
                                                                                    ></div>
                                                                        </a>
                                                                    </div>
                                                                    <div>
                                                                        @if($posts['checkin']['business_name'])<p><i class="fas fa-map-marker-alt text-secondary"></i> Check in <span class="text-dark font-weight-bold">{{$posts['checkin']['business_name']}}</span></p>@endif
                                                                        <p class=" font-500 mb-n1">{{$posts['how_long']}}</p>
                                                                        <div class="d-flex">
                                                                            <h2 class="mr-2 mb-0">{{$posts['fullname']}} </h2>
                                                                        </div>
                                                                        @if($posts['share_with'] == 'People') 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                shared checkin post with {{count($posts['status'])}} friends
                                                                            </button>
                                                                            @if($posts['status'])
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['status'] as $status)
                                                                                    @if($status['user'])
                                                                                        <a class="dropdown-item" href="@if($status['user']['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$status['user']['unique_id'].'/'.$status['user']['user_slug'])}} @endif">{{$status['user']['fullname']}}</a>
                                                                                    @endif 
                                                                                @endforeach
                                                                            </span>   
                                                                            @endif 
                                                                        </span>@endif
                                                                        @if($posts['share_with'] == 'People' && $posts['tagged_user'])
                                                                        <span> and </span>
                                                                        @endif
                                                                        @if($posts['tagged_user']) 
                                                                        <span class="dropdown">
                                                                            <button class="p-0 bg-transparent border-0 text-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                tagged {{count($posts['status'])}} friends
                                                                            </button>
                                                                            <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                @foreach($posts['tagged_user'] as $user)
                                                                                        <a class="dropdown-item" href="@if($user['id'] == Auth::user()->id) {{url('/profile')}} @else {{url('/people/'.$user['unique_id'].'/'.$user['user_slug'])}} @endif">{{$user['fullname']}}</a>
                                                                                @endforeach
                                                                            </span>
                                                                        </span>@endif
                                                                        <div>
                                                                            @if(strpos($posts['checkin']['user_spot']['user_cover'], 'http') === 0)
                                                                                <img class="rounded-lg shadow-xl img-fluid" src="{{$posts['checkin']['user_spot']['user_cover']}}">
                                                                            @elseif($posts['checkin']['user_spot']['user_cover'])
                                                                                <img class="rounded-lg shadow-xl img-fluid" src="{{asset('storage/images/user/cover/'.$posts['checkin']['user_spot']['user_cover'])}}">
                                                                            @else    
                                                                                <img class="rounded-lg shadow-xl img-fluid" src="{{asset('ibigo-web/images/117.png')}}">
                                                                            @endif
                                                                        </div>
                                                                        <a href="{{url('spots/'.$posts['checkin']['user_spot']['unique_id'].'/'.$posts['checkin']['user_spot']['user_slug'])}}"><h4 class="text-dark text-capitalize">{{$posts['checkin']['business_name']}}</h4></a>
                                                                        <div class="row mb-0">
                                                                            <div class="col-md-5 col-sm-12">
                                                                            <a class="d-flex" href="{{url('https://www.google.com/maps/@'.$posts['checkin']['latitude'].','.$posts['checkin']['longitude'])}}" target="_blank">
                                                                                <i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>
                                                                                <p class="color-magenta-dark mx-2">{{$posts['checkin']['full_address']}}</p>
                                                                            </a>
                                                                            </div>
                                                                            <div class="col-md-5 col-sm-12">
                                                                            @if($posts['checkin']['business_name'])<span class="text-secondary"><i class="fas fa-home mr-2"></i> {{$posts['checkin']['business_name']}}</span>@endif
                                                                            </div>
                                                                            <div class="col-md-2 col-sm-12">
                                                                            @if($posts['checkin']['avg_rating']) <span class="text-secondary d-flex mr-3"><i class="fas fa-star mt-1 mr-2" style="color:yellow;"></i> <p>{{$posts['checkin']['avg_rating']}}</p> </span>@endif
                                                                            </div>
                                                                        </div>
                                                                        <h4 class="text-secondary text-capitalize">{{$posts['title']}}</h4>
                                                                        <p class="text-secondary">{{$posts['description']}}</p>
                                                                    </div>
                                                                    <a href="#" data-menu="menu-cart-item" class="color-black ml-auto">
                                                                        <i class="fas fa-ellipsis-v  font-20"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="d-flex mt-4 justify-content-between w-100 comment-parent">

                                                                    <a class="text-dark btn heart" id="">
                                                                        <i id="" class="far fa-heart font-20 border-heart"></i>
                                                                        <div style="display: none;" class="filled-heart">
                                                                            <div class="d-flex">
                                                                                <i style="color: red;" class="fa fa-heart font-20"></i>
                                                                                <span class="ml-1 font-12 mt-1">You</span>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <a class="text-dark btn comment-section">
                                                                        <i class="far fa-comment  font-20"></i>
                                                                    </a>
                                                                </div>
                                                                @if($posts['post_audios'])
                                                                    <div class="row mb-0" style="overflow: hidden; background-color:#fff;">
                                                                        @foreach($posts['post_audios'] as $audios)
                                                                            @if($audios['post_audios'])
                                                                                <div class="col-md-6 p-0">
                                                                                    <div style="height:fit-content;background-color: #f1f3f4;">
                                                                                        <audio controls>
                                                                                            <source src="{{asset('storage/audios/post/audios/'.$audios['post_audios'])}}">
                                                                                        </audio>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                @if($posts['post_images'] || $posts['post_videos'])
                                                                <div id="carouselExampleControls{{$posts['id']}}" class="carousel slide bg-black"  data-ride="carousel" data-interval="false">
                                                                    <div class="carousel-inner">
                                                                        @if($posts['post_images'])
                                                                            @foreach($posts['post_images'] as $images)
                                                                                @if($images['post_images'])
                                                                                    <div class="carousel-item @if($posts['post_images'][0]['id'] == $images['id']) active @endif">
                                                                                        <img style="height:500px;" src="{{asset('storage/images/post/images/'.$images['post_images'])}}" class="d-block w-100" alt="Image has been deleted">
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        @if($posts['post_videos'])
                                                                            @foreach($posts['post_videos'] as $videos)
                                                                                @if($videos['post_videos'])
                                                                                    <div class="carousel-item">
                                                                                        <video style="height:500px !important;" controls class="d-block w-100">
                                                                                            <source src="{{asset('storage/videos/post/videos/'.$videos['post_videos'])}}">
                                                                                        </video>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <button style="height:18px;top:50%;" class="carousel-control-prev" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="prev">
                                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                        <span class="sr-only">Previous</span>
                                                                    </button>
                                                                    <button style="height:18px;top:50%;" class="carousel-control-next" type="button" data-target="#carouselExampleControls{{$posts['id']}}" data-slide="next">
                                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        <span class="sr-only">Next</span>
                                                                    </button>
                                                                </div>
                                                                @endif
                                                                <div class="comment-box mt-3 mb-4 " style="display: none;">
                                                                    <div class="d-flex mb-3 position-relative">
                                                                        <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                    width: 40px;
                                                                                    height: 40px;"
                                                                                    ></div>
                                                                        <div class="comment-detail ml-3 py-2 px-3" style=" background-color: #eee;
                                                                                    width:-webkit-fill-available;
                                                                                    border-radius: 8px;">
                                                                            <div class="d-flex">
                                                                                <span class="ml-2">1 min ago</span>
                                                                            </div>
                                                                            <p id="comment" class="mb-0">This is a Dummy Comment</p>
                                                                        </div>
                                                                        <div class="dropdown">
                                                                            <button style=" position: absolute;
                                                                                    right: 25px;
                                                                                    top: 50%;
                                                                                    transform: translateY(-50%);"
                                                                                class="dropdown-toggle bg-transparent border-0 font-20"
                                                                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false">
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item btn">Edit</a>
                                                                                <a class="dropdown-item btn">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex">
                                                                        <div class="my-auto home-img rounded-sm shadow-xl" style="
                                                                                    background-image: url({{asset('ibigo-web/images/men.jpeg')}});
                                                                                    width: 40px;
                                                                                    height: 40px;"
                                                                                    ></div>
                                                                        <input style=" width:-webkit-fill-available;
                                                                                    border-radius: 3px;
                                                                                    border: 1px solid #eee;
                                                                                    line-height: 1;" class="ml-3 py-3 px-2" name=""
                                                                            id="commentTextArea"> <input>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="go-btn">
                                                            <a href="" data-menu="menu-share">
                                                                <button type="button" class="btn btn-light bg-magenta-dark">+Go</button></a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 mt-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mt-0 wrapper card card-style">

                                <div class="container-calendar">

                                    <div class="button-container-calendar">
                                        <button id="previous" onclick="previous()">&#8249;</button>
                                        <h6 id="monthAndYear"></h6>
                                        <button id="next" onclick="next()">&#8250;</button>
                                    </div>

                                    <table class="table-calendar" id="calendar" data-lang="en">
                                        <thead id="thead-month"></thead>
                                        <tbody id="calendar-body"></tbody>
                                    </table>

                                    <div class="footer-container-calendar d-none">
                                        <label for="month">Jump To: </label>
                                        <select id="month" onchange="jump()">
                                            <option value=0>Jan</option>
                                            <option value=1>Feb</option>
                                            <option value=2>Mar</option>
                                            <option value=3>Apr</option>
                                            <option value=4>May</option>
                                            <option value=5>Jun</option>
                                            <option value=6>Jul</option>
                                            <option value=7>Aug</option>
                                            <option value=8>Sep</option>
                                            <option value=9>Oct</option>
                                            <option value=10>Nov</option>
                                            <option value=11>Dec</option>
                                        </select>
                                        <select id="year" onchange="jump()"></select>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12">

                            <div class="card card-style profile-card ml-2 mr-1 w-auto">
                                <div class="content m-0">
                                    <a href="{{url('/friends')}}" class=""><h3 class="pb-3 pt-2 px-3 font-18 font-weight-bold">Connect</h3></a>
                                    <div class="divider mb-3" style="height:2px !important;"></div>
                                    @if($friends)
                                        @foreach($friends as $friend)
                                            <div class="d-flex mb-3 px-3">
                                                <a href="{{url('/people/'.$friend->unique_id.'/'.$friend->user_slug)}}" class="d-flex">
                                                    @if($friend->user_profile)
                                                        <div>
                                                            <img src="{{asset('storage/images/user/profile/'.$friend->user_profile)}}" width="70" height="70" class="rounded-circle mr-3">
                                                        </div>
                                                    @else
                                                        <div>
                                                            <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="70" height="70" class="rounded-circle mr-3">
                                                        </div>
                                                    @endif
                                                    <div class="m-auto">
                                                        <h5 class="font-16 font-600">{{$friend->fullname}}</h5>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="divider mb-3" style="height:2px !important;"></div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-cart-item" class="menu menu-box-modal rounded-m bg-theme" data-menu-width="200" data-menu-height="300"
        style="height: 400px; width: 350px; display: block;">
        <div class="menu-title">

            <h1 class="font-800">Action</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

        <div class="content">
            <div class="divider mt-n2"></div>
            <a data-menu="menu-share-thumbs2" href="#"
                class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-green-dark"><i
                    class="fas fa-plus mx-1"></i>Edit Post</a>
            <a href="#" data-menu="menu-option-1">
                <button class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark"><i
                        class="fas fa-plus mx-1"></i>Delete Post</button>
            </a>
        </div>

    </div>
    <div id="menu-option-1" class="editPost menu menu-box-modal rounded-m" data-menu-height="200" data-menu-width="350"
        style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">

            <p class="color-black font-18">Ibigo.nl says</p>


        </div>
        <div class="content mt-4">
            <p class="pr-3">
                Are you sure you want to remove Sinan Ros as your friend?
            </p>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="" data-menu="menu-success-2">
                        <button class="btn bg-highlight font-600 rounded-s mx-5 cancel-req"
                            style="width: 100px; height: 50px;">OK</button></a>

                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full   font-600 rounded-s cancel-req"
                        style="background-color: gray; width: 100px; height: 50px;">Cancel</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html" data-menu-height="300">
        <div class="content">
            <div class="divider mb-3"></div>
            <a href="" class="d-flex mb-3" data-menu="menu-option-2">
                <div class="text-center">
                    <i class="fas fa fa-tasks font-12 mt-2 pt-2 rounded-l bg-facebook  color-white shadow-l rounded-l"
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
                    <i class="fa fa-plus font-12 bg-twitter color-white pt-2 mt-2  shadow-l "
                        style="width: 30px; height: 30px; border-radius: 50px;"></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Add To Plannings</h5>

                </div>

                <div class="align-self-center ml-auto font-40 color-black">

                </div>
            </a>
            <div class="divider mb-3"></div>
            <a href="" class="d-flex mb-3" data-menu="menu-option-4">
                <div class="text-center">
                    <i class="fa fa-share font-12  bg-linkedin color-white shadow-l rounded-l pt-2 mt-2 rounded-l"
                        style="width: 30px; height: 30px; "></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Share</h5>

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

    <div style="border-radius: 8px" id="menu-share-thumbs" class="menu menu-box-modal bg-light" data-menu-height="600" data-menu-width="900">
        <div class="menu-title">
            <h4 class="px-3 mt-3">Plaats bericht</h4>
            <a href="#" class="close-menu "><i class="fa fa-times-circle mt-1 color-dark"></i></a>
        </div>




        <div class="divider divider-margins mt-3 mb-0"></div>
        <div class="content mt-4">
            <div class="list-group list-custom-small ">
                <form action="{{ url('/web/post/store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="search-box search-dark add-post-input border-1 bg-theme  bottom-0">
                    <i class="fa fa-search "></i>
                    <input type="text" class="border-0 search" onkeyup="getSpot()" placeholder="Zoek Plek of evenement " data-search="">
                </div>
                {{-- ajax div --}}
                <div class="allData"></div>
                <div class="select-spot"></div>
                {{-- end ajax div --}}

                <div class="input-style input-style-1 input-required">
                    <div class="row mt-2 mb-0">
                        <div class="col-sm-12 d-flex my-auto">
                            <img src="{{asset('ibigo-web/images/men.jpeg')}}" alt="" width="50" height="50" class="rounded-xl mr-2">
                            <input type="text" placeholder ="Vertel ons iets over de titel" name="title" class="font-18 mt-auto" />
                        </div>
                        @if($errors->get('description'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{$errors->first('description')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="col-sm-12">
                            <textarea name="description" placeholder="Vertel iets over deze posten" rows="6" style="padding-top: 15px!important" type="text" class="font-18"></textarea>
                        </div>
                        @if($errors->get('description'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{$errors->first('description')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex">
                    <div class="upload-btn-wrapper-1">
                        <button class="btn" style="color: grey"><i class="fas fa-camera-retro"></i> Foto's</button>
                        <input type="file" name="image[]" multiple accept="image/*" />
                    </div>
                    <div class="upload-btn-wrapper-1">
                        <button class="btn" style="color: grey"><i class="fas fa-video mx-2"></i>Videos</button>
                        <input type="file" name="video[]" multiple accept="video/*" />
                    </div>
                    <div class="upload-btn-wrapper-1">
                        <button class="btn" style="color: grey"><i class="fas fa-microphone mx-2"></i>Audio</button>
                        <input type="file" name="audio[]" multiple accept="audio/*" />
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-sm-12">
                        <div class="form-group row mb-0">
                            <h4 class="col-sm-12">Tagged Friends</h4>
                            <br>
                            <div class="col-sm-12 d-flex tag dropdown show">
                                <div class="input-group mb-2 d-flex" id="searchInput">
                                  <input type="text" class="form-control dropdown-toggle w-auto" id="inputTagged" placeholder="Find Friends">
                                  <div class="input-group-prepend" id="searchFriends">
                                    <div class="input-group-text"><span><i class="fa fa-search "></i> Search</span></div>
                                  </div>
                                </div>
                                <div class="dropdown-menu drop-menu-tag"></div>
                            </div>
                            <div class="col-sm-12 tag-users bg-light">
                                <div class="row inner-tag-users mb-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 p-0">
                    <h4 class="mb-0">Shared With</h4>
                    <div class="form-check share-with">
                        <input class="form-check-input specific-friends" type="radio" name="status" id="exampleRadios1" value="0" checked>
                        <label class="form-check-label font-16 w-100" for="exampleRadios1">
                        Public
                        </label>
                    </div>
                    <div class="form-check share-with">
                        <input class="form-check-input specific-friends" type="radio" name="status" id="exampleRadios2" value="1">
                        <label class="form-check-label font-16 w-100" for="exampleRadios2">
                        Friends
                        </label>
                    </div>
                    <div class="form-check share-with">
                        <input class="form-check-input specific-friends" type="radio" name="status" id="exampleRadios3" value="2">
                        <label class="form-check-label font-16 w-100" for="exampleRadios3">
                        Specific Friends
                        </label>
                        
                    </div>
                    <div class="mt-3 select-friends" style="display:none;">
                        <div class="d-flex specific dropdown show">
                            <div class="input-group d-flex" id="searchInputSpecific">
                                <input type="text" class="form-control dropdown-toggle w-auto" id="inputspecific" placeholder="Find Friends">
                            </div>
                            <div class="dropdown-menu drop-menu-specific mt-0 w-100"></div>
                        </div>
                        <div class="specific-users bg-light m-4">
                            <div class="row inner-specific-users mb-0"></div>
                        </div>
                    </div>
                </div>
                <button
                type="submit" class="p-0 btn btn-full w-75 mb-3 mx-auto rounded-xs text-uppercase font-900 bg-magenta-dark mt-5"><i
                        class="fas fa-share-alt m-0 pr-2"></i>Delen</button>


            </form>
            </div>
        </div>
    </div>


    <div id="menu-share-thumbs2" class="menu menu-box-modal  " data-menu-height="600" data-menu-width="900">
        <div class="menu-title">
            <h4 class="px-3 mt-3">CheckIn</h4>
            <a href="#" class="close-menu "><i class="fa fa-times-circle mt-1 color-dark"></i></a>
        </div>
        <div class="divider divider-margins mt-3 mb-0"></div>
        <div class="content mt-3">
            <div class="list-group list-custom-small ">
                <div class="search-box search-dark add-post-input shadow-xl border-0 bg-theme  bottom-0">
                    <i class="fa fa-search mx-2"></i>
                    <input type="text" class="border-0 font-25" placeholder="Zoek Plek of evenement " data-search="">
                </div>
                <div class="input-style input-style-1 input-required pt-5 ">

                    <div class="d-flex mt-4 ">

                        <textarea placeholder="Vertel iets over deze spot" type="text" class="font-18"></textarea>

                    </div>

                </div>
                <div class="d-flex">
                    <div class="upload-btn-wrapper-1">
                        <button class="btn-1"><i class="fas fa-camera-retro mx-2"></i> Foto's</button>
                        <input type="file" name="myfile" />
                    </div>
                    <div class="upload-btn-wrapper-1">
                        <button class="btn-1"><i class="fas fa-video mx-2"></i>Videos</button>
                        <input type="file" name="myfile" />
                    </div>
                    <div class="upload-btn-wrapper-1">
                        <button class="btn-1"><i class="fas fa-user-friends mx-2"></i>Kies Vrienden</button>

                    </div>

                </div>
                <div class="input-style input-style-2 input-required">
                    <span class="">Select </span>
                    <em><i class="fas fa-sort"></i></em>
                    <select class="form-control">
                        <option value="default" disabled="" selected="">Select </option>
                        <option value="iOS">Tagged Suggestion</option>
                        <option value="Linux">Share Suggestion</option>

                    </select>
                </div>
                    <button
                        class="p-0 btn btn-full w-75 mb-3 mx-auto rounded-xs text-uppercase font-900 bg-magenta-dark mt-5"><i
                            class="fas fa-share-alt mx-2"></i>Check In</button>
            </div>
        </div>
    </div>
    @if(Session::has('success'))
    <div id="menu-success-1" class="menu menu-box-bottom rounded-m" data-menu-height="185" data-menu-effect="menu-over"
        style="display: block; height: 185px;">
        <div class="menu-title">
            <i class="fa fa-check-circle scale-box float-left mr-3 ml-3 fa-4x color-green-dark"></i>
            <p class="color-magenta-dark">{{Session::has('success')}}</p>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

    </div>
    @endif

    </div>
    <div id="menu-option-2" class="menu menu-box-modal rounded-m  bg-white options" data-menu-height="220"
        data-menu-width="500" style="height: 200px; width: 350px; display: block;">
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
    <div id="menu-option-3" class="menu menu-box-modal rounded-m bg-white options" data-menu-height="220"
        data-menu-width="500" style="height: 200px; width: 350px; display: block;">
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
    <div id="menu-option-4" class="menu menu-box-modal rounded-m bg-white options" data-menu-height="180"
        data-menu-width="500" style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">
            <h1 class="color-black font-20">Share Spots</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="divider mb-3"></div>
            <div class="input-style input-style-2 input-required">

                <em><i class="fas fa-caret-down"></i></em>
                <select class="form-control">
                    <option value="default" selected="">Share</option>
                    <option value="iOS">Friends</option>
                    <option value="Linux">Groups</option>

                </select>

            </div>
        </div>

    </div>
    </div>
@endsection
