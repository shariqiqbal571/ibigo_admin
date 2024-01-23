@extends('../../layout/admin_layout')

@section('content')
    <section class="content">
        <div class="body">
            <div class="table-responsive">
                <div class="card">     
                <div class="header">
                
                    <div class="row">
                        <div class="col-md-10">
                        <h1>Expertise</h1> 
                        </div></br>
                        <div class="col-md-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'expertise-add')
                        <a href="{{ url('/admin/expertise/add')}}" class="btn btn-primary">Add Filter</a>
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
                            <td>Name</td>
                            <td>Icon</td>
                            <td>Action</td>
                        </thead>
                        <tbody>
                        @foreach($expertise as $key =>$expertises)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$expertises->title}}</td>
                            <td><i style="font-size:30px;" class="{{$expertises->icon}}"></i></td>
                            <td>
                            
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'expertise-update')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/expertise/edit/'.$expertises->unique_id.'/'.$expertises->slug)}}" ><span>Edit</span></a>
                    @endif
                    @if($permissions['permission']['permission'] == 'expertise-delete')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/expertise/delete/'.$expertises->id)}}" ><span>Delete</span></a>
                    @endif
                    @endforeach

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                            
                    </table>
                <div class="pagination">
                    {{$expertise->links()}}
                    <p>
                        Displaying {{$expertise->count()}} of {{ $expertise->total() }} expertise(s).
                    </p>
                </div>
                </div>
                    </div>
                    
                </div>
            </div>
            
    </section>  
@endsection