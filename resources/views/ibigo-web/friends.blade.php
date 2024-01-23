@extends('../layouts/main_web_layout')

@if(request()->route()->uri == 'friends') 
    @section('title', 'Ibigo | Friends') 
@elseif(request()->route()->uri == 'groups') 
    @section('title', 'Ibigo | Groups') 
@elseif(request()->route()->uri == 'spots') 
    @section('title', 'Ibigo | Spots') 
@endif


@section('content')

    <!-- </div> -->

    <div class="container mt-5 px-lg-5 friends-container">

        <div class="row">
            <div class="col-12">

                <div class="fixed-btns mb-5">
                    <div class="createplane" style="display: @if($routeName == 'spots')  block @else none @endif ;">
                        <a class="btn btn-md btn-full show-spot-modal create-button rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s m-auto  w-100" href="#" data-menu="menu-share3">
                            Plan je uitje
                        </a>

                    </div>
                    <div class="creategroup"  style="display: @if($routeName == 'groups')  block @else none @endif ;">
                        <a class="btn btn-md show-group-modal btn-full create-button rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s  m-auto w-100" href="#" data-menu="menu-share1">
                            Create Group
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                <div class="tab-controls mr-0 ml-0 tabs-round tab-animated tabs-large tabs-rounded clearfix shadow-xl mb-4" data-tab-items="3" data-tab-active="bg-magenta-dark activated color-white">
                    <a class="friendactive friendplanactive" href="{{url('/friends')}}" @if($routeName == 'friends') data-tab-active @endif data-tab="tab-1"><i
                            class="fas fa-user-alt mx-2"></i>Friends</a>
                    <a class="groupactive groupplanactive " href="{{url('/groups')}}" @if($routeName == 'groups') data-tab-active @endif data-tab="tab-2"> <i class="fas fa-users mx-2"></i> Groups
                    </a>
                    <a class="spotactive spotplanactive" href="{{url('/spots')}}" @if($routeName == 'spots') data-tab-active @endif data-tab="tab-3"><i
                            class="fas fa-check-square mx-2"></i>Spots &
                        Events</a>
                </div>

                <div class="tab-1">

                    <div class="tab-content" id="tab-1" style="width: 100%!important;">
                        <div class="content ml-0 mr-0">
                            <div class="search-box  plan-search shadow-xl border-0 bg-theme rounded-sm bottom-0">
                                <i class="fa fa-search "></i>
                                <input type="text" class="border-0 mx-2" placeholder="Zoek je vrienden" data-search="">

                            </div>
                            <h4 class="mt-4 mb-4">Friends</h4>
                        </div>
                        <div class="card card-style mr-0" style="width: auto!important;">
                            <div class="content">
                                @if($friends)
                                    @foreach($friends as $friend)
                                        <div class="d-flex mb-3">
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
                                            <a href="{{url('/chat')}}" class="ml-auto align-self-center">
                                                <div class="font-40 color-black">
                                                    <i class="far fa-comment-dots font-30"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="divider mb-3"></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content tab-2" id="tab-2" style="width: 100%!important;">

                    <div class="content ml-0 mr-0">
                        <div class="search-box plan-search shadow-xl border-0 bg-theme rounded-sm bottom-0">
                            <i class="fa fa-search"></i>
                            <input type="text" class="border-0 mx-2" placeholder="Vind je groep" data-search="">

                        </div>
                        <h4 class="mt-4 mb-4">Groups Your manage</h4>

                    </div>
                    <div class="card card-style">
                        <div class="content">
                            @if($groups)
                                @foreach($groups as $group)
                                    <div class="d-flex mb-3">
                                        <a href="{{url('/groups/'.$group->group_unique_id.'/'.$group->group_slug)}}" class="d-flex">
                                            @if($group->group_profile)
                                                <div>
                                                    <img src="{{asset('storage/images/group/group_profile/'.$group->group_profile)}}" width="70" height="70" class="rounded-circle mr-3">
                                                </div>
                                            @else
                                                <div>
                                                    <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="70" height="70" class="rounded-circle mr-3">
                                                </div>
                                            @endif
                                            <div class="m-auto">
                                                <h5 class="font-16 font-600">{{$group->group_name}}</h5>
                                            </div>
                                        </a>
                                        <a href="{{url('/group-chat')}}" class="ml-auto align-self-center">
                                            <div class="font-40 color-black">
                                                <i class="fas fa-comments font-30"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="divider mb-3"></div>
                                @endforeach
                            @endif
                        </div>

                    </div>

                </div>
                <div class="tab-content" id="tab-3" style="width: 100%!important;">
                    <div class="content ml-0 mr-0">
                        <div class="search-box plan-search shadow-xl border-0 bg-theme rounded-sm bottom-0">
                            <i class="fa fa-search"></i>
                            <input type="text" class="border-0 mx-2" placeholder="Vind je groep" data-search="">

                        </div>


                        @if($spots)
                            <h4 class="mt-3 mb-3">Spots</h4>
                            <div class="content mx-0">
                                @foreach($spots as $spot)
                                    <div class="card card-style">
                                        <div class="content">
                                            <div class="row">
                                                @if($spot['user_spot']['user_profile'])
                                                    <div class="col-sm-2">
                                                        @if(strpos($spot['user_spot']['user_profile'], 'http') === 0)
                                                            <img width="100%" class="fluid-img rounded-lg shadow-xl" src="{{$spot['user_spot']['user_profile']}}">
                                                        @else
                                                            <img width="100%" class="fluid-img rounded-lg shadow-xl" src="{{asset('storage/images/user/profile/'.$spot['user_spot']['user_profile'])}}">
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="col-sm-10">
                                                    <div>
                                                        <a href="{{url('/spots/'.$spot['user_spot']['unique_id'].'/'.$spot['user_spot']['user_slug'])}}">
                                                            <h2>{{$spot['business_name']}}</h2>
                                                        </a>
                                                        <p class="my-2">{{$spot['short_description']}}</p>
                                                    </div>
                                                    <a href="{{url('https://www.google.com/maps/@'.$spot['latitude'].','.$spot['longitude'])}}" target="_blank">
                                                        <div class="d-flex">
                                                            <i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>
                                                            <p class="color-magenta-dark mx-2">{{$spot['full_address']}}</p>
                                                        </div>
                                                    </a>
                                                    @if($spot['spot_detail'])
                                                        <div class="d-flex mt-3">
                                                            <h5>Like by :</h5>
                                                            @foreach($spot['spot_detail'] as $spotDetail)
                                                                @if($spotDetail['user']['id'] != Auth::user()->id)
                                                                    @if($spotDetail['user']['user_profile'])
                                                                        <img class="rounded-circle mx-1" src="{{asset('storage/images/user/profile/'.$spotDetail['user']['user_profile'])}}" alt="" width="20" height="20">
                                                                    @else
                                                                        <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="20" height="20" class="rounded-circle mx-1">
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if($event)
                            <h4 class="mt-3 mb-3">Events</h4>
                            <div class="content mx-0 mb-5">
                                @foreach($event as $events)
                                    <div class="card card-style event-card card-bg-img" style="background-image: url({{asset('ibigo-web/images/17.jpg')}})">
                                        <div class="content m-0">
                                            <div class="d-flex">
                                                <div class="w-25" style="background-color: #fff; position: relative;">
                                                    <div class="m-auto text-center position-absolute">
                                                        <h1 class="font-30 text-uppercase font-900 opacity-30">{{$events['day']}}</h1>
                                                        <h3 class="font-24 font-900">{{$events['date']}}th</h3>
                                                    </div>
                                                </div>
                                                <div class="w-75 position-relative">
                                                    <div class="card-body w-100 pl-4" style="padding-bottom: 50px;">
                                                        <a href="{{url('/event/'.$events['event_unique_id'].'/'.$events['event_slug'])}}">
                                                            <h2 class="color-white pt-3 pb-3">{{$events['event_title']}}</h2>
                                                            <p class="text-white mb-5">{{substr($events['event_description'],'0','150')}}</p>
                                                        </a>
                                                        <p class="color-white mb-0">
                                                            <i class="fa fa-map-marker-alt color-white pr-2 icon-30"></i>
                                                            {{$events['event_location']}}
                                                        </p>
                                                        <p class="color-white mb-0">
                                                        <i class="color-white pr-2 icon-30 fas fa-user"></i>
                                                        Hosted By <a class="color-magenta-dark" href="{{url('/people/'.$events['user']['unique_id'].'/'.$events['user']['user_slug'])}}">{{$events['user']['fullname']}}</a>
                                                        </p>
                                                        <p class="color-white mb-0">
                                                        <i class="color-white pr-2 icon-30 fas fa-calendar-check"></i>
                                                                                                            {{$events['start_date']}} At {{$events['start_time']}} - {{$events['end_date']}} At {{$events['end_time']}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if(!$spots && !$event)
                            <h4 class="mt-3 mb-3">No result found for spots and events</h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                <div class="row">
                    <div class="col-sm-12 create-btns mb-3">
                        <div class="createplane"   style="display: @if($routeName == 'spots')  block @else none @endif ;">
                            <a class="btn btn-md btn-full show-spot-modal create-button rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s m-auto  w-100" href="#" data-menu="menu-share3">
                                Plan je uitje
                            </a>

                        </div>
                        <div class="creategroup"  style="display: @if($routeName == 'groups')  block @else none @endif ;">
                            <a class="btn btn-md show-group-modal btn-full create-button rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s  m-auto w-100" href="#" data-menu="menu-share1">
                                Create Group
                            </a>
                        </div>
                    </div>
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

    <div style="border-radius:30px;width:330px !important;" id="menu-share3" class="menu menu-box-modal bg-white container rounded-m" data-menu-height="470" data-menu-width="350">
        <div class="menu-title">
            <div class="d-flex justify-content-between">
                <h5 class="px-0 mt-3 color-magenta-dark">Add</h5>
                <a href="#" class="close-menu "><i style="opacity:0.6;"
                        class="fa fa-times-circle mt-1 color-dark"></i></a>
            </div>
            <h2 class="mx-0">Create Event</h2>
        </div>
        <div class="divider divider-margins mx-0 mt-3 mb-4"></div>
        <form action="{{url('/create-event')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-0" style="height: 285px;overflow: scroll;">
                <input type="text" name="event_title" placeholder="Event Title" class="form-control rounded-xl ">
                <div class="container">

                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="row mb-0">
                                <div class="col-sm-6 col-12 p-0 my-4">
                                    <input type="text" name="start_date" placeholder="Start Date" id="datepicker" autocomplete="off" class="start-date-input form-control rounded-xl">
                                </div>
                                <div class="col-sm-3 col-6 time p-0">
                                    <div class="row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-up">
                                                <i class="fas fa-angle-up font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                        <div class="col-sm-12 p-0 time-hours">
                                            <input type="text" name="start_hours" value="HH" class="time-hours-input text-center set-timing form-control rounded-lg m-auto" width="50px" height="50px">
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-down">
                                                <i class="fas fa-angle-down font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6 p-0">
                                    <div class="row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-up-2">
                                                <i class="fas fa-angle-up font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                        <div class="col-sm-12 p-0 time-mins">
                                            <input type="text" name="start_mins" value="MM" class="time-mins-input text-center set-timing form-control rounded-lg m-auto" width="50px" height="50px">
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-down-2">
                                                <i class="fas fa-angle-down font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row mb-0">

                                <div class="col-sm-6 col-12 p-0 my-4">
                                    <input type="text" name="end_date" placeholder="End Date" id="datepicker1" class="start-date-input form-control rounded-xl">
                                </div>
                                <div class="col-sm-3 col-6 time p-0">
                                    <div class="row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-up">
                                                <i class="fas fa-angle-up font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                        <div class="col-sm-12 p-0 time-hours">
                                            <input type="text" name="end_hours" value="HH" class="time-hours-input text-center set-timing form-control rounded-lg m-auto" width="50px" height="50px">
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-down">
                                                <i class="fas fa-angle-down font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-6 p-0">
                                    <div class="row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-up-2">
                                                <i class="fas fa-angle-up font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                        <div class="col-sm-12 p-0 time-mins">
                                            <input type="text" name="end_mins" value="MM" class="time-mins-input text-center set-timing form-control rounded-lg m-auto" width="50px" height="50px">
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="time-down-2">
                                                <i class="fas fa-angle-down font-20 text-secondary"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <h5 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">SPOTS TO EVENTS</h5>
                <div class="spots-evetns container border mb-3" style="display:none;">
                    <div class="row mb-0 p-3"></div>
                </div>
                <h5 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">SUGGESTION</h5>
                @if($spots)
                    <div class="search-box rounded" style="line-height:0;">
                        <input type="text" class="pl-3 py-0 border-0" placeholder="Search Spots" data-search="">
                    </div>
                    <div class="container">
                        @foreach($spots as $spot)
                        <a href="#" class="mt-4 spots row mb-0">
                            <div class="col-sm-2 p-0">
                                @if(strpos($spot['user_spot']['user_profile'], 'http') === 0)
                                    <img width="50" height="50" class="rounded-circle" src="{{$spot['user_spot']['user_profile']}}">
                                @else
                                    <img width="50" height="50" class="rounded-circle" src="{{asset('storage/images/user/profile/'.$spot['user_spot']['user_profile'])}}">
                                @endif
                            </div>
                            <div class="col-sm-10 spot-name my-auto ">
                                <h6 class="my-auto">{{$spot['business_name']}}</h6>
                            </div>
                            <input type="hidden" class="spot-id" value="{{$spot['id']}}">
                        </a>
                        @endforeach
                    </div>
                @endif -->
                <input type="text" name="location" placeholder="Location" class="form-control mt-4 rounded-xl">
                <textarea name="description" id="" cols="30" rows="10" placeholder="Vertel iets over deze event" class="form-control rounded-sm mt-3" style="width: 100%;"></textarea>
                <h5 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">INVITE PEOPLE OR GROUP TO EVENT</h5>
                <div class="invite-people container">
                    <div class="row mb-0"></div>
                </div>
                <h5 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">SUGGESTION</h5>
                <div class="search-box rounded" style="line-height:0;">

                    <input type="text" class="pl-3 py-0 border-0" placeholder="Search Friends" data-search="">

                </div>
                <div class="my-3 container">
                    @if($friends)
                    <h4 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">Friends</h4>
                        @foreach($friends as $friend)
                            <a href="#" class="row mb-0 friends py-1">
                                @if($friend->user_profile)
                                    <div class="col-xs-2">
                                        <img src="{{asset('storage/images/user/profile/'.$friend->user_profile)}}" width="40" height="40" class="rounded-circle mr-3">
                                    </div>
                                @else
                                    <div class="col-xs-2">
                                        <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="40" height="40" class="rounded-circle mr-3">
                                    </div>
                                @endif
                                <div class="friend-name col-xs-8 my-auto">
                                    <h5 class="font-16 font-600">{{$friend->fullname}}</h5>
                                </div>
                                <input type="hidden" class="friend-id" value="{{$friend->id}}">
                            </a>
                        @endforeach
                    @endif
                    @if($groups)
                    <h4 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">Groups</h4>
                        @foreach($groups as $group)
                            <a href="#" class="row mb-0 groups py-1">
                                @if($group->group_profile)
                                    <div class="col-xs-2">
                                        <img src="{{asset('storage/images/group/group_profile/'.$group->group_profile)}}" width="40" height="40" class="rounded-circle mr-3">
                                    </div>
                                @else
                                    <div class="col-xs-2">
                                        <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="40" height="40" class="rounded-circle mr-3">
                                    </div>
                                @endif
                                <div class="group-name col-xs-8 my-auto">
                                    <h5 class="font-16 font-600">{{$group->group_name}}</h5>
                                </div>
                                <input type="hidden" class="group-id" value="{{$group->id}}">
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark">Create</button>
            </div>
        </form>
    </div>

    <div style="border-radius:30px;width:330px !important;" id="menu-share1" class="add-group menu menu-box-modal bg-white container" data-menu-height="470" data-menu-width="330">
        <div class="menu-title">
            <div class="d-flex justify-content-between">
                <h5 class="px-0 mt-3 color-magenta-dark">Add</h5>
                <a href="#" class="close-menu "><i style="opacity:0.6;"
                        class="fa fa-times-circle mt-1 color-dark"></i></a>
            </div>
            <h2 class="mx-0">Create new group</h2>
        </div>
        <div class="divider divider-margins mt-3 mb-0 mx-0"></div>
        <form action="{{url('/create-group')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-0" style="height: 315px; overflow:scroll">
                <div class="menu-main">
                    <p class="mt-4 mr-2 mb-1">Group Name</p>
                    <div class="search-box rounded" style="line-height:0;">

                        <input type="text" class="pl-3 py-0 border-0" id="group-name" name="group_name" placeholder="Group Name" data-search="">

                    </div>
                    <p class="mt-4 mr-2 mb-1">Group Profile</p>
                    <div class="px-3 search-box rounded">
                        <input id="groupProfile" class="upload-profile" name="group_profile" accept="image/*" type="file" class="pl-3 py-0 border-0" style="display:none;" placeholder="Group Profile" data-search="">
                        <label for="groupProfile" class="m-0">Upload Group Profile</label>
                    </div>
                    <img class="imagesrcprofile" style="display: none;" src="" id="upload-profile" height="120px" width="100" />

                    <p class="mt-4 mr-2 mb-1">Cover Photo</p>
                    <div class="px-3 search-box rounded">
                        <input id="groupPhoto" class="upload-image" name="group_cover" accept="image/*" type="file" class="pl-3 py-0 border-0" style="display:none;" placeholder="Group Cover" data-search="">
                        <label for="groupPhoto" class="m-0">Upload Group Cover</label>
                    </div>
                    <img class="imagesrcblock" style="display: none;width:100%;" src="" id="upload-image" height="120px" />
                    
                    <h5 class="mr-3 mt-3 mb-3 font-weight-light" style="opacity:0.6;">INVITE PEOPLE OR GROUP TO EVENT</h5>
                    <div class="invite-people container">
                        <div class="row mb-0"></div>
                    </div>
                    <!-- <div class="divider mb-3"></div> -->
                    <div class="content ml-0">
                        <h5 class="mr-3 mt-3 font-weight-light" style="opacity:0.6;">SUGGESTION</h5>
                        <div class="container">
                            @if($friends)
                                @foreach($friends as $friend)
                                <div class="d-flex justify-content-between">

                                    <a href="#" class="row mb-0 friends py-1">
                                        @if($friend->user_profile)
                                            <div class="col-xs-2">
                                                <img src="{{asset('storage/images/user/profile/'.$friend->user_profile)}}" width="40" height="40" class="rounded-circle mr-3">
                                            </div>
                                        @else
                                            <div class="col-xs-2">
                                                <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="40" height="40" class="rounded-circle mr-3">
                                            </div>
                                        @endif
                                        <div class="friend-name col-xs-8 my-auto">
                                            <h5 class="font-16 font-600">{{$friend->fullname}}</h5>
                                        </div>
                                        <input type="hidden" class="friend-id" value="{{$friend->id}}">
                                    </a>
                                    <div class="make-admin my-auto py-1">
                                        <span class="user-group">Member</span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="create-btn" style="display:none;">
                <button type="submit" class="btn btn-m btn-full m-0 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark">Create</button>
            </div>

        </form>
    </div>
@endsection
