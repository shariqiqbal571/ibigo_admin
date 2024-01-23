@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2> <h1>Information</h1></h2>
                    </div></br>
                    <div class="col-sm-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'page-add')
                    <a href="{{ url('/admin/page/add')}}" class="btn btn-primary">Add Page</a>
                    @endif
                    @endforeach
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
                        <td>Page Title</td>
                        <td>Page Status</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                    @foreach($pages as $key =>$page)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$page->page_title}}</td>
                        <td>{{($page->page_status == 0 ? 'Pending' : 'Active')}}</td>
                        <td>
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'page-update')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/page/edit/'.$page->page_unique_id)}}" ><span>Edit</span></a>
                    @endif
                    @if($permissions['permission']['permission'] == 'page-delete')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/page/delete/'.$page->id)}}" ><span>Delete</span></a>          
                    @endif
                    @endforeach
                        </td>
                    </tr>
                    @endforeach
          
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$pages->links()}}
                    <p>
                        Displaying {{$pages->count()}} of {{ $pages->total() }} page(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection