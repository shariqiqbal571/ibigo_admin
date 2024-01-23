@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Group | '.$group[0]['group_name'])
@section('content')



    <div class="page-content">
        <div class="container">
            <div class="card card-style bg-6 mt-5" data-card-height="50vh"
                style="background-image: url(@if($group[0]['group_cover']){{asset('storage/images/group/group_cover/'.$group[0]['group_cover'])}}@else{{asset('ibigo-web/images/100920104705-banner-3a.jpg')}}@endif);">

                <div class="card-top">


                </div>
                <div class="card-bottom ml-3 mr-3">

                    <h1 class="font-40 line-height-xl color-white">{{$group[0]['group_name']}}</h1>
                    <p class="mb-4">{{$group[0]['group_users_count']}} {{($group[0]['group_users_count'] > 1)?'members':'member'}}</p>

                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="row mb-0">
                        <div class="col-lg-4 col-sm-12 my-2">
                            <a href="{{url('/group-chat')}}" class="btn rounded-sm btn-lg bg-magenta-dark font-16"
                                style="width: 100%;">Message</a>
                        </div>
                        <div class="col-lg-4 col-sm-12 my-2">
                            <a href="#" data-menu="menu-call" class="btn rounded-sm btn-lg bg-magenta-dark font-16"
                                style="width: 100%;"><i class="fa fa-plus mx-2"></i> Plaats bericht</a>
                        </div>

                    </div>

                </div>

            </div>
                <div class="card card-style">
                    <div class="content mb-4">
                        <h1>Group Member</h1>
                        @if($group[0]['group_users'])
                            <div class="row mb-0">
                                @foreach($group[0]['group_users'] as $users)
                                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-4">
                                        <a href="{{url('/people/'.$users['user']['unique_id'].'/'.$users['user']['user_slug'])}}" class="text-center"><img src="@if($users['user']['user_profile']) {{asset('storage/images/user/profile/'.$users['user']['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif" alt="" width="50px" height="50px" class="rounded-l home-img mx-auto">
                                            <p >{{$users['user']['fullname']}}</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No Member</p>
                        @endif
                    </div>
                </div>
                <div class="card card-style">
                    <div class="content mb-4">
                        <h1>Requested User</h1>
                        @if($group[0]['requested_user'])
                            <div class="row mb-0">
                                @foreach($group[0]['requested_user'] as $users)
                                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 col-4">
                                        <a href="{{url('/people/'.$users['user']['unique_id'].'/'.$users['user']['user_slug'])}}" class="text-center"><img src="@if($users['user']['user_profile']) {{asset('storage/images/user/profile/'.$users['user']['user_profile'])}} @else {{asset('ibigo-web/images/avatars/2m.png')}} @endif" alt="" width="50px" height="50px" class="rounded-l home-img mx-auto">
                                            <p >{{$users['user']['fullname']}}</p>
                                        </a>
                                        <div class="d-flex justify-content-around">
                                            <form action="{{url('/make-member/'.$group[0]['id'])}}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{$users['user']['id']}}" name="user_id">                                                
                                                <input type="hidden" value="3" name="status">
                                                <button type="submit" class="text-success bg-transparent border-0"><i class="fas fa-check"></i></button>
                                            </form>
                                            <form action="{{url('/reject-member/'.$group[0]['id'])}}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{$users['user']['id']}}" name="user_id">                                                
                                                <input type="hidden" value="2" name="status">
                                                <button type="submit" class="text-danger bg-transparent border-0"><i class="fas fa-times"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No Request</p>
                        @endif
                    </div>
                </div>
                @if($group[0]['post'])
                    @foreach($group[0]['post'] as $post)
                        <div class="col-sm-12 p-0">
                            <div class="card card-style">
                                <div class="content">
                                    <div class="d-flex">

                                        <div class="mr-3">
                                            <a href="{{ url('profile') }}">
                                                <div class=" home-img rounded-sm shadow-xl" style="
                                                    background-image: url(@if($post['user_post']['user_profile']){{asset('storage/images/user/profile/'.$post['user_post']['user_profile'])}}@else{{asset('ibigo-web/images/avatars/2m.png')}}@endif);
                                                    width: 100px;
                                                    height: 100px;"
                                                ></div>
                                            </a>
                                        </div>
                                        <div>
                                            <p class=" font-500 mb-n1">{{$post['time']}} ago</p>
                                            <h2>{{$post['user_post']['fullname']}}</h2>
                                            <p>{{$post['description']}}</p>
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
                                                    <h6>{{url('update-profile')}}                                              <span class="ml-2">1 min ago</span>
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
                                @if($post['post_audios'])
                                    @foreach($post['post_audios'] as $audios)
                                        <div style="height:fit-content;background-color: #f1f3f4;">
                                            <audio controls>
                                                <source src="{{asset('storage/audios/post/audios/'.$audios['post_audios'])}}">
                                            </audio>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="row mb-0" style="overflow: hidden; background-color:#fff;">
                                    @if($post['post_images'])
                                        @foreach($post['post_images'] as $images)
                                            <div class="col-md-6 p-0">
                                                <figure class="figure w-100 m-0">
                                                    <img src="{{asset('storage/images/post/images/'.$images['post_images'])}}" class="m-0 figure-img rounded" alt="...">
                                                </figure>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($post['post_videos'])
                                        @foreach($post['post_videos'] as $videos)
                                            <div class="col-md-6 p-0">
                                                <video controls>
                                                    <source src="{{asset('storage/videos/post/videos/'.$videos['post_videos'])}}">
                                                </video>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="go-btn">
                                <a href="" data-menu="menu-share">
                                    <button type="button" class="btn btn-light bg-magenta-dark">+Go</button></a>
                            </div>
                        </div>
                    @endforeach
                @endif
        </div>
    </div>
    <!-- Page content ends here-->

    <div id="menu-call" class="menu menu-box-modal rounded-m " data-menu-height="500" data-menu-width="350"
        style="display: block; height: 330px; width: 350px;">
        <div class="menu-title">
            <p class="color-magenta-dark">Share</p>
            <h1>Post</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            <hr>
        </div>
        <div class="content">

            <div class="input-style input-style-1 input-required">
                <span class="color-highlight input-style-1-inactive">Vertal je ervaring</span>
                <em>(required)</em>
                <textarea placeholder="Vertal je ervaring" style="height: 150px!important;"></textarea>
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
            <a href="#">
                <button
                    class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark mt-4">Delen</button></a>
        </div>
    </div>

    <!-- Share Menu-->


    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
        data-menu-height="480"></div>


    </div>

@endsection
