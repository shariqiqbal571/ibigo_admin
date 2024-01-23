@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2>CMS - Detail</h2>
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
                        <td>Cms Title</td>
                        <td>Action</td>
                    </thead>
                    <tbody>

                    @foreach($cms as $key => $cmses)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>
                            @foreach($cmses->cmsDetailImage as $images)
                                <img src="{{asset('storage/images/cms/'.$images->images)}}" alt=""  width="30" height="20">
                            @endforeach
                        </td>
                        <td>{{$cmses->title}} </td>
                        <td>{{$cmses->cms->title}} </td>
                        <td>
                            @foreach(session('admin')[0]['user_permission'] as $permissions)
                                @if($permissions['permission']['permission'] == 'cms-detail-update')
                                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/cms-detail/edit/'.$cmses->cms->unique_id.'/'.$cmses->cms->slug)}}" ><span>Edit</span></a>
                                @endif
                                @if($permissions['permission']['permission'] == 'cms-detail-delete')
                                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/cms-detail/delete/'.$cmses->id)}}" ><span>Delete</span></a>
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