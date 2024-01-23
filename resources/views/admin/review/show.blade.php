@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
                <div class="header">
                    <div class="row">
                        <div class="col-sm-10">
                            <h2>Spot Review Information</h2>
                        </div></br>
                    </div>
                </div>
                <div class="body">
                    <div class="row">
                    <div class="col-sm-12" style="display:flex;justify-content:space-between;">
                        <div style=" display: flex;" width="25%">
                            @if(!$reviews[0]['user']['user_profile'])
                                <img  src="{{ asset('assets/images/post-profile.png')}}" style="width:50px; height: 50px; margin-right:15px;  border-radius: 50%;" controls alt="User" />
                            @else
                                <img  src="{{ asset('storage/images/user/profile/'.$reviews[0]['user']['user_profile'])}}" style="width:50px; height: 50px; margin-right:15px;  border-radius: 50%;" controls alt="User" />
                            @endif
                        <div>
                            <label style="color:#00BDFE">{{$reviews[0]['user']['fullname']}}</label>
                            <p>{{$previous}} ago</p>

                            </div>
                        </div> 
                        <div>
                        @if($reviews[0]['like'] == 1)
                            <i style="font-size:50px !important;color:red;" class="material-icons">favorite</i>
                            @else
                            <i style="font-size:50px !important;color:black;" class="material-icons">favorite</i>
                            @endif
                        </div>
                    </div>
                        <div class="col-sm-12" >
                                <h1 class="text-capitalize">{{$reviews[0]['spot']['business_name']}}</h1>
                        </div>
                        @if(isset($reviews[0]['review']))
                        <div class="col-sm-12">
                            <p> <b>Review:</b>
                                </p>
                                <div>
                                {{$reviews[0]['review']}}
                                </div>
                        </div>
                        @endif
                        <div class="col-sm-12" style="display:flex;justify-content:space-between;">
                            <div>
                                <p> 
                                    <b>Rating:</b>
                                </p>
                                <div>

                                @if($reviews[0]['rating'] == 0.0 || $reviews[0]['rating'] == 0 || $reviews[0]['rating'] == null)
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 1.0 || $reviews[0]['rating'] == 1)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 2.0 || $reviews[0]['rating'] == 2)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 3.0 || $reviews[0]['rating'] == 3)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 4.0 || $reviews[0]['rating'] == 4)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 5.0 || $reviews[0]['rating'] == 5)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                @elseif($reviews[0]['rating'] == 0.5)
                                    <i style="color:yellow;" class="material-icons">star_half</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 1.5)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star_half</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 2.5)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star_half</i>
                                    <i class="material-icons">star_border</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 3.5)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star_half</i>
                                    <i class="material-icons">star_border</i>
                                @elseif($reviews[0]['rating'] == 4.5)
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star</i>
                                    <i style="color:yellow;" class="material-icons">star_half</i>
                                @endif
                                </div>

                            </div>
                            <div>
                            @if($reviews[0]['connected'] == 1)
                                <i style="font-size:50px !important;" class="fas fa-link"></i>
                                @else
                                <i style="font-size:50px !important;" class="fas fa-unlink"></i>
                                @endif
                            </div>
                        </div>
                        @if(isset($reviews[0]['spot_detail_photos'][0]))
                        <div class="col-sm-12">
                            <label>Post Image</label>
                        </div>                           
                        @foreach($reviews[0]['spot_detail_photos'] as $key => $photos)
                        <div class="col-sm-2">
                            <div Class="form-group">
                                <div class="form-line">
                                    <img  src="{{ asset('storage/images/review/images/'.$photos['review_photo'])}}" style="border-radius: 50px; width:100%;height:200px;" controls alt="User" />
                                </div>  
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if(isset($reviews[0]['spot_detail_videos'][0]))
                            <div class="col-sm-12">
                                <label>Post video</label>
                            </div>
                                @foreach($reviews[0]['spot_detail_videos'] as $key => $videos)
                                <div class="col-sm-3">
                                    <div Class="form-group">
                                        <div class="form-line">
                                            <video style="border-radius: 10px; width:100%;height:200px;" controls>
                                                <source src="{{ asset('storage/videos/review/videos/'.$videos['review_video'])}}" type="video/ogg">
                                            </video>
                                        </div>  
                                    </div>
                                </div>        
                            @endforeach 
                        @endif
                    
                    </div>
                </div>
               
            </div>        
        </div>
    </div>
    <script>
       
    </script>
        

@endsection