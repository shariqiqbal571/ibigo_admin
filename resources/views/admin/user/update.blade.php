@extends('../layout/admin_layout')


<style>
.hide + label:before{
    border:none !important;
}

.hide:checked + label:before {
    border-right: 2px solid #000 !important;
    border-bottom: 2px solid #000 !important;
}

</style>

@section('content')

<section class="content">
        <div class="card">
            <div class="body"> 
                <h1>Update a User</h1>
                <hr> 
                <form action="{{ url('/admin/user/update/'.$user->id) }}" method="post"  enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                    <div class="row">

                    <!-- <div class="col-sm-12">
                        <label>User Type</label>
                        <div class="form-group">
                        <div class="form-line">
                            <input type="radio" id="normal" name="user_type" value="normal"
                            @if($user->user_type =='normal')
                            checked
                            @endif
                            >
                            <label for="normal">Normal</label>
                            <input type="radio" id="premium" name="user_type" value="premium"
                            @if($user->user_type =='premium')
                            checked
                            @endif
                            >
                            <label for="premium">Premium</label>
                            @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('user_type') }}</span>
                            @endif
                        </div>
                        </div>
                    </div> -->

                    <div class="col-sm-6">
                        <label >First Name</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" value="{{$user->first_name}}" name ="first_name" class="form-control" placeholder="Enter your First Name">
                                @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Last Name</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text"  value="{{$user->last_name}}" name ="last_name" class="form-control" placeholder="Enter your Last Name">
                                @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <label>Username</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="username" value="{{$user->username}}" class="form-control" placeholder="Enter your username">
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('username') }}</span>
                            @endif
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <label>Gender</label>
                        <div class="form-group">
                        <div class="form-line">
                            <input type="radio" id="male" name="gender" value="male" 
                            @if($user->gender == 'male')
                            checked
                            @endif>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="female" 
                            @if($user->gender == 'female')
                            checked
                            @endif>
                            <label for="female">Female</label>
                            <input type="radio" id="other" name="gender" value="other" 
                            @if($user->gender == 'other')
                            checked
                            @endif>
                            <label for="other">Other</label> 
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label > About</label>
                        <div class="form-group">
                            <div class="form-line">
                            <textarea id="description" name ="user_about"   rows="4" class="form-control no-resize" placeholder="Enter your Bio..." >{{$user->user_about}}</textarea>
                            </div>
                        </div>  
                    </div>
                    
                    <div class="col-sm-6">
                        <label for="image">Profile</label>
                        <div class="form-group">
                            <div class="form-line">
                                @if(!$user->user_profile)
                                    <img  src="{{ asset('assets/images/user.png')}}" style="width:100px; height:100px" alt="User" /></br>
                                    <input type="file"  name ="user_profile" class="form-control">
                                    Upload Profile     
                                @else
                                <img src="{{ asset('storage/images/user/profile/'.$user->user_profile)}}" style="width:100px; height:100px" alt="User" /></br>
                                <label class="custom-file-upload">
                                <input type="file"  name ="user_profile" class="form-control">
                                Upload Profile
                                </label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label >Cover</label>
                        <div class="form-group">
                            <div class="form-line">
                                @if(!$user->user_cover)
                                    <img  src="{{ asset('assets/images/user.png')}}" style="width:100px; height:100px" alt="User" /></br>
                                    <input type="file"  name ="user_cover" class="form-control">
                                    Upload Profile                            
                                @else
                                <img src="{{ asset('storage/images/user/cover/'.$user->user_cover)}}" style="width:100px; height:100px" alt="User" /></br>
                                <label class="custom-file-upload">
                                <input type="file"  name ="user_cover" class="form-control">
                                Upload Profile
                                </label>
                                @endif
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-4">
                        <label >Birth Date</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" value="{{$user->birth_date}}" name ="birth_date" class="form-control" >
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">      
                        <label >Mobile</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" value="{{$user->mobile}}" name ="mobile" class="form-control" placeholder="Enter your mobile no">
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">
                        <label>Email</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="email" value="{{$user->email}}" name ="email" class="form-control" placeholder="Enter your Email">
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label >Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" value="{{$user->password}}" name ="password" class="form-control" placeholder="Enter your Password">
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label >Select Expertise</label>
                        <div class="form-group row">
                            @if($expertise)
                            @foreach($expertise as $expertises)
                            <div class="col-sm-2">
                                <input type="checkbox"
                                
                                @foreach($user_expertise as $user_expertises)
                                    @if($user_expertises->expertise_id == $expertises->id)
                                    checked
                                    @endif
                                @endforeach
                                id="expertises{{$expertises->id}}" class="chk-col-black" name="user_expertise[]" value="{{ $expertises->id}}">
                                <label for="expertises{{$expertises->id}}">
                                {{$expertises->title}}
                                </label>
                            </div>
                           @endforeach   
                           @endif   
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label >Select Interest</label>
                        <div class="form-group">
                        <div class="form-line">
                            @if($interests)
                            @foreach($interests as $interest)
                            <input 
                          
                            type="checkbox"
                            @foreach($intrestId as $id)
                                @if($id == $interest['id'])
                                checked
                                @endif
                            @endforeach
                             id="md_checkbox_{{$interest['id']}}" class="hide chk-col-black" name= "user_interests[]" value="{{ $interest['id']}}">
                            <label class="" style="position: absolute;padding: 50px;" for="md_checkbox_{{$interest['id']}}">
                            </label>
                            <img src="{{ asset('storage/images/interests/'.$interest['image'])}}" style="width:100px; height:100px" alt="User" />
                               
                           @endforeach   
                           @endif                   
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div Class="form-group ">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>    
        </div>
            
</section>
@endsection