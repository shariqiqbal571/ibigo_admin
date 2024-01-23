@extends('../layout/admin_layout')

@section('content')

<section class="content">

        <div class="card">
            <div class="body">
            <h1>Update Admin</h1>
            <hr>
                <form action="{{ url('/admin/admin-users/update/'.$admins[0]['id'])}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
        
                    <div class="row clearfix">
                        <div class="col-sm-12">
                        <div class="col-sm-6">
                        <label>Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" value="{{$admins[0]['name']}}" class="form-control" placeholder="Enter Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('name') }}</span>
                                    @endif  
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="form-line">
                                        <input type="text" name="email" value="{{$admins[0]['email']}}" class="form-control" placeholder="Enter Email" />
                                        @if($errors->any())
                                            <span class="text-danger" >{{ $errors->first('email') }}</span>
                                        @endif 
                                    </div>
                                </div>
                            </div>
                           
                            <!-- <div class="col-sm-12">
                                <label >Old Password</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" name ="old_password" class="form-control" placeholder="Enter your Old Password">
                                            @if($errors->any())
                                                    <span class="text-danger" >{{ $errors->first('old_password') }}</span>
                                            @elseif(Session::has('error'))
                                            <span class="text-danger" >{{ Session::get('error') }}</span>
                                            @endif 
                                        </div>
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                <label >Password</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" name ="password" class="form-control" placeholder="Enter your Password">
                                            @if($errors->any())
                                                    <span class="text-danger" >{{ $errors->first('password') }}</span>
                                            @endif 
                                        </div>
                                    </div>
                            </div>
                        <div class="col-sm-6">
                            <label >Confirm Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" name ="confirm_password" class="form-control" placeholder="Enter your Password">
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('confirm_password') }}</span>
                                    @endif 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            @if(Session::has('notmatch'))
                            <div class="alert bg-pink alert-dismissible" role="alert" style="border-radius:10px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                {{Session::get('notmatch')}}
                            </div>
                             @endif  
                        </div> -->
                        <div class="col-sm-12">
                            <label >Profile</label>
                            <div class="form-group">
                                <div class="form-line">
                                    @if(!$admins[0]['avatar'])
                                        <img  src="{{ asset('assets/images/user.png')}}" style="width:100px; height:100px" alt="User" /></br>
                                        <input type="file" name ="avatar" class="form-control">
                                        Upload Profile
                                </div>
                            </div> 
                                @else
                                <img src="{{ asset('storage/admin/profile/'.$admins[0]['avatar'])}}" style="width:100px; height:100px" alt="User" /></br>
                                <label class="custom-file-upload">
                                <input type="file" name ="avatar" class="form-control"/>
                                Upload Profile
                                </label>
                                 @endif
                        </div>
                        <div class="col-sm-12">
                            <label >Select Roles</label>
                            <div class="form-group">
                                @foreach($role as $roles)
                                <input
                                @foreach($admins[0]['user_role'] as $user_role)
                                    @if($roles->id == $user_role['role_id'])
                                    checked
                                    @endif
                                @endforeach
                                 type="checkbox" id="md_checkbox_{{$roles->id}}" class="filled-in" name= "role_id[]" value="{{ $roles->id}}">
                                <label for="md_checkbox_{{$roles->id}}">{{$roles->role}}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <label >Select permission</label>
                        </div>
                        @foreach($permission as $permissions)
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input
                                @foreach($admins[0]['user_permission'] as $user_permission)
                                    @if($permissions->id == $user_permission['permission_id'])
                                    checked
                                    @endif
                                @endforeach
                                 type="checkbox" id="md_checkbox_{{$permissions->permission}}" class="filled-in" name= "permission_id[]" value="{{$permissions->id}}">
                                <label class="text-capitalize" for="md_checkbox_{{$permissions->permission}}">{{$permissions->permission_name.' '.$permissions->permission_module}}</label>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-sm-12">
                            <div Class="form-group mt-2">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div> 
                    </div>
                </form>
                </div>
        </div>
</section>
@endsection