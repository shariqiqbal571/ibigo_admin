@extends('../../layout/admin_layout')

@section('content')



<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2> <h1>Users</h1></h2>
                    </div></br>
                    <div class="col-sm-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'user-add')
                    <a 
                    href="{{ url('/admin/user/add')}}"
                    class="btn btn-primary">Add User</a>
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
                <form action="{{url('/admin/user')}}" method="GET">
                    @csrf
                    <div class="col-sm-3" style="padding:0 !important;">
                        <div class="form-group" style="margin-bottom:0 !important;">
                            <div class="form-line">
                            <select class="form-control" name="filter" id="sel">
                                <option disabled selected>Filter</option>
                                <option value="both">All Users</option>
                                <option value="normal">Normal Users</option>
                                <option value="business">Business Users</option>
                            </select>   
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-warning">Search</button>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <td>#</td>
                        <td>Name</td>
                        <td>Birth Date</td>
                        <td>Mobile</td>
                        <td>Gender</td>
                        <td>User Type</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                  @foreach($users as $key =>$user)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                        <td>{{$user->birth_date}}</td>
                        <td>{{$user->mobile}}</td>
                        <td>{{$user->gender}}</td>
                        <td>{{$user->user_type}}</td>
                        <td>
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'user-update')
                    @if($user->user_type == 'normal')
                    <a
                    href="{{ url('/admin/user/edit/'.$user->id)}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-success"  ><span>Edit</span></a>
                    @endif
                    @endif
                    @if($permissions['permission']['permission'] == 'user-delete')
                            
                    <a
                    href="{{url('/admin/user/delete/'.$user->id)}}" 
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" ><span>Delete</span></a>          
                    @endif
                    @endforeach        
                </td>
                    </tr>
                   @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$users->links()}}
                    <p>
                        Displaying {{$users->count()}} of {{ $users->total() }} user(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection