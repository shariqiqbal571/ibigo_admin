@extends('../../layout/admin_layout')

@section('content')

    <section class="content">
    <div class="card">
        <div class="body">
            <h1>Update Information</h1><hr>
            <form action="{{ url('/admin/page/update/'.$page[0]['id'])}}" method="post">
                @csrf
                @method('PUT')
                <div class="row clearfix">  
                    <div class="col-sm-12">
                        <label>Page Title</label>
                        <div Class="form-group">
                            <div class="form-line">
                                <input type="text" name="page_title" value="{{$page[0]['page_title']}}" class="form-control" placeholder="Title" />
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('page_title') }}</span>
                                @endif  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label > Page Description</label>
                        <div class="form-group">
                            <div class="form-line">
                            <textarea id="description" name ="page_description"  rows="4" class="form-control no-resize" placeholder="Enter your page Details..." >{{$page[0]['page_description']}}</textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-12">
                    <label>Page Status</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="page_status"  id="sel">
                                        <!-- <option disabled selected>Select Page Status</option> -->
                                        <option value="0" @if($page[0]['page_status'] == 0) selected @endif>Pending</option>
                                        <option value="1" @if($page[0]['page_status'] == 1) selected @endif>Active</option>
                                        
                                    </select>
                                </div>
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('page_status') }}</span>
                                @endif 
                            </div>         
                    </div>
                    <div class="col-sm-12">
                        <div Class="form-group mt-2">
                        <button type="submit" class="btn btn-success">Update</button>&nbsp;&nbsp;
                     </div>
                </div>
            </form>
        </div>
    </div>       

    </section>

@endsection