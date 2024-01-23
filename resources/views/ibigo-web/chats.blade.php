@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Chats')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 col-md-5 order-md-0 order-1 mt-md-0 mt-sm-5">
                <div class="card card-style chats-card-2">
                    <div class="content chat-friends">
                        <h3 class="color-dark">Recent Chats</h3>
                        <div class="mt-4 form-control mb-3 bg-theme rounded-lg bottom-0">
                            <i class="fa fa-search"></i>
                            <input type="text" class="border-0 bg-transparent search-friend-list" placeholder="Zoeken"
                                data-search="">
                        </div>
                        <input type="hidden" class="authId" value="{{Auth::user()->id}}">
                        @if($chatFriends)
                            @foreach($chatFriends as $chats)
                                <a class="show-msg-box" href="#">
                                    <input type="hidden" class="userId" value="{{$chats['id']}}">
                                    <div class="d-flex">
                                        <div style="background-image: url(@if($chats['user_profile']){{asset('storage/images/user/profile/'.$chats['user_profile'])}}@else{{asset('ibigo-web/images/avatars/2m.png')}}@endif); width: 70px; height: 70px;"
                                            class="home-img my-auto"></div>
                                        <div class="mt-3 mx-2">
                                            <span style="color: gray;">{{$chats['fullname']}}</span>
                                            <p>{{$chats['message']}}</p>
                                        </div>
                                        <!-- @if($chats['count'] > 0)
                                            <div class="bg-magenta-dark rounded-circle h-25 color-white px-2 ml-auto my-auto hide-count">
                                                {{$chats['count']}}
                                            </div>
                                        @endif -->
                                    </div>
                                </a>
                                <div class="divider mb-2 mt-1"></div>
                            @endforeach
                        @endif
                        <h3>Friends</h3>
                        <div class="mt-4 form-control bg-theme rounded-lg bottom-0 mb-4">
                            <i class="fa fa-search"></i>
                            <input type="text" class="border-0 bg-transparent search-friend-list"
                                placeholder="Search Friends" data-search="">
                        </div>
                        @if($friends)
                            @foreach($friends as $friend)
                                <a class="show-msg-box" href="#">
                                    <input type="hidden" class="userId" value="{{$friend['id']}}">
                                    <div class="d-flex">

                                        <div style="background-image: url(@if($friend['user_profile']){{asset('storage/images/user/profile/'.$friend['user_profile'])}}@else{{asset('ibigo-web/images/avatars/2m.png')}}@endif); width: 70px; height: 70px;"
                                            class="home-img"></div>
                                        <span class=" my-auto mx-2" style="color: gray;">{{$friend['fullname']}}</span>
                                        <p></p>
                                    </div>
                                </a>
                                <div class="divider mb-2 mt-1"></div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div id="msg-box" class="p-0 page-content" style="transform: translate(0px, 0px);display: none;">

                    <div class="chat-messgaes content mt-0 py-3 mb-n5 card-style chats-card-3 rounded-l container ">
                        <em class="speech-read mb-4">Delivered &amp; Read - 07:18 PM</em>
                    </div>

                </div>
                <div id="empty-msg-box" class="card card-style chats-card m-0">
                    <div class="text-center" style="padding-top: 20%;">
                        <i class="fa fa-comments fa-5x color-magenta-dark" style="display: block; "></i>
                        <p>Start chat</p>
                    </div>
                    <div class="ml-3 speach-icon friend-list d-block d-lg-none">
                        <a href="#" class="bg-gray-dark color-white mr-2" data-menu="menu-call"><i
                                class="fa fa-users fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <div id="menu-call" class="menu menu-box-modal rounded-m" data-menu-height="500" data-menu-width="350"
            style="height: 330px; width: 350px;">
            <div class="menu-title d-flex justify-content-between px-3">

                <h3 class="mt-3">Friends</h3>
                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            </div>
            <div class="content">

                <div class="divider mb-3 mt-1"></div>

                <div class="mt-4 form-control bg-theme rounded-lg bottom-0 mb-4 position-relative">
                    <i class="fa fa-search"></i>
                    <input type="text" class="border-0 bg-transparent search-friend-list position-absolute"
                        placeholder="Search Friends" data-search="" style="top: 10%;">
                </div>
                @if($chatFriends)
                    @foreach($chatFriends as $chats)
                        <a class="show-msg-box close-menu" href="#">
                            <input type="hidden" class="userId" value="{{$chats['id']}}">
                            <div class="d-flex">

                                <div style="background-image: url(@if($chats['user_profile']){{asset('storage/images/user/profile/'.$chats['user_profile'])}}@else{{asset('ibigo-web/images/avatars/2m.png')}}@endif); width: 70px; height: 70px;"
                                    class="home-img my-auto"></div>
                                <div class="mt-3 mx-2">
                                    <span style="color: gray;">{{$chats['fullname']}}</span>
                                    <p>{{$chats['message']}}</p>
                                </div>
                                <!-- @if($chats['count'] > 0)
                                    <div class="bg-magenta-dark rounded-circle h-25 color-white px-2 ml-auto my-auto">
                                        {{$chats['count']}}
                                    </div>
                                @endif -->
                            </div>
                        </a>
                        <div class="divider mb-2 mt-1"></div>
                    @endforeach
                @endif
                <h3 class="color-dark mt-4">Recent Chats</h3>
                <div class="mt-4 form-control mb-3 bg-theme rounded-lg bottom-0 position-relative">
                    <i class="fa fa-search"></i>
                    <input type="text" class="border-0 bg-transparent search-friend-list position-absolute"
                        placeholder="Zoeken" data-search="" style="top: 10%;">
                </div>
                @if($friends)
                    @foreach($friends as $friend)
                        <a class="show-msg-box close-menu" href="#">
                            <input type="hidden" class="userId" value="{{$friend['id']}}">
                            <div class="d-flex">

                                <div style="background-image: url(@if($friend['user_profile']){{asset('storage/images/user/profile/'.$friend['user_profile'])}}@else{{asset('ibigo-web/images/avatars/2m.png')}}@endif); width: 70px; height: 70px;"
                                    class="home-img"></div>
                                <span class=" my-auto mx-2" style="color: gray;">{{$friend['fullname']}}</span>
                                <p></p>
                            </div>
                        </a>
                        <div class="divider mb-2 mt-1"></div>
                    @endforeach
                @endif
            </div>
        </div>
@endsection
