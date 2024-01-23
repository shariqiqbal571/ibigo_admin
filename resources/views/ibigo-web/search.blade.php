@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Search')
@section('content')

    <div class="page-content mt-4 ">
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
    </div>
    <div class="container">
        <div class="card card-style mt-5 mx-auto">
            <div class="content search-text">
                <a href="#" class="btn btn-lg mb-3 text-uppercase font-weight-bold px-5 py-3 shadow-s bg-magenta-dark" style="font-size:12px;border-radius: 15px;" data-menu="menu-main1"><i class="fas fa-filter"></i>FILTERS</a>
                <div class="search-spot-item">
                </div>
            </div>
        </div>

    </div>
    </div>
    <div id="menu-main1" class="menu menu-box-left rounded-0 " data-menu-load="menu-main.html" data-menu-width="400" data-menu-active="nav-welcome" style="display: block; width: 400px !important; ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-top d-flex justify-content-between" style="background-color: #f4f4f4;">
                        <h1 class="mt-2 ml-4 font-12" style="opacity: 0.6">FILTERS</h1>
                        <a class="close-menu mr-2 text-center mt-3 icon-40 notch-clear" href="">
                            <i class="fa fa-times color-black"></i>
                        </a>
                    </div>
                </div>
                <div class="pt-5" style="background-color: #fff;">
                    <div class="container">
                        <div class="list-group list-custom-small list-menu mr-0">
                            <h5 class="mt-3 font-12 font-weight-bold">WAAR</h5>
                            <div class="search-box search-color bg-gray-dark rounded-s mb-3 filter-search" style="line-height: 0 !important;">

                                <input type="text" class="border-0 color-black pl-2" placeholder="Search City " width="100%">

                                <i class="fas fa-search pr-4 text-secondary" style="line-height: 0 !important;top:107px;right:0 !important;"></i>

                            </div>
                        </div>
                        <div class="d-flex ">
                            <h5 class="mt-3 mx-2 font-14 font-weight-bold">Wie</h5>
                            <a href="" class="mt-3 ml-auto color-magenta-dark">Reset</a>
                        </div>
                        <div class="d-flex mb-2">
                            <h6 class="mt-3 mx-2 font-15 font-weight-normal">Spots</h6>
                            <p href="" class="mt-3 ml-auto ">20</p>
                        </div>
                        <div class="d-flex ">
                            <h6 class=" mx-2 font-15 font-weight-normal">Events</h6>
                            <p href="" class=" ml-auto">1</p>
                        </div>
                        <div class="d-flex mb-2">
                            <h5 class="mt-3 mx-2 font-14 font-weight-bold">WANNEER</h5>
                            <a href="" class="mt-3 ml-auto mb-3 color-magenta-dark">Reset</a>
                        </div>
                        <div class="d-flex mb-3">
                            <input type="radio" class="mt-1 mx-2" name="filter-correct" id="weekend">
                            <label for="weekend" class="color-black mb-0 font-16 font-weight-normal">This Weekend</label>
                            <a href="" class="ml-auto bg-gray-light color-black filter-month rounded">October</a>
                        </div>
                        <div class="d-flex mb-3">
                            <input type="radio" class="mt-1 mx-2" name="filter-correct" id="week">
                            <label for="week" class="color-black mb-0 font-16 font-weight-normal">This Week</label>
                            <a href="" class=" ml-auto bg-gray-light color-black filter-month rounded ">October</a>
                        </div>
                        <div class="d-flex mb-4">
                            <input type="radio" class="mt-1 mx-2" name="filter-correct" id="month">
                            <label for="month" class="color-black mb-0 font-16 font-weight-normal">This Month</label>
                            <a href="" class=" ml-auto bg-gray-light color-black filter-month rounded ">October</a>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" value="" id="datepicker3" placeholder="Geen specifieke datum" class="form-control bg-gray-dark mb-3">
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <input type="text" value="" id="datepicker4" placeholder="Geen specifieke datum" class="form-control bg-gray-dark mb-3">
                            </div>
                        </div>
                        <div class="d-flex ">
                            <h5 class="mt-3 mx-2 font-14 font-weight-bold">WAT</h5>
                            <a href="" class="mt-3 ml-auto color-magenta-dark">Reset</a>
                        </div>
                        <div class="d-flex mt-3">
                            <input type="checkbox" id="checkbox-black1" class="checkedOrNot" style="display: none">
                            <label for="checkbox-black1" class="check-it mt-1 mx-2 bg-light border rounded-circle" style="width:15px;height:15px;"></label>
                            <p class="mb-3">Food & Drinks</p>
                            <a href="" class=" ml-auto rounded bg-gray-light color-black filter-month ">15</a>
                        </div>
                        <div class="d-flex ">
                            <input type="checkbox" id="checkbox-black2" class="checkedOrNot" style="display: none">
                            <label for="checkbox-black2" class="check-it mt-1 mx-2 bg-light border rounded-circle" style="width:15px;height:15px;"></label>
                            <p class="mb-3"> Bioscoop & Theater</p>
                            <a href="" class=" ml-auto rounded bg-gray-light color-black filter-month ">5</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="container" style="padding-bottom: 80px;">
        <div class="row spots-search">
            
            @if($spots)
                @foreach($spots as $spot)
                    <div class="col-sm-12">
                        <div class="card card-style">
                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-2">
                                        @if(strpos($spot['user_spot']['user_profile'], 'http') === 0)
                                            <img width="100%" class="fluid-img rounded-lg shadow-xl" src="{{$spot['user_spot']['user_profile']}}">
                                        @else
                                            <img width="100%" class="fluid-img rounded-lg shadow-xl" src="{{asset('storage/images/user/profile/'.$spot['user_spot']['user_profile'])}}">
                                        @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="mb-3 col-sm-12">
                                                <h2>{{$spot['business_name']}}</h2>
                                                <p>{{Str::words($spot['short_description'],'20','...')}}</p>
                                            </div>
                                            <div class="d-flex mb-3 col-sm-12">
                                                <i class="fas fa-star my-1 " style="color:#000;"></i>
                                                <p class="mx-2">Rated {{$spot['rating']}}</p>
                                                @if($spot['business_type'] == 'premium')
                                                    <span class="badge bg-transparent border color-green-dark my-auto ng-star-inserted">premium</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-12">
                                                <a class="d-flex" href="{{url('https://www.google.com/maps/@'.$spot['latitude'].','.$spot['longitude'])}}" target="_blank">
                                                    <i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>
                                                    <p class="color-magenta-dark mx-2">{{$spot['full_address']}}</p>
                                                </a>
                                            </div>
                                            @if($spot['spot_detail'])
                                                @if($spot['spot_detail'][0]['user'])
                                                    <div class="d-flex mt-3 col-sm-12">
                                                        <h5 class="my-auto">Like by :</h5>
                                                        @foreach($spot['spot_detail'] as $spotDetail)
                                                            @if($spotDetail['user']['user_profile'])
                                                                <a href="{{url('/people/'.$spotDetail['user']['unique_id'].'/'.$spotDetail['user']['user_slug'])}}"><img class="rounded-circle mx-1" src="{{asset('storage/images/user/profile/'.$spotDetail['user']['user_profile'])}}" alt="" width="30" height="30" title="{{$spotDetail['user']['fullname']}}"></a>
                                                            @else
                                                                <a href="{{url('/people/'.$spotDetail['user']['unique_id'].'/'.$spotDetail['user']['user_slug'])}}"><img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="30" height="30" class="rounded-circle mx-1" title="{{$spotDetail['user']['fullname']}}"></a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif  
                                            @endif  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" data-menu="menu-share3">
                            <div class="go-btn ">
                                <button type="button" class="btn btn-light bg-magenta-dark">+Go</button>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <button onclick="topFunction()" id="filter-button" data-menu="menu-main1" title="Go to top" class="btn btn-m rounded-l"><i class="fas fa-filter mx-2"></i>Filter</button>






    <div data-menu-load="menu-footer.html"></div>
    </div>

    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="menu-main.html" data-menu-width="280" data-menu-active="nav-welcome">
        <div id="menu-main1" class="menu menu-box-left rounded-0" data-menu-load="menu-main.html" data-menu-width="500" data-menu-active="nav-welcome">


            <!-- Share Menu-->
            <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html" data-menu-height="370">

            </div>

            <!-- Colors Menu-->
            <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html" data-menu-height="480"></div>

            <!-- Be sure this is on your main visiting page, for example, the index.html page-->
            <!-- Install Prompt for Android -->
            <div id="menu-install-pwa-android" class="menu menu-box-bottom rounded-m" data-menu-height="400" data-menu-effect="menu-parallax">
                <img class="mx-auto mt-4 rounded-m" src="app/icons/icon-128x128.png" alt="img" width="90">
                <h4 class="text-center mt-4 mb-2">Appkit on your Home Screen</h4>
                <p class="text-center boxed-text-xl">
                    Install Appkit on your home screen, and access it just like a regular app. It really is that simple!
                </p>
                <div class="boxed-text-l">
                    <a href="#" class="pwa-install btn-center-l btn btn-m font-600 gradient-highlight rounded-sm">Add to
                        Home Screen</a>
                    <a href="#" class="pwa-dismiss close-menu btn-full mt-3 pt-2 text-center text-uppercase font-600 color-red-light font-12">Maybe
                        later</a>
                </div>
            </div>

            <!-- Install instructions for iOS -->
            <div id="menu-install-pwa-ios" class="menu menu-box-bottom rounded-m" data-menu-height="360" data-menu-effect="menu-parallax">
                <div class="boxed-text-xl top-25">
                    <img class="mx-auto mt-4 rounded-m" src="app/icons/icon-128x128.png" alt="img" width="90">
                    <h4 class="text-center mt-4 mb-2">Appkit on your Home Screen</h4>
                    <p class="text-center ml-3 mr-3">
                        Install Appkit on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".
                    </p>
                    <a href="#" class="pwa-dismiss close-menu btn-full mt-3 text-center text-uppercase font-900 color-red-light opacity-90 font-110">Maybe
                        later</a>
                </div>
            </div>

        </div>
    </div>

    <div id="menu-success-2" class="menu menu-box-bottom rounded-m menu-success-2 " data-menu-height="185" data-menu-effect="menu-over" style="height: 185px;">
        <div class="menu-title">
            <i class="fa fa-check-circle scale-box float-left mr-3 ml-3 fa-4x color-green-dark"></i>
            <p class="color-magenta-dark">Post Deleted</p>
            <h1>Success</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
    </div>
    <div id="menu-share3" class="menu menu-box-bottom rounded-m " data-menu-height="325">
        <div class="content">
            <div class="divider mb-3"></div>
            <a href="" class="d-flex mb-3" data-menu="menu-option-2">
                <div class="text-center">
                    <i class="fas fa fa-tasks font-12 mt-2 pt-2 rounded-l bg-facebook  color-white shadow-l rounded-l" style="width: 30px; height: 30px;"></i>

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
                    <i class="fa fa-plus font-12 bg-twitter color-white pt-2 mt-2  shadow-l " style="width: 30px; height: 30px; border-radius: 50px;"></i>
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
                    <i class="fa fa-share font-12  bg-linkedin color-white shadow-l rounded-l pt-2 mt-2 rounded-l" style="width: 30px; height: 30px; "></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Share</h5>

                </div>
                <div class="align-self-center ml-auto font-40 color-black">

                </div>
            </a>
            <div class="divider mb-3"></div>
            <a href="#" class="d-flex mb-3 close-menu" data-menu="menu-option-5">
                <div class="text-center">
                    <i class="fa fa-times font-12 pt-2 mt-2 bg-red-dark color-white shadow-l rounded-l" style="width: 30px; height: 30px;"></i>
                </div>
                <div>
                    <h5 class="font-16 font-600 mt-3 mx-2">Close</h5>

                </div>
                <div class="align-self-center ml-auto font-40 color-black">

                </div>

            </a>
        </div>
    </div>
    <div id="menu-option-2" class="menu menu-box-modal rounded-m  bg-white options" data-menu-height="220" data-menu-width="500" style="height: 200px; width: 350px; display: block;">
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
                    <a href="#" class="btn close-menu btn-full btn-m bg-magenta-dark font-600 rounded-s ml-auto " style="width: 100px;">YES</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-red-dark font-600 rounded-s " style="width: 100px;">NO</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-option-3" class="menu menu-box-modal rounded-m bg-white options" data-menu-height="220" data-menu-width="500" style="height: 200px; width: 350px; display: block;">
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
                    <a href="#" class="btn close-menu btn-full btn-m bg-magenta-dark font-600 rounded-s ml-auto " style="width: 100px;">YES</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-red-dark font-600 rounded-s " style="width: 100px;">NO</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-option-4" class="menu menu-box-modal rounded-m options" data-menu-height="180" data-menu-width="500" style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">
            <h1 class=" font-20">Share Spots</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="divider mb-3"></div>
            <div class="input-style input-style-2 input-required bg-transparent">

                <em><i class="fas fa-caret-down"></i></em>
                <select class="form-control ">
                    <option value="default" selected="">Share</option>
                    <option value="iOS">Friends</option>
                    <option value="Linux">Groups</option>

                </select>

            </div>
        </div>

    </div>
    </div>

@endsection
