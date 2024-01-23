@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2> <h1>Spots</h1></h2>
                    </div></br>
                    <div class="col-sm-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'spot-add')
                    <a
                    href="{{ url('/admin/spot/add')}}"
                    class="btn btn-primary">Add spot</a>
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
                        <td>Address</td>
                        <td>Account Type</td>
                        <td>Mobile</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                @foreach($spots as $key =>$spot)
                   
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$spot['business_name']}}</td>
                        <td>{{$spot['street_no']}} , {{$spot['postal_code']}} , {{$spot['city']}}</td>
                        <td>{{$spot['business_type']}}</td>
                        <td>{{$spot['phone_number']}}</td>
                        <td>
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'spot-update')
                    <a
                    href="{{ url('/admin/spot/edit/'.$spot['id'])}}" 
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-success"><span>Edit</span></a>
                    @endif
                    @if($permissions['permission']['permission'] == 'spot-delete')
                    <a
                    href="{{ url('/admin/spot/delete/'.$spot['id'])}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" ><span>Delete</span></a>          
                    @endif
                    @endforeach         
                </td>
                    </tr>
                
                @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$spots->links()}}
                    <p>
                        Displaying {{$spots->count()}} of {{ $spots->total() }} spot(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection