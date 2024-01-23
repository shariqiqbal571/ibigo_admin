@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Spot Review | '.$spot[0]['business_name'])
@section('content')


    <div class="page-content">
        <div class="container">
            <div class="card card-style bg-6" data-card-height="50vh">

                <div class="card-top">
                    @if($spot[0]['user_spot']['user_cover'])
                    <img src="{{asset('storage/images/user/cover/'.$spot[0]['user_spot']['user_cover'])}} " alt="" width="100%" data-card-height="50vh">
                    @else
                    <img src="{{asset('ibigo-web/images/group-bg.png')}} " alt="" width="100%" data-card-height="50vh">
                    @endif
                </div>
                <div class="card-bottom ml-3 mr-3">

                    <h1 class="font-40 line-height-xl color-white">{{$spot[0]['business_name']}}</h1>
                    @if($spot[0]['rating'])<p class="color-white">Ratings: {{$spot[0]['rating']}}</p>@endif
                    <a href="{{url('https://www.google.com/maps/@'.$spot[0]['latitude'].','.$spot[0]['longitude'])}}" target="_blank">
                        <div class="d-flex mt-4 mb-4 ">
                            <p class="mx-2 color-magenta-dark profile-location color-white"><i class="fas fa-map-marker-alt color-magenta-dark pt-1 profile-location color-white mr-2"></i> {{$spot[0]['full_address']}}</p>
                        </div>
                    </a>

                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>
            <div class="row">
                @if($spot[0]['ratings'])
                    @foreach($spot[0]['ratings'] as $user)
                    <div class="col-12">
                        <div class="card card-style">
                            <div class="content mb-4">
                                <div class="row mb-0">
                                    <div class="col-sm-1">
                                        @if($user['user']['user_profile'])
                                            <img src="{{asset('storage/images/user/profile/'.$user['user']['user_profile'])}}" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="50" height="50" class="rounded-circle">
                                        @endif
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="row mb-0">
                                            <div class="col-sm-12 d-flex">
                                                <h5 class="review-user-spot mr-2 my-auto"><a class="color-black" href="{{url('/people/'.$user['user']['unique_id'].'/'.$user['user']['user_slug'])}}">{{$user['user']['fullname']}}</a></h5>
                                            </div>
                                            <div class="col-sm-12 d-flex mt-3">
                                                <p class="mr-2 my-auto font-20 review-rating font-weight-bold"><span class="font-16">{{$user['rating']}}</span> / <span class="font-16">5</span></p>
                                                <i class="fa fa-star mr-2 my-auto review-star"></i>
                                                <p class="mr-2 my-auto font-16">{{$user['date_time']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card card-style">
                            <div class="content mb-4">
                                <div class="text-center">
                                    <p class="mt-4 mb-4">No Reviews</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>


        <!-- Page content ends here-->


    </div>

    @endsection
