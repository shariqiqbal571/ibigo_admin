@extends('../../layout/admin_layout')

@section('content')
    <section class="content">
        <div class="body">
            <div class="table-responsive">
                <div class="card">     
                <div class="header">
                
                    <div class="row">
                        <div class="col-md-10">
                        <h1>Roles</h1> 
                        </div></br>
                        <div class="col-md-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'role-add')
                    <a
                    href="{{ url('/admin/role/add')}}"
                    class="btn btn-primary">Add Roles</a>
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
                            <td>Roles</td>
                            <td>Action</td>
                        </thead>
                        <tbody>
                        @foreach($roles as $key =>$role)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$role->role}}</td>
                            <td>
                            
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'role-add')
                                <a
                    href="{{ url('/admin/role/add')}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/role/edit/'.$role->id)}}" ><span>Edit</span></a>
                    @endif

                    @if($permissions['permission']['permission'] == 'role-add')
                                <a
                    href="{{ url('/admin/role/add')}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/role/delete/'.$role->id)}}" ><span>Delete</span></a>
                    @endif
                    @endforeach 
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                            
                    </table>
                <div class="pagination">
                    {{$roles->links()}}
                    <p>
                        Displaying {{$roles->count()}} of {{ $roles->total() }} role(s).
                    </p>
                </div>
                </div>
                    </div>
                    
                </div>
            </div>
            
    </section>  
@endsection