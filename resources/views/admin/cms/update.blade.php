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
            <h1>Update {{$cms[0]['title']}}</h1>
            <hr>
                <form action="{{ url('/admin/cms/update/'.$cms[0]['id'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                    <div class="col-sm-12">
                        <label>Title Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="title" value ="{{$cms[0]['title']}}" class="form-control" placeholder="Enter Title Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('title') }}</span>
                                    @endif  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Image Upload</label>
                            <div class="form-group">
                                <div class="form-line">
                                    @if($cms[0]['image'])
                                    <img src="{{ asset('storage/images/cms/'.$cms[0]['image'])}}" style="width:100px; height:100px" alt="cms-image" /></br>
                                    @endif
                                    <br>
                                    <label class="custom-file-upload">
                                    <input type="file" name="image" class="form-control" style="display:none;"  />
                                    Upload Image
                                    </label>
                                    <input type="text" name="oldImage" value="{{$cms[0]['image']}}" class="form-control" style="display:none;"  />
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