@extends('../../layout/admin_layout')

@section('content')

<style>
    /* Bottom left text */
.bottom-left {
  position: absolute;
  bottom: 40px;
  left: 30px;
  color: white;
}

.bottom-left-p {
  position: absolute;
  bottom: 40px;
  left: 50px;
  color: white;
}

</style>

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
                <div class="header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2> <h1>Groups</h1></h2>
                        </div></br>
                    </div>
                </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        @if(!$groups[0]['group_cover'])
                                        <img  src="{{ asset('assets/images/group-bg.png')}}" style="width:100%; height: 300px;" alt="User" /></br>
                                        @else
                                        <img  src="{{ asset('storage/images/group/group_cover/'.$groups[0]['group_cover'])}}" style="width:100%; height: 300px;" alt="User" /></br>
                                        @endif



                                        <h3 class="bottom-left">{{$groups[0]['group_name']}}</h3>
                                    </div> 
                                    
                                    @if($groupUser[0]['count']) 
                                        <p class="bottom-left-p">{{$groupUser[0]['count']}} Members</p>
                                    @else   
                                        <p class="bottom-left-p">0 Members</p> 
                                    @endif     
                                </div> 
                            </div>    
                        </div>    
                    </div>
            </div>

            <hr>
                <div class="card">
                    <div class="body">
                        <div class="row">
                               
                        @if($groupUser[0]['count'] > 0 )
                            <div class="col-sm-12">
                                <div class="form-group">   
                                    <h5>Group User</h5>
                                </div>
                            </div>
                        @endif
                        @foreach ($groups[0]['group_status'] as $key => $groupStatus)
                            @if($groupStatus['group_status'] == 3)
                            <div class="col-sm-2">
                                @if($groupStatus['user']['user_profile'])
                                <img  src="{{ asset('storage/images/user/profile/'.$groupStatus['user']['user_profile'])}}" style="width:50px; height: 50px;  border-radius: 50%;" alt="User" />
                                @else
                                <img  src="{{ asset('assets/images/group-bg.png')}}" style="width:50px; height: 50px;  border-radius: 50%;" alt="User" />
                                @endif
                                </br></br>
                                <p>{{$groupStatus['user']['fullname']}}</p>
                            </div> 
                            @endif
                        @endforeach

                        @if($requestedUser[0]['group_status'] > 0 )
                            <div class="col-sm-12">
                                <div class="form-group">   
                                    <h5>Requested User</h5>
                                </div>
                            </div>
                        @endif
                        @foreach ($groups[0]['group_status'] as $key => $groupStatus)
                            @if($groupStatus['group_status'] == 1)
                            <div class="col-sm-2">
                                @if($groupStatus['user']['user_profile'])
                                <img  src="{{ asset('storage/images/user/profile/'.$groupStatus['user']['user_profile'])}}" style="width:50px; height: 50px;  border-radius: 50%;" alt="User" />
                                @else
                                <img  src="{{ asset('assets/images/group-bg.png')}}" style="width:50px; height: 50px;  border-radius: 50%;" alt="User" />
                                @endif
                                </br></br>
                                <p>{{$groupStatus['user']['fullname']}}</p>
                            </div> 
                            @endif
                        @endforeach
                        </div>        
                    </div>                    
                </div>
        </div>
    </div> 
        

@endsection