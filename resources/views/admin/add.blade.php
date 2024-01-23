@extends('../layout/admin_layout')

@section('content')

<section class="content">
    
        <div class="card">
            <div class="body">
            <h1>Add Admin</h1>
            <hr>
                <form action="{{ url('/admin/admin-users/store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row clearfix">  
                        <div class="col-sm-6">
                        <label>Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" value ="{{old('name')}}" class="form-control" placeholder="Enter Name" />
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
                                    <input type="text" name="email" value ="{{old('email')}}" class="form-control" placeholder="Enter Email" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('email') }}</span>
                                    @endif 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label >Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password"  name ="password" class="form-control" placeholder="Enter your Password">
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
                            @if(Session::has('notmatchs'))
                                <div class="alert bg-red alert-dismissible" role="alert" style="border-radius:10px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                {{ Session::get('notmatchs') }}
                                </div>
                            @endif 
                        </div>  
  
                        <div class="col-sm-12">
                            <label >Profile</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" name ="avatar" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <div class="col-sm-12">
                            <label >Select Roles</label>
                            <div class="form-group">
                                @foreach($role as $roles)
                                <input type="checkbox" id="md_checkbox_{{$roles->id}}" class="filled-in" name= "role_id[]" value="{{ $roles->id}}">
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
                                <input type="checkbox" id="md_checkbox_{{$permissions->permission}}" class="filled-in" name= "permission_id[]" value="{{$permissions->id}}">
                                <label class="text-capitalize" for="md_checkbox_{{$permissions->permission}}">{{$permissions->permission_name.' '.$permissions->permission_module}}</label>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-sm-12">
                            <div Class="form-group mt-2">
                                <button type="submit" class="btn btn-info">Submit</button>&nbsp;&nbsp;
                                <!-- <button  class="btn btn-danger">  <a href="{{ url('/admin/curd')}}">Cancel</a></button> -->
                            </div>
                            
                              
                           
                        </div>
                    </div>
                </form>
            </div>
        </div>
</section>
@endsection