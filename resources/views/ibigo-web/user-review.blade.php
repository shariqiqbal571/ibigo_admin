@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | User Review | '.$user[0]['first_name'].' '.$user[0]['last_name'])
@section('content')


    <div class="page-content">
        <div class="container">
            <div class="card card-style bg-6" data-card-height="50vh">

                <div class="card-top">
                    @if($user[0]['user_cover'])
                    <img src="{{asset('storage/images/user/cover/'.$user[0]['user_cover'])}} " alt="" width="100%" data-card-height="50vh">
                    @else
                    <img src="{{asset('ibigo-web/images/group-bg.png')}} " alt="" width="100%" data-card-height="50vh">
                    @endif
                </div>
                <div class="card-bottom ml-3 mr-3">

                    <h1 class="font-40 line-height-xl color-white">{{$user[0]['first_name']}}<br>
                        {{$user[0]['last_name']}}</h1>
                    <p class="color-white opacity-60"><i class="fas fa-user-alt mr-2"></i>{{$user[0]['age']}} yr. Zwolle</p>
                    <p class="color-white opacity-80 font-15 pb-4">
                        {{$user[0]['user_about']}}
                    </p>

                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>
            <div class="row">
                @if($user[0]['review_spots_all'])
                    @foreach($user[0]['review_spots_all'] as $review)
                    <div class="col-12">
                        <div class="card card-style">
                            <div class="content mb-4">
                                <div class="row">
                                    <div class="col-sm-1">
                                        @if($user[0]['user_profile'])
                                            <img src="{{asset('storage/images/user/profile/'.$user[0]['user_profile'])}}" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="{{asset('ibigo-web/images/avatars/2m.png')}}" width="50" height="50" class="rounded-circle">
                                        @endif
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-sm-12 d-flex">
                                                <h5 class="review-user-spot mr-2 my-auto"><a class="color-black" href="{{url('/people/'.$user[0]['unique_id'].'/'.$user[0]['user_slug'])}}">{{$user[0]['first_name']}} {{$user[0]['last_name']}}</a></h5>
                                                <i class="fa fa-caret-right mr-2 my-auto color-black font-18"></i>
                                                <h5 class="review-user-spot mr-2 my-auto"><a class="color-black" href="{{url('/people/'.$review['spot']['user_spot']['unique_id'].'/'.$review['spot']['user_spot']['user_slug'])}}">{{$review['spot']['business_name']}}</a></h5>
                                            </div>
                                            <div class="col-sm-12 d-flex mt-3">
                                                <p class="mr-2 my-auto font-20 review-rating font-weight-bold"><span class="font-16">{{$review['rating']}}</span> / <span class="font-16">5</span></p>
                                                <i class="fa fa-star mr-2 my-auto review-star"></i>
                                                <p class="mr-2 my-auto font-16">{{$review['date_time']}}</p>
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
