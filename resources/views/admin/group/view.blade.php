@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2> <h1>Groups</h1></h2>
                    </div></br>
                    <div class="col-sm-2">
                  
                    </div>
                </div>
            </div>
            <div class="body">
              
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <td>#</td>
                        <td>Name</td>
                        <td>Created by</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                   @foreach($groups as $key =>$group)

                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$group->group_name}}</td>
                        <td>{{$group->adminGroup->first_name}} {{$group->adminGroup->last_name}}</td>
                        <td>
                           
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'group-show')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-info" href="{{ url('/admin/group/view/'.$group->id)}}" ><span>View</span></a>          
                    @endif
                    @endforeach
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$groups->links()}}
                    <p>
                        Displaying {{$groups->count()}} of {{ $groups->total() }} group(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection