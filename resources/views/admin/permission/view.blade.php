@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="container">
    </div>
    <div class="body">
        <div class="table-responsive">
            <div class="card">
            <div class="header">
            <h1>Permissions</h1>
            </div>
            <div class="body">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <td>#</td>
                        <td>Permission Name</td>
                        <td>Permission Module</td>
                        <td>Permission</td>
                    </thead>
                    <tbody>
                   @foreach($permissions as $key => $permission)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$permission->permission_name}}</td>
                        <td>{{$permission->permission_module}}</td>
                        <td>{{$permission->permission}}</td>
                        
                    </tr>
                    @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$permissions->links()}}
                    <p>
                        Displaying {{$permissions->count()}} of {{ $permissions->total() }} permission(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection