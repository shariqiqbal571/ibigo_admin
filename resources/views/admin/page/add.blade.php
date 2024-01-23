@extends('../../layout/admin_layout')

@section('content')

    <section class="content">
    <div class="card">
        <div class="body">
            <h1>Add Information</h1><hr>
            <form action="{{ url('/admin/page/store')}}" method="post">
                @csrf
                <div class="row clearfix">  
                    <div class="col-sm-12">
                        <label>Page Title</label>
                        <div Class="form-group">
                            <div class="form-line">
                                <input type="text" name="page_title" value="{{ old('page_title')}}" class="form-control" placeholder="Title" />
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
                            <textarea id="description" name ="page_description"  rows="4" class="form-control no-resize" placeholder="Enter your page Details..." >{{ old('page_description') }}</textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-12">
                    <label>Page Status</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="page_status"  id="sel">
                                        <option disabled selected>Select Page Status</option>
                                        <option value="1" >Active</option>
                                        <option value="0" >Pending</option>
                                        
                                    </select>
                                </div>
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('page_status') }}</span>
                                @endif 
                            </div>         
                    </div>
                    <div class="col-sm-12">
                        <div Class="form-group mt-2">
                            <button type="submit" class="btn btn-info">Submit</button>&nbsp;&nbsp;
                     </div>
                </div>
            </form>
        </div>
    </div>       

    </section>

@endsection