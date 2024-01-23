@extends('../../layout/admin_layout')

@section('content')
    <section class="content">
        <div class="body">
            <div class="table-responsive">
                <div class="card">
                <div class="header">
                
                    <div class="row">
                        <div class="col-md-10">
                        <h1>Interests</h1> 
                        </div></br>
                        <div class="col-md-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'interest-add')
                        <a href="{{ url('/admin/interest/add')}}" class="btn btn-primary">Add Interest</a>
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
                            <td>Title:</td>
                            <td>Icon</td>
                            <td>Image</td>
                            <td>Action</td>
                        </thead>
                        <tbody>
                        @foreach($interests as $key =>$interest)
                        <tr>
                       
                            <td>{{$key + 1}}</td>
                            <td>{{$interest['title']}}</td>
                            <td><i style="font-size:30px;" class="{{$interest['icon']}}"></i></td>
                            <td>
                            <img src="{{ asset('storage\images\interests/'.$interest['image'])}}" style="width:100px; height:60px" alt="User" /></br>
                            </td>
                            <td>
                           
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'interest-update')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{url('/admin/interest/edit/'.$interest->unique_id)}}" ><span>Edit</span></a>
                    @endif
                    @if($permissions['permission']['permission'] == 'interest-delete')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/interest/delete/'.$interest->id)}}" ><span>Delete</span></a>
                    @endif
                    @endforeach
                            </td>
                       
                        </tr>
                        @endforeach
                      
                        </tbody>
                            
                    </table>
                <div class="pagination">
                    {{$interests->links()}}
                    <p>
                        Displaying {{$interests->count()}} of {{ $interests->total() }} interest(s).
                    </p>
                </div>
                </div>
                    </div>
                    
                </div>
            </div>
            
    </section>  
@endsection