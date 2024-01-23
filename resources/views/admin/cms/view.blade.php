@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2>CMS</h2>
                    </div></br>
                    <div class="col-sm-2">
                  
                    </div>
                </div>
            </div>
            <div class="body">
            @if(Session::has('msg'))
                <div class="alert bg-green alert-dismissible" role="alert" style="border-radius:10px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{Session::get('msg')}}
                </div>
                @endif  
              
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <td>#</td>
                        <td>Image</td>
                        <td>Title</td>
                        <td>Action</td>
                    </thead>
                    <tbody>

                    @foreach($cms as $key => $cmses)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td><img src="{{asset('storage/images/cms/'.$cmses->image)}}" alt="" width="20"></td>
                        <td>{{$cmses->title}} </td>
                        <td>
                            @foreach(session('admin')[0]['user_permission'] as $permissions)
                                @if($permissions['permission']['permission'] == 'cms-detail-add')
                                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-primary" href="{{ url('/admin/cms-detail/show/'.$cmses->unique_id.'/'.$cmses->slug)}}" ><span>Upload Detail</span></a>
                                @endif
                                @if($permissions['permission']['permission'] == 'cms-update')
                                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/cms/edit/'.$cmses->unique_id.'/'.$cmses->slug)}}" ><span>Edit</span></a>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                        
                </table>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection