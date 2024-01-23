@extends('../../layout/admin_layout')

@section('content')
    <section class="content">
        <div class="body">
            <div class="table-responsive">
                <div class="card">
               
                <div class="header">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>Admin</h1>  
                        </div></br>
                        <div class="col-md-2">
                           @foreach(session('admin')[0]['user_permission'] as $permissions)
                            @if($permissions['permission']['permission'] == 'admin-add')
                            <a 
                            href="{{url('/admin/admin-users/add')}}"   
                            class="btn btn-primary">Add Admin</a>
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
                            <td>Email</td>
                            
                            <td>Action</td>
                        </thead>
                        <tbody>
                      @foreach($admins as $key => $admin)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$admin->name}}</td>
                            <td>{{$admin->email}}</td>
                           
                            <td>
                                @foreach(session('admin')[0]['user_permission'] as $permissions)
                                @if($permissions['permission']['permission'] == 'admin-update')
                            
                                <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" 
                           href="{{url('/admin/admin-users/edit/'.$admin->id)}}"
                             ><span>Edit</span></a>
                            @endif
                            @if($permissions['permission']['permission'] == 'admin-delete')
                            
                                <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger"
                           href="{{url('/admin/admin-users/delete/'.$admin->id)}}" 
                             ><span>Delete</span></a>
                            @endif
                             @endforeach 
                            </td>
                        </tr>
                      @endforeach
                        </tbody>     
                    </table>
                <div class="pagination">
                    {{$admins->links()}}
                    <p>
                        Displaying {{$admins->count()}} of {{ $admins->total() }} admin(s).
                    </p>
                </div>
                </div>
                    </div> 
                </div>
            </div> 
    </section>  
@endsection