@extends('../layout/admin_layout')

@section('content')

<section class="content">
   

        <div class="card">
            <div class="body">  
            <h1>Change Password</h1><hr>
                <form action="{{ url('/admin/profile/password/update/'.session('admin')[0]['id'])}}" method="post" >
                    @csrf
                    @method('PUT')
                    <div class="row"> 
                    <div class="col-sm-12">
                        <label >Old Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password"  name ="oldpassword" class="form-control" placeholder="Enter your old Password">
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('oldpassword') }}</span>
                                @elseif(Session::has('error'))
                                    <span class="text-danger" >{{ Session::get('error') }}</span>
                                @endif 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label >New Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" name ="password"  class="form-control" placeholder="Enter your new Password">
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('password') }}</span>
                                @endif 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label >Confirm Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="password" name ="confirm_password"  class="form-control" placeholder="Enter your confirm Password">
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
                    <div class="col-sm-8">
                        <div Class="form-group ">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>    
                    </div>
                   
                    
                </form>
            </div>    
        </div>
            
</section>
@endsection