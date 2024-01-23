@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Event | '.$event[0]['event_title'])
@section('content')

    <div class="page-content">
        <div class="container">
            <div class="card card-style shadow-profile-card bg-6" data-card-height="50vh"
                style="background-image:url({{asset('storage/images/event/'.$event[0]['event_cover'])}})"
            >

                <div class="card-top">


                    <div class="upload-btn-wrapper-2">
                        <button class="btn-2 mt-3"><i class="fas fa-pen mx-1 "></i><label for="coverEvent" class="mb-0">EDIT</label></button>
                        <input type="file" id="coverEvent" name="myfile" accept="image/*" />
                      </div>
                </div>
                <div class="card-bottom ml-3 mr-3">

                    <h1 class="font-40 line-height-xl color-white">{{$event[0]['event_title']}}</h1>
                    <p class="color-white opacity-60 mb-3">Hosted by {{$event[0]['user']['fullname']}}</p>

                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <div class="card card-style">
                <div class="content mb-4">
                 <div class="text-center">
                     <h1>{{$event[0]['connect_count']}}</h1>
                     <p>Connected</p>
                 </div>
                 <div class="divider mb-3"></div>
                 <div class="row">
                     <div class="col-lg-4 col-sm-12">

                            <a href="#" data-menu="menu-share" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-600 shadow-s bg-magenta-dark">GO</a>

                     </div>
                     <div class="col-lg-4 col-sm-12">
                        <a href="#" data-menu="menu-call" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-600 shadow-s bg-magenta-dark">Invite

                        </a>
                     </div>
                     <div class="col-lg-4 col-sm-12">
                        <a href="#" data-menu="menu-option-1" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-600 shadow-s bg-magenta-dark"> Add To Calendar

                        </a>
                     </div>
                 </div>
                 </div>
            </div>
            <div class="card card-style">
                <div class="content mb-4 mt-4">
                    <div class="container">
                   <div class="row">
                       <div class="col-lg-4 col-sm-12">
                           <h1>Start Date</h1>
                           <p>{{$event[0]['start_date_time']}}</p>
                       </div>
                       <div class="col-lg-4 col-sm-12">
                        <h1>End Date</h1>
                        <p>{{$event[0]['end_date_time']}}</p>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <h1>Location</h1>
                        <p>{{$event[0]['event_location']}}</p>
                    </div>
                   </div>
                </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mb-3 mt-3">
                    <h1>Event Description</h1>
                    <p>{{$event[0]['event_description']}}</p>

                </div>
            </div>
            <div class="card card-style">
                <div class="content mb-3 mt-3">
                  <h1>Invite People</h1>
                  <div class="spots">
                    <ul>
                        @if($event[0]['event_invites'])
                            @foreach($event[0]['event_invites'] as $key => $users)
                                @if($users['user'])
                                <li style="width: fit-content;">
                                    <a href="{{url('/people/'.$users['user']['unique_id'].'/'.$users['user']['user_slug'])}}">
                                        @if($users['user']['user_profile'])
                                            <div style="background-image: url({{asset('storage/images/profile/'.$users['user']['user_profile'])}}); width: 45px; height: 45px;" class="m-auto home-img rounded-sm shadow-xl"></div>
                                            @else
                                            <div style="background-image: url({{asset('ibigo-web/images/avatars/2m.png')}}); width: 45px; height: 45px;" class="home-img rounded-sm shadow-xl m-auto"></div>
                                        @endif
                                        <p class="mx-2 mt-2">{{$users['user']['fullname']}}</p>
                                    </a>

                                </li>
                                @endif
                            @endforeach
                        @endif

                    </ul>
                </div>
                        </div>
                    </div>
                </div>
            </div>



            <div data-menu-load="menu-footer.html"></div>
        </div>
        </div>
        <!-- Page content ends here-->


        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html"
            data-menu-height="250">
            <div class="content">


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
                <a href="Bernardo Declercq profile.html" class="d-flex mb-3" data-menu="menu-option-4">
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
            </div></div>

        <div id="menu-option-3" class="menu menu-box-modal rounded-m  options"
            data-menu-height="220" data-menu-width="500" style="height: 200px; width: 350px; display: block;">
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
        <div id="menu-option-4" class="menu menu-box-modal rounded-m   options"
            data-menu-height="180" data-menu-width="500" style="height: 200px; width: 350px; display: block;">
            <div class="menu-title">
                <h1 class="color-black font-20">Share Spots</h1>
                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            </div>
            <div class="content mt-0">
                <div class="divider mb-3"></div>
                <div class="input-style input-style-2 input-required">

                    <em><i class="fas fa-caret-down"></i></em>
                    <select class="form-control">
                        <option value="default"  selected="">[Share With]</option>
                        <option value="iOS">Friends</option>
                        <option value="Linux">Groups</option>

                    </select>
                </div>
                <div class="divider mb-3"></div>

            </div>
        </div>
    </div>
    <div id="menu-share-thumbs" class="menu menu-box-modal rounded-m " data-menu-height="320"
        data-menu-width="350" style="height: 320px; width: 350px; display: block;">
        <div class="menu-title">
            <p class="color-magenta-dark">Instruction</p>
            <h1>Parking</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="divider divider-margins"></div>
        <div class="content">
            <p>Parkeergarage in de omgeving</p>
            <div class="divider divider-margins"></div>
            <a href="" class="btn btn-full btn-sm rounded-s font-600 font-13 bg-magenta-dark close-menu">close</a>
        </div>
    </div>
        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
            data-menu-height="480"></div>


    </div>
    <div id="menu-call" class="menu menu-box-modal rounded-m " data-menu-height="330" data-menu-width="350" style="height: 330px; width: 350px; display: block;">
        <div class="menu-title">
            <p class="color-magenta-dark">Invite Friends to</p>
            <h1>Testing</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
       <p class="mx-3">INVITE PEOPLE OR GROUP TO EVENT</p>
        <input type="text" id="tag-input1">
        <div class="divider mb-3"></div>
        <div class="content">
         <p>SUGGESTION</p>
         <a href="" class="d-flex mb-3">
            <div>
                <img src="images/ros.jpeg" width="60" class="rounded-xl mr-3">

            </div>
            <div>
                <h5 class="font-16 font-600 mt-3">Sinan Ros</h5>

            </div>
            <div class="align-self-center ml-auto font-40 color-black">

            </div>
        </a>
        <div class="divider mb-3"></div>
        <a href="" class="d-flex mb-3">
            <div>
                <img src="images/laura.png" width="60" class="rounded-xl mr-3">
            </div>
            <div>
                <h5 class="font-16 font-600 mt-3">Laura Storm</h5>

            </div>
            <div class="align-self-center ml-auto font-40 color-black">

            </div>
        </a>
        <div class="divider mb-3"></div>
        <a href="" class="d-flex mb-3">
            <div>
                <img src="images/go.jpg" width="60" height="60" class="rounded-xl mr-3">
            </div>
            <div>
                <h5 class="font-16 font-600 mt-3"> Bernardo Declercq</h5>

            </div>
        </div>
    </div>

    <div id="menu-option-1" class="menu menu-box-modal rounded-m " data-menu-height="200" data-menu-width="350" style="height: 200px; width: 350px; display: block;">
        <div class="menu-title">

            <p class="color-black font-18">Ibigo.nl says</p>


        </div>
        <div class="content mt-4">
            <p class="pr-3">
                Do you want to this event to planning?
            </p>
            <div class="row mb-0">
                <div class="col-6">
                    <a href="#" data-menu="menu-success-1" class="btn  bg-highlight font-600 rounded-s mx-5 cancel-req" style="width: 100px; height: 50px;">OK</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full  mt-3   font-600 rounded-s cancel-req" style="background-color: gray; width: 100px; height: 50px;">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <div id="menu-success-1" class="menu menu-box-bottom rounded-m " data-menu-height="185" data-menu-effect="menu-over" style="height: 185px; display: block;">
        <div class="menu-title">
            <i class="fa fa-check-circle scale-box float-left mr-3 ml-3 fa-4x color-green-dark"></i>
            <p class="color-magenta-dark">Event is added to planning</p>
            <h1>Success</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0 mb-0">

    </div>

@endsection
