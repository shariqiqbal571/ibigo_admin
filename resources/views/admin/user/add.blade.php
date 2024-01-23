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
            <h1>Add a new User</h1>
            <hr> 
                <form action="{{ url('/admin/user/store')}}" method="post"  enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
<!-- 
                    <div class="col-sm-12">
                    <label>User Type</label>
                        <div class="form-group">
                        <div class="form-line">
                            <input type="radio" id="normal"  name="user_type" value="normal">
                            <label for="normal">Normal</label>
                            <input type="radio" id="premium"  name="user_type" value="premium">
                            <label for="premium">Premium</label>     
                        </div>
                        @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('user_type') }}</span>
                        @endif
                        </div>
                    </div> -->

                    <div class="col-sm-6">
                    <label >First Name</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name ="first_name" value="{{old('first_name')}}" class="form-control" placeholder="Enter your First Name">
                        </div>
                        @if($errors->any())
                            <span class="text-danger" >{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Last Name</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="last_name" value="{{old('last_name')}}" class="form-control" placeholder="Enter your Last Name">
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <label>Username</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="username" value="{{old('username')}}" class="form-control" placeholder="Enter your username">
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
                            <input type="radio" id="male"  name="gender" value="male">
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="female">
                            <label for="female">Female</label>
                            <input type="radio" id="other" name="gender" value="other">
                            <label for="other">Other</label> 
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label > About</label>
                        <div class="form-group">
                            <div class="form-line">
                            <textarea id="description" name ="user_about"  rows="4" class="form-control no-resize" placeholder="Enter your Bio..." >{{old('user_about')}}</textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">
                        <label >Birth Date</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" name ="birth_date" class="form-control" placeholder="Enter your Birth Date">
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">
                        <label >Profile</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="file" name ="user_profile" class="form-control">
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-4">
                    <label >Cover</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="file" name ="user_cover" class="form-control" >
                        </div>
                    </div> 
                    </div>
                    <!-- <div class="col-sm-6">
                    <label >Country Code</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="country_code" class="form-control" placeholder="Enter your country code">
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <label >Country Short Code</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="country_short_code" class="form-control" placeholder="Enter your country short code">
                            </div>
                        </div>
                    </div> -->
                    <div class="col-sm-6">      
                        <label >Mobile</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="mobile" value ="{{old('mobile')}}"class="form-control" placeholder="Enter your mobile no">
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <label>Email</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="email" name ="email" class="form-control" value="{{old('email')}}" placeholder="Enter your Email">
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label >Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" name ="password" class="form-control" placeholder="Enter your Password">
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label >Confirm Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" name ="confirm_password" class="form-control" placeholder="Enter your Password">
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('confirm_password') }}</span>
                            @endif
                        </div>
                    </div>
                        @if(Session::has('notmatch'))
                            <div class="col-sm-12 btn-danger" style="color:white; border-radius:10px; padding:10px;" >
                                <span>{{ Session::get('notmatch') }}</span>
                            </div>
                        @endif
                    <div class="col-sm-12">
                        <label >Select Expertise</label>
                        <div class="form-group row">
                            @if($expertise)
                            @foreach($expertise as $expertises)
                            <div class="col-sm-2">
                                <input type="checkbox" id="expertises{{$expertises->id}}" class="chk-col-black" name="user_expertise[]" value="{{ $expertises->id}}">
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
                            
                            <input type="checkbox" id="md_checkbox_{{$interest['id']}}" class="hide chk-col-black" name= "user_interests[]" value="{{ $interest['id']}}">
                            <label class="" style="position: absolute;padding: 50px;" for="md_checkbox_{{$interest['id']}}">
                            </label>
                            <img src="{{ asset('storage/images/interests/'.$interest['image'])}}" style="width:100px; height:100px" alt="User" />
                               
                           @endforeach   
                           @endif                   
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="checkbox" id="md_checkbox_00" class="filled-in" name= "accept_email" value="1">
                                <label class="" for="md_checkbox_00">Accept emails from us
                                </label>                  
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('accept_email') }}</span>
                            @endif
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="checkbox" id="md_checkbox_01" class="filled-in" name= "terms_conditions" value="1">
                                <label class="" for="md_checkbox_01">Bij aanmelding ga je akkoord met "ibigo's" <span class="text-info">Algemene Voorwaarden</span>
                                </label>                  
                            </div>
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('terms_conditions') }}</span>
                            @endif
                        </div>  
                    </div>
                       
                    <div class="col-sm-12">
                        <div Class="form-group ">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>    
        </div>
            
</section>
@endsection