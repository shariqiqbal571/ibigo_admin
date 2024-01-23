@extends('../layout/admin_layout')

@section('content')

<style>
    option{
        height:100px;
        scroll-behavior:smooth;
    }
    .text{
        padding-left:10px !important;
    }

    
</style>
<section class="content">
        <div class="card">
            <div class="body">
            <h1>Add a new Interest</h1>
            <hr>
                <form action="{{ url('/admin/interest/store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                    <div class="col-sm-12">
                        <label>Title Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="title" value ="{{old('title')}}" class="form-control" placeholder="Enter Title Name" />
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
                                <textarea name="description" class="form-control no-resize" id="description"  placeholder="Enter your Description..." >{{old('description')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Image Upload</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" name="image" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Select Icon</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="icon" id="sel">
                                <option disabled selected>Select Icon</option>
                                @if($fa_array)
                                @foreach($fa_array as $fa_arrays)
                                <option class="{{$fa_arrays}}" value="{{$fa_arrays}}"> {{$fa_arrays}}</option>
                                @endforeach
                                @endif
                               
                                    </select>   
                                         
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Active</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="status" id="sel">
                                    <option disabled selected>Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
                                
                                    <option disabled selected>Select</option>
                                    <option value="0">Show in Interests</option>
                                    <option value="1">Show in Filters</option>
                                    <option value="2">Show in Both</option>
                               
                                    </select>   
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('show_in') }}</span>
                                    @endif  
                                </div>
                            </div>
                        </div> 
                                

                        <div class="col-sm-12">
                            <div Class="form-group mt-2">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </div>
                   
                </form>
                </div>
            </div>
        </div>
</section>
@endsection