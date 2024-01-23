@extends('../../layout/admin_layout')

@section('content')
    <section class="content">
        <div class="body">
            <div class="table-responsive">
                <div class="card">     
                <div class="header">
                
                    <div class="row">
                        <div class="col-md-10">
                        <h1>Filters</h1> 
                        </div></br>
                        <div class="col-md-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'filter-add')
                        <a href="{{ url('/admin/filters/add')}}" class="btn btn-primary">Add Filter</a>
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
                            <td>Filter</td>
                            <td>Type</td>
                            <td>Category</td>
                            <td>Action</td>
                        </thead>
                        <tbody>
                        @foreach($filter as $key => $filters)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$filters->name}}</td>
                            <td style="text-transform: capitalize;">{{$filters->type}}</td>
                            <td style="text-transform: capitalize;">{{$filters->category}}</td>
                            <td>
                            
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'filter-update')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/filters/edit/'.$filters->unique_id.'/'.$filters->slug)}}" ><span>Edit</span></a>
                    @endif
                    @if($permissions['permission']['permission'] == 'filter-delete')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/filters/delete/'.$filters->id)}}" ><span>Delete</span></a>
                    @endif
                    @endforeach

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                            
                    </table>
                <div class="pagination">
                    {{$filter->links()}}
                    <p>
                        Displaying {{$filter->count()}} of {{ $filter->total() }} filter(s).
                    </p>
                </div>
                </div>
                    </div>
                    
                </div>
            </div>
            
    </section>  
@endsection