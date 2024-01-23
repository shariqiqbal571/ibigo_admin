@extends('../layouts/main_web_layout')
@if(request()->route()->uri == 'todo/go-list') 
    @section('title', 'Ibigo | GoTo List') 
@elseif(request()->route()->uri == 'todo/plan') 
    @section('title', 'Ibigo | Plans') 
@endif
@section('content')


    <div class="container">
        <!-- <div class="voegtoeActive position-relative" style="display: none; padding-bottom: 60px;">
            <a href="#" data-menu="menu-share-thumbs">
                <button class="btn btn-lg create-button-2 rounded-l  bg-magenta-dark plan-btn" style="width: 250px;"></button>
            </a>
        </div>
        <div class="planutijeActive position-relative" style="display: none; padding-bottom: 60px;">
            <a href="#" data-menu="menu-share-thumbs2">
                <button class="btn create-button-2 btn-lg rounded-l  bg-magenta-dark plan-btn" style="width: 250px;"></button>
            </a>
        </div> -->
        <div class="row mt-5">
            <div class="col-12">

                <div class="fixed-btns mb-5">
                    <div style="display: @if($routeName == 'todo/go-list')  block @else none @endif ;">
                        <a class="btn show-goto-modal btn-md btn-full rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s m-auto  w-100" href="#" data-menu="menu-share-thumbs">
                            Voeg toe aan Go List
                        </a>

                    </div>
                    <div style="display: @if($routeName == 'todo/plan')  block @else none @endif ;">
                        <a class="btn show-plan-modal btn-md btn-full rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s  m-auto w-100" href="#" data-menu="menu-share-thumbs2">
                            PLAN UTIJE IN
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                <div class="tab-controls mr-0 ml-0 tabs-round tab-animated tabs-medium tabs-rounded clearfix shadow-xl mb-4" data-tab-items="2" data-tab-active="bg-magenta-dark activated color-white">
                    <a href="{{url('/todo/go-list')}}" class="font-12 golistActive" @if($routeName == 'todo/go-list') data-tab-active @endif data-tab="tab-1"><i
                                class="fas fa-list-alt mx-2"></i>Go List</a>
                    <a href="{{url('/todo/plan')}}" class="font-12 agendaActive" @if($routeName == 'todo/plan') data-tab-active @endif data-tab="tab-2"><i class="fas fa-list-alt mx-2"></i>Agenda</a>
                </div>

                <div class="tab-content" id="tab-1" style="width: 100%!important;">
                    @if($goToList)
                        @foreach($goToList as $spots)
                            <div class="card card-style">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            @if(strpos($spots['spot']['user_spot']['user_profile'], 'http') === 0)
                                                <img width="100%" class="fluid-img rounded-lg shadow-xl" src="{{$spots['spot']['user_spot']['user_profile']}}">
                                            @else
                                                <img width="100%" class="fluid-img rounded-lg shadow-xl" src="{{asset('storage/images/user/profile/'.$spot['user_spot']['user_profile'])}}">
                                            @endif
                                        </div>
                                        <div class="col-sm-10">
                                            <div>
                                                <a href="{{url('/spots/'.$spots['spot']['user_spot']['unique_id'].'/'.$spots['spot']['user_spot']['user_slug'])}}">
                                                    <h2>{{$spots['spot']['business_name']}}</h2>
                                                </a>
                                                <p class="my-3">{{$spots['spot']['short_description']}}</p>
                                            </div>
                                            <div class="d-flex mb-3">
                                                <i class="fas fa-star my-1 " style="color:#000;"></i>
                                                <p class="mx-2">Rated {{$spots['spot']['rating']}} </p>
                                                @if($spots['spot']['business_type'] != 'basic')
                                                <span class="badge bg-transparent border color-green-dark my-auto p-1 ng-star-inserted">premium</span>
                                                @endif
                                            </div>
                                            <div>
                                                <a class="d-flex" href="{{url('https://www.google.com/maps/@'.$spots['spot']['latitude'].','.$spots['spot']['longitude'])}}" target="_blank">
                                                    <i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>
                                                    <p class="color-magenta-dark mx-2">{{$spots['spot']['full_address']}}</p>
                                                </a>
                                            </div>
                                            @if($spots['spot']['like_spot'])
                                                <div class="d-flex mt-3">
                                                    <h5>Like by :</h5>
                                                    @foreach ($spots['spot']['like_spot'] as $users)
                                                        @if($users['user']['user_profile'])
                                                            <a href="{{url('/people/'.$users['user']['unique_id'].'/'.$users['user']['user_slug'])}}"><img class="rounded-xl mx-1" src="{{asset('storage/images/user/profile/'.$users['user']['user_profile'])}}" alt="" width="20px" height="20px"></a>
                                                        @else
                                                            <a href="{{url('/people/'.$users['user']['unique_id'].'/'.$users['user']['user_slug'])}}"><img class="rounded-xl mx-1" src="{{asset('ibigo-web/images/avatars/2m.png')}}" alt="" width="20px" height="20px"></a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="card card-style">
                            <h2 class="text-center text-secondary">No Spots</h2>
                        </div>
                    @endif
                </div>
                <div class="tab-content" id="tab-2" style="width: 100%!important;">
                    <h4 class="mb-3">Deze maand</h4>
                    @foreach($planning as $plannings)
                        <div class="col-sm-12 p-0">
                            <div class="card card-style event-card card-bg-img" style="background-image: url({{asset('ibigo-web/images/17.jpg')}})">
                                <div class="content m-0">
                                    <div class="d-flex">
                                        <div class="w-25" style="background-color: #fff; position: relative;">
                                            <div class="m-auto text-center position-absolute">
                                                <h1 class="font-30 text-uppercase font-900 opacity-30">{{$plannings['day']}}</h1>
                                                <h3 class="font-24 font-900">{{$plannings['date']}}th</h3>
                                            </div>
                                        </div>
                                        <div class="w-75 position-relative">
                                            <div class="card-body w-100 pl-4" style="padding-bottom: 50px;">
                                                <a href="@if($plannings['spot']){{url('/spots/'.$plannings['spot']['user_spot']['unique_id'].'/'.$plannings['spot']['user_spot']['user_slug'])}}@else{{url('/event/'.$plannings['event']['event_unique_id'].'/'.$plannings['event']['event_slug'])}}@endif">
                                                    <h2 class="color-white pt-3 pb-3">@if($plannings['spot']){{$plannings['spot']['business_name']}}@else{{$plannings['event']['event_title']}}@endif</h2>
                                                    <p class="text-white mb-5">{{substr($plannings['planning_description'],'0','150')}}</p>
                                                </a>
                                                <p class="color-white mb-0">
                                                    <i class="fa fa-map-marker-alt color-white pr-2 icon-30"></i>
                                                    @if($plannings['spot']){{$plannings['spot']['full_address']}}@else{{$plannings['event']['event_location']}}@endif
                                                </p>
                                                <p class="color-white mb-0">
                                                <p class="color-white mb-0">
                                                <i class="color-white pr-2 icon-30 fas fa-calendar-check"></i>
                                                    {{$plannings['start_date']}} @if($plannings['end_date_time'])  - {{$plannings['end_date']}} @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                <div class="row">
                    <div class="col-sm-12 create-btns mb-3">
                        <div style="display: @if($routeName == 'todo/go-list')  block @else none @endif ;">
                            <a class="btn show-goto-modal btn-md btn-full rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s m-auto  w-100" href="#" data-menu="menu-share-thumbs">
                                Voeg toe aan Go List
                            </a>

                        </div>
                        <div style="display: @if($routeName == 'todo/plan')  block @else none @endif ;">
                            <a class="btn show-plan-modal btn-md btn-full rounded-xl bg-magenta-dark text-uppercase font-12 shadow-s  m-auto w-100" href="#" data-menu="menu-share-thumbs2">
                                PLAN UTIJE IN
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

    <div style="width:550px !important;" id="menu-share-thumbs" class="menu menu-box-modal rounded-m  container" data-menu-height="550" data-menu-width="500" style="display: block;background-color: #fff;">
        <div class="menu-title">
            <h1 class="">Add spot to go to list</h1>

            <a href="#" class="close-menu"><i class="fa fa-times-circle mx-4"></i></a>
        </div>
        <form action="{{url('/create-go-to')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="divider divider-margins"></div>
            <h5 class="mr-3 mt-3 mb-3 font-weight-light" style="opacity:0.6;">Added Post</h5>
            <div class="spots-evetns container border mb-3" style="display:@if($goToList) block @else none @endif ;">
                <div class="row mb-0 p-3">
                    @foreach($goToList as $spots)
                    <div class="col-lg-12 my-1 px-2 position-relative col-md-12 col-sm-12 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                        {{$spots['spot']['business_name']}}
                        <button type="button" style="top:50% !important;;right:-10px !important;" class="close show-spot" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <input type="hidden" name="spot_id[]" value="{{$spots['spot']['id']}}" />
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="search-box" style="line-height:0;">
                <input type="text" class="pl-3 py-0 border-0" placeholder="Search Spots" data-search="">
            </div>
            <div class="scrolling-height">
                @if($likeConnected)
                <h5 class="mr-3 mt-3 mb-3 font-weight-light" style="opacity:0.6;">Liked/Connected Spots</h5>
                <div class="container">
                    @foreach($likeConnected as $spots)
                    <a href="#" class="mt-4 spots row mb-0">
                        @if(strpos($spots['user_spot']['user_profile'], 'http') === 0)
                            <div class="col-xs-2">
                                <img src="{{url($spots['user_spot']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                            </div>
                        @else
                            <div class="col-xs-2">
                                <img src="{{asset('storage/images/user/profile/'.$spots['user_spot']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                            </div>
                        @endif
                        <div class="col-xs-8 spot-name my-auto ">
                            <h6 class="my-auto mx-1">{{$spots['business_name']}}</h6>
                        </div>
                        <input type="hidden" class="spot-id" value="{{$spots['id']}}">
                    </a>
                    @endforeach
                </div>
                @endif
                @if($spot)
                <h5 class="mr-3 mt-3 mb-3 font-weight-light" style="opacity:0.6;">Suggestions</h5>
                <div class="container">
                    @foreach($spot as $spots)
                        <a href="#" class="mt-4 spots row mb-0">
                            @if(strpos($spots['user_spot']['user_profile'], 'http') === 0)
                                <div class="col-xs-2">
                                    <img src="{{url($spots['user_spot']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                                </div>
                            @else
                                <div class="col-xs-2">
                                    <img src="{{asset('storage/images/user/profile/'.$spots['user_spot']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                                </div>
                            @endif
                            <div class="col-xs-8 spot-name my-auto ">
                                <h6 class="my-auto mx-1">{{$spots['business_name']}}</h6>
                            </div>
                            <input type="hidden" class="spot-id" value="{{$spots['id']}}">
                        </a>
                    @endforeach
                </div>
                @endif

            </div>
            <div class="modal-footer mt-5">
                <button type="submit" class="btn btn-m btn-full m-0 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark">Add</button>
            </div>
        </form>
    </div>
    <div style="width:550px !important;" id="menu-share-thumbs2" class="bg-light menu menu-box-modal rounded-m  container" data-menu-height="550" data-menu-width="500" style="background-color: #fff; display: block;">
        <div class="menu-title">
            <p class="color-magenta-dark">Add</p>
            <h1 class="">Plan je uitje</h1>

            <a href="#" class="close-menu"><i class="fa fa-times-circle my-1"></i></a>
        </div>
        <form action="{{url('/create-plan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="divider divider-margins"></div>
            @if($event)
            <div class="plan-event-btn">
                <input type="checkbox" id="event-show" />
                <label for="event-show">Add event to plan?</label>
            </div>
            <div class="input-style rounded input-required mt-3" id="plan-event" style="display: none;">
                <h5 class="mr-3 mt-3 mb-3 font-weight-light" style="opacity:0.6;">Select an event</h5>
                <select name="event_id" class="form-control">
                    <option disabled selected>Select Event</option>
                    @foreach($event as $events)
                        <option value="{{$events['id']}}">{{$events['event_title']}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="plan-spots">
                <div class="input-style rounded input-required mt-3">
                    <input class="form-control" name="title" type="text" placeholder="What Is Plan?">
                </div>
                <div class="input-style rounded input-required mt-3">
                    <input class="form-control" name="date" type="text" placeholder="When Is Plan?" id="datepicker2">
                </div>
                <h5 class="mr-3 mt-3 mb-3 font-weight-light selected-spot" style="opacity:0.6;display:none;">Selected Spots</h5>
                <div class="single-spot container mb-3" style="display:none;">
                    <div class="row mb-0"></div>
                </div>
                @if($likeConnected)
                <h5 class="mr-3 mt-3 mb-3 font-weight-light" style="opacity:0.6;">Liked/Connected Spots</h5>
                <div class="search-box" style="line-height:0;">
                    <input type="text" class="pl-3 py-0 border-0" placeholder="Search Liked/Connected Spots" data-search="">
                </div>
                <div class="container">
                    @foreach($likeConnected as $spots)
                    <a href="#" class="mt-4 all-spots row mb-0">
                        @if(strpos($spots['user_spot']['user_profile'], 'http') === 0)
                            <div class="col-xs-2 spot-image">
                                <img src="{{url($spots['user_spot']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                            </div>
                        @else
                            <div class="col-xs-2">
                                <img src="{{asset('storage/images/user/profile/'.$spots['user_spot']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                            </div>
                        @endif
                        <div class="col-xs-8 spot-name my-auto ">
                            <h6 class="my-auto mx-1">{{$spots['business_name']}}</h6>
                        </div>
                        <input type="hidden" class="spot-id" value="{{$spots['id']}}">
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="modal-footer mt-5">
                <button type="submit" class="btn btn-m btn-full m-0 rounded-xs text-uppercase font-900 shadow-s bg-magenta-dark">Add</button>
            </div>
        </form>
    </div>


@endsection
