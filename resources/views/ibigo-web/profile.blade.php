@extends('../layouts/main_web_layout')
@if(request()->route()->uri == 'profile') 
    @section('title', 'Ibigo | Profile') 
@elseif(request()->route()->uri == 'interest') 
    @section('title', 'Ibigo | Interests') 
@elseif(request()->route()->uri == 'notifications') 
    @section('title', 'Ibigo | Notifications') 
@endif
@section('content')


    <div class="page-content">
        <div class="container mt-5 px-lg-5 friends-container">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                    <div class="card card-style bg-theme pb-5">
                        <div class="content">
                            <div class="tab-controls tabs-round tab-animated tabs-small tabs-rounded shadow-xl"
                                data-tab-items="4" data-tab-active="bg-magenta-dark color-white">
                                <a data-tab="tab-1" href="{{url('/profile')}}" @if(request()->route()->uri == 'profile') data-tab-active="" @endif><i
                                        class="fas fa-user-alt mx-2"></i>My Profile</a>
                                <a href="#" data-tab="tab-2"><i
                                        class="fas fa-wrench mx-2"></i>Wachtwoord</a>
                                <a data-tab="tab-3"  href="{{url('/interest')}}" @if(request()->route()->uri == 'interest') data-tab-active="" @endif><i
                                        class="fas fa-qrcode mx-2"></i>Intereses</a>
                                <a data-tab="tab-4"  href="{{url('/notifications')}}" @if(request()->route()->uri == 'notifications') data-tab-active="" @endif><i
                                        class="fas fa-bell mx-2"></i>Notification</a>
                            </div>
                        </div>
                        <div class="clearfix mb-3"></div>
                        <div class="container">
                            <div class="tab-content" id="tab-1" style="display: none; width: 100%;">
                                <form action="{{ url('/ibigo-web/update/'.$user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex">
                                        <h4 class="px-2">Wijzig profiel</h4>
                                        <a class="btn  btn-sm  rounded-s font-13 font-600 profilebtn " href="{{url('/update-profile')}}">Bekijk
                                            profiel</a>
                                    </div>
                                    <div class="text-center">
                                        <div style="background-image: @if($user->user_profile)url({{asset('storage/images/user/profile/'.$user->user_profile)}}) @else url({{asset('ibigo-web/images/avatars/2m.png')}}) @endif; width: 235px; height: 235px; border-radius: 100%!important; " class="m-auto position-relative rounded-lg home-img ">

                                            <div class="upload-btn-wrapper">
                                                <button class="profile-btn"><i class="fas fa-pen"></i></button>
                                                <input type="file" name="user_profile" value="{{$user->user_profile}}" accept="image/*" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-style input-style-2 mb-3 pb-1 mt-4">
                                        <span class="input-style-1-active">First Name</span>
                                        <em>(required)</em>
                                        <input type="text" placeholder="First Name" value="{{$user->first_name}}" name="first_name" >
                                    </div>
                                    @if($errors->get('first_name'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{$errors->first('first_name')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    <div class="input-style input-style-2 mb-3 pb-1 mt-4">
                                        <span class="input-style-1-active">Last Name</span>
                                        <em>(required)</em>
                                        <input type="text" placeholder="Last Name" value="{{$user->last_name}}" name="last_name" >
                                    </div>
                                    <div class="input-style input-style-2 mb-3 pb-1 mt-4">
                                        <span class="input-style-1-active">Mobile</span>
                                        <em>(required)</em>
                                        <input type="tel" placeholder="Mobile Number" value="{{$user->mobile}}" name="mobile">
                                    </div>
                                    <div class="input-style input-style-2 input-required">
                                        <span class="input-style-1-active input-style-1-inactive">About me</span>
                                        <textarea class="form-control" placeholder="Enter your Message"
                                        name="user_about">{{$user->user_about}}</textarea>
                                        <button
                                        type="submit"
                                            class="btn profile-submit-button btn-m btn-full rounded text-capitalize font-900 shadow-s bg-magenta-dark mt-4 mb-4"
                                            style="width: 20%; border-radius:10px !important;"> Bevestigen </button>
                                    </div>



                                </form>
                            </div>
                        <div class="tab-content" id="tab-2" style="display: none; width: 100%;">
                            <h4 class="pb-4 px-2">Wijzig Wachtwoord</h4>
                            <form action="{{ url('/password/edit') }}" method="POST">
                                @csrf
                            <div class="input-style input-style-2 mb-3 pb-1 mt-4">
                                <span class="input-style-1-active ">Oud Wachtwoord</span>
                                <em>(required)</em>
                                <input type="password" name="old_password">
                            </div>
                            @if($errors->get('old_password'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{$errors->first('old_password')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="input-style input-style-2 mb-3 pb-1 mt-4">
                                <span class="input-style-1-active ">Nieuw Wachtwoord</span>
                                <em>(required)</em>
                                <input type="password" name="password">
                            </div>
                            @if($errors->get('password'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{$errors->first('password')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="input-style input-style-2 mb-3 pb-1 mt-4">
                                <span class="input-style-1-active ">Wijzig Wachtwoord</span>
                                <em>(required)</em>
                                <input type="password" name="confirm_password">
                            </div>
                            <button
                            type="submit"
                                class="btn profile-submit-button btn-m btn-full text-capitalize font-900 shadow-s bg-magenta-dark mt-4 mb-4"
                                style="width: 20%; border-radius:10px !important;"> Bevestigen </button>
                        </form>
                        </div>

                        <div class="tab-content" id="tab-4" style="display: none; width: 100%;">
                            <h4 class="pb-4 px-2">Notificaties</h4>

                            <div class="row mb-0 pb-4 px-2">
                                @foreach ($notification as $notifications)
                                    <div class="col-sm-12 mb-2 noti">
                                        <input type="hidden" class="notiId" value="{{$notifications['id']}}">
                                        <p class="font-14 py-2 px-3 
                                            @if($notifications['is_read'] == 0)
                                            bg-magenta-dark
                                            @else
                                            bg-transparent 
                                            @endif
                                            " style="border-radius:30px;">
                                            <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/people/'.$notifications['from_user']['unique_id'].'/'.$notifications['from_user']['user_slug'])}}">{{$notifications['from_user']['fullname']}} </a>
                                            @if($notifications['notification_type'] == 'invite-in-event')
                                                is invited you in <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/event/'.$notifications['event']['event_unique_id'].'/'.$notifications['event']['event_slug'])}}">{{$notifications['event']['event_title']}}</a> event
                                            @elseif($notifications['notification_type'] == 'friend-request')
                                                is sent you a friend request
                                                <a href="{{url('/reject-request/'.$notifications['from_user']['id'])}}" class="ml-2">
                                                    <i class="far fa-times-circle text-danger"></i>
                                                </a>
                                                <a href="{{url('/accept-request/'.$notifications['from_user']['id'])}}" class="ml-2">
                                                    <i class="far fa-check-circle text-success"></i>
                                                </a>
                                            @elseif($notifications['notification_type'] == 'accept-request')
                                                is accepted your friend request
                                                <a href="{{url('/unfriend/'.$notifications['from_user']['id'])}}" class="ml-2 text-danger">
                                                    <i class="far fa-times-circle text-danger"></i> Unfriend
                                                </a>
                                            @elseif($notifications['notification_type'] == 'reject-request')
                                                is rejected your friend request
                                                <a href="{{url('/send-request/'.$notifications['from_user']['id'])}}" class="ml-2 text-success">
                                                    <i class="far fa-check-circle text-success"></i> Add Friend
                                                </a>
                                            @elseif($notifications['notification_type'] == 'invite-in-group')
                                                is invited you in <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/groups/'.$notifications['group']['group_unique_id'].'/'.$notifications['group']['group_slug'])}}">{{$notifications['group']['group_name']}}</a> group
                                            @elseif($notifications['notification_type'] == 'invite-in-group-as-an-admin')
                                                is invited you in <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/groups/'.$notifications['group']['group_unique_id'].'/'.$notifications['group']['group_slug'])}}">{{$notifications['group']['group_name']}}</a> group as an Admin
                                            @elseif($notifications['notification_type'] == 'join-request-to-group')
                                                is sent you in a request to join a <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/groups/'.$notifications['group']['group_unique_id'].'/'.$notifications['group']['group_slug'])}}">{{$notifications['group']['group_name']}}</a> group as an Admin
                                            @elseif($notifications['notification_type'] == 'accept-request-of-group')
                                                is accepted your request in <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/groups/'.$notifications['group']['group_unique_id'].'/'.$notifications['group']['group_slug'])}}">{{$notifications['group']['group_name']}}</a> group as an Admin
                                            @elseif($notifications['notification_type'] == 'confirm-group-invitation')
                                                is accepted your invitation in <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/groups/'.$notifications['group']['group_unique_id'].'/'.$notifications['group']['group_slug'])}}">{{$notifications['group']['group_name']}}</a> group as an Admin
                                            @elseif($notifications['notification_type'] == 'reject-group-invitation')
                                                is rejected your invitation in <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/groups/'.$notifications['group']['group_unique_id'].'/'.$notifications['group']['group_slug'])}}">{{$notifications['group']['group_name']}}</a> group as an Admin
                                            @elseif($notifications['notification_type'] == 'tagged-in-the-post')
                                                is tagged you in a <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="">post</a>
                                            @elseif($notifications['notification_type'] == 'invite-in-spot')
                                                is invited you in a <a class="@if($notifications['is_read'] == 0)
                                            text-light
                                            @else
                                            color-magenta-dark 
                                            @endif font-weight-bold" href="{{url('/spots/'.$notifications['spot']['user_spot']['unique_id'].'/'.$notifications['spot']['user_spot']['user_slug'])}}">{{$notifications['spot']['business_name']}}</a>
                                            @endif
                                            <i class="float-right"><b>{{$notifications['how_long'] }}</b></i>
                                        </p>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-content" id="tab-3" style="display: none; width: 100%;">
                            <h4 class="mx-2">Interesses</h4>
                            @foreach ($interest as $interests)
                            <form action="{{url('/change-interest/'.$interests->id)}}" method="POST">
                                @csrf
                                <div class="list-group list-custom-small list-menu ml-0 mr-2 pt-4">
                                    <a href="#" data-trigger-switch="switch-{{$interests->id}}a">
                                        <h5 class="mx-2 text-capitalize">{{$interests->title}}</h5>
                                        <div class="custom-control custom-switch pt-3 px-2 mr-3">
                                            <input name="interest" value="{{$interests->id}}" type="checkbox" class="custom-control-input " id="switch-{{$interests->id}}a"
                                                @if($user->user_interests)
                                                    @foreach (explode(',',$user->user_interests) as $userInterests)
                                                        @if($interests->id == $userInterests)
                                                            checked
                                                        @endif
                                                    @endforeach
                                                @endif
                                            >
                                            <label id="switch-{{$interests->id}}b" class="custom-control-label checkInterest" for="switch-{{$interests->id}}a"></label>
                                        </div>
                                    </a>
                                </div>
                                <button class="interest-btn" type="submit" for="switch-{{$interests->id}}a"></button>
                            </form>
                            @endforeach

                        </div>
                    </div>

                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper card card-style mt-0">

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

                        <div class="card card-style profile-card w-100">
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
        <!-- Page content ends here-->




    </div>

@endsection
