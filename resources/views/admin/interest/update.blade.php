@extends('../layout/admin_layout')

@section('content')

<style>
    option{
        height:100px;
        Scroll-behavior:smooth;
     
    }
    .text{
        padding-left:10px !important;
    }
    
</style>

<section class="content">
        <div class="card">
            <div class="body">
            <h1>Update  Interest</h1>
            <hr>
                <form action="{{ url('/admin/interest/update/'.$interests[0]['id'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row clearfix">
                    <div class="col-sm-12">
                        <label>Title Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="title" value ="{{$interests[0]['title']}}" class="form-control" placeholder="Enter Title Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('title') }}</span>
                                    @endif  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <label>Description</label>
                            <div class="form-group">
                                <div class="form-line">
                                <textarea id="description" name ="description"  rows="4" class="form-control no-resize" placeholder="Enter your Description..." >{{$interests[0]['description']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Image Upload</label>
                            <div class="form-group">
                                <div class="form-line">
                                    @if($interests[0]['image'])
                                    <img src="{{ asset('storage\images\interests/'.$interests[0]['image'])}}" style="width:100px; height:100px" alt="User" /></br>
                                    <label class="custom-file-upload">
                                    <input type="file" name="image" class="form-control"  />
                                    Upload Profile
                                    </label>
                                </div>
                            </div>
                                    @else
                                    <img  src="{{ asset('assets/images/userinterest.png')}}" style="width:100px; height:100px" alt="User" /></br>
                                    <input type="file" name="image" class="form-control"  />
                                    Upload Profile
                                    @endif
                        </div>
                        <div class="col-sm-12">
                        <label>Select Icon</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="icon"  id="sel">
                                <option disabled selected>Select Icon</option>
                                    @foreach($fa_array as $fa_arrays)
                                        <option
                                        @if($interests[0]['icon'] === $fa_arrays)
                                        selected
                                        @endif
                                        value="{{$fa_arrays}}"
                                        class="{{$fa_arrays}}">{{$fa_arrays}}</option>
                                    @endforeach
                                    </select>     
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Active</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="status" id="sel">
                                    <option disabled 
                                    selected
                                    >Select</option>
                                    <option value="1"
                                    @if($interests[0]['status'] === 1) selected @endif 
                                    >Active</option>
                                    <option value="0"
                                    @if($interests[0]['status'] === 0) selected @endif
                                    >Inactive</option>
                                </select>   
                                            
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('status') }}</span>
                                    @endif  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Show In</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="show_in" id="sel">
                                    <option disabled
                                    selected
                                    >Select</option>
                                    <option value="0"
                                    @if($interests[0]['show_in'] === 0) selected @endif 
                                    >Show in Interests</option>
                                    <option value="1"
                                    @if($interests[0]['show_in'] === 1) selected @endif 
                                    >Show in Filters</option>
                                    <option value="2"
                                    @if($interests[0]['show_in'] === 2) selected @endif 
                                    >Show in Both</option>
                               
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('show_in') }}</span>
                                    @endif  
                                    </select>   
                                         
                                </div>
                            </div>
                        </div> 
                        <div class="col-sm-12">
                            <div Class="form-group mt-2">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
</section>
@endsection