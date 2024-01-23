@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2>Spot Reviews</h2>
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
                        <td>Spot</td>
                        <td>Review</td>
                        <td>Rating</td>
                        <td>Review Date-Time</td>
                        <td>Action</td>
                    </thead>
                    <tbody>

                    @foreach($reviews as $key =>$review)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td class="text-capitalize">{{$review->user->fullname}} </td>
                        <td class="text-capitalize">{{$review->spot->business_name}} </td>
                        <td class="text-capitalize">{{$review->review}} </td>
                        <td class="text-capitalize">{{$review->rating}} </td>
                        <td>
                        {{date('F j, Y, g:i a',strtotime( $review->review_date_time ))}}
                        </td>
                        <td>
                           
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'review-show')
                    <a
                    href="{{ url('/admin/reviews/view/bed5463sjr8ndend3nc8/'.$review->id)}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-info"  ><span>View</span></a>   
                    @endif
                    @if($permissions['permission']['permission'] == 'review-delete')
                    <a
                    href="{{ url('/admin/reviews/delete/'.$review->id)}}"
                    style="padding-top: 5px;" class="badge rounded-pill btn btn-danger"  ><span>Delete</span></a>                 
                    @endif
                    @endforeach 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$reviews->links()}}
                    <p>
                        Displaying {{$reviews->count()}} of {{ $reviews->total() }} post(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection