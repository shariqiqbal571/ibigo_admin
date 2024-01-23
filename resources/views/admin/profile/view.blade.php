@extends('../layout/admin_layout')
<style>
input[type="file"] {
    display: none !important;
}
.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    cursor: pointer;
    position: absolute;
    background: lightgray;
    bottom: 0;
    left: 35%;
    transform: translateX(-50%);
    padding: 12px;
    width: 70%;
    text-align: center;
    margin: 0;
    font-size: 20px;
}
</style>
@section('content')

<section class="content">
 

        <div class="card">
            <div class="body"> 
            <h3>Profile Details</h3><hr> 
                <form action="{{ url('/admin/profile/update/'.session('admin')[0]['id'])}}" method="post"  enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                <div class="row"> 
                    <div class="col-sm-4">
                            <label for="image">Profile Picture</label>
                            <div class="form-group">
                                <div class="form-line">
                                @if(!session('admin')[0]['avatar'])
                                <div class="image" style=" position:relative;">
                                    <img  src="{{ asset('assets/images/user.png')}}" style="width:70%;" alt="User" />
                                    <label class="custom-file-upload">
                                    <input type="file" name ="avatar" class="form-control"/>
                                    Upload Profile
                                </label>
                                </div>
                                @else
                                <div class="image" style=" position:relative;">
                                    <img src="{{ asset('storage/admin/profile/'.session('admin')[0]['avatar'])}}" style="width:70%; height:40%" alt="User" />
                                    <label class="custom-file-upload">
                                        <input type="file" name ="avatar" class="form-control"/>
                                        Upload Profile
                                    </label>
                                </div>
                                @endif
                            </div>
                    </div> 
                    </div>
                    <div class="col-sm-8">
                        <label > Name</label>
                        <div class="form-group">
                            <div class="form-line">
                            <input type="text" value="{{session('admin')[0]['name']}}" name ="name" class="form-control" >
                        </div>
                    </div>
                    <label>Email</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="email" value="{{session('admin')[0]['email']}}"  name ="email" class="form-control" >
                            </div>
                            </div>
                            <div Class="form-group ">     
                                <div class="float-right">
                                <a href="{{ url('/admin/profile/password/')}}">Change Password</a></div>
                                </div>
                                <button type="submit" class="btn btn-info">Submit</button>  
                            </div>     
                </div>
                </form>
            </div>    
        </div>
            
</section>
@endsection