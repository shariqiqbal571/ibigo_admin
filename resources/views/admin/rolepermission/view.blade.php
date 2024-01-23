@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="container">
        
                <h1>Roles Permission</h1> 
        </div>
    </div>
    <div class="body">
        <div class="table-responsive">
            <div class="card">
            <div class="header">
            <div class="row"> 
                <div class="col-sm-9">
                <h2>Role Permission Table</h2>
                </div>
                <div class="col-sm-3">
                    <a href="{{ url('/admin/role_permission/add')}}" class="btn btn-primary">Add Roles Permission</a>
                </div>
            </div>    
            </div>
            <div class="body">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <td>#</td>
                        <td>Roles:</td>
                        <td>Permission:</td>
                        <td>Created_at</td>
                        <td>Updated_at</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                   @foreach($rolePermission as $key =>$rolePermissions)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$rolePermissions->role->role}}</td>
                        <td>{{$rolePermissions->permission->permission}}</td>
                        <td>{{$rolePermissions->created_at}}</td>
                        <td>{{$rolePermissions->updated_at}}</td>
                        <td>
                           <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/role_permission/delete/'.$rolePermissions->id)}}" ><span>Delete</span></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$rolePermission->links()}}
                    <p>
                        Displaying {{$rolePermission->count()}} of {{ $rolePermission->total() }} role permission(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection