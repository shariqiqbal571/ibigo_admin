@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2>Spot Posts</h2>
                    </div></br>
                    <div class="col-sm-2">
                  
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
                        <td>Posted User</td>
                        <td>Posted Date-Time</td>
                        <td>Action</td>
                    </thead>
                    <tbody>

                    @foreach($posts as $key =>$post)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$post->userPost->fullname}} </td>
                        <td>
                        {{date('F j, Y, g:i a',strtotime( $post->created_at ))}}
                        </td>
                        <td>
                           
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'spot-post-show')
                    <a
                    href="{{ url('/admin/spot-post/view/bed5463sjr8ndend3nc8/'.$post->id)}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-info"  ><span>View</span></a>   
                    @endif
                    @if($permissions['permission']['permission'] == 'spot-post-delete')
                    <a
                    href="{{ url('/admin/spot-post/delete/'.$post->id)}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-danger"  ><span>Delete</span></a>                 
                    @endif
                    @endforeach 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$posts->links()}}
                    <p>
                        Displaying {{$posts->count()}} of {{ $posts->total() }} post(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection