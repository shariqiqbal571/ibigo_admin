@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
             
            <div class="header">
                <div class="row">
                    <div class="col-sm-10">
                    <h2> <h1>Events</h1></h2>
                    </div></br>
                    <div class="col-sm-2">
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'event-add')
                    <a href="{{ url('/admin/event/add')}}" class="btn btn-primary">Add Event</a>
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
                        <td>Event Title</td>
                        <td>Event Start Date Time</td>
                        <td>Event End Date Time</td>
                        <td>Event Location</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
            
                   @foreach($events as $key => $event)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$event->event_title}}</td>
                        <td>{{$event->start_date_time}}</td>
                        <td>{{$event->end_date_time}}</td>
                        <td>{{$event->event_location}}</td>
                        <td>
                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                    @if($permissions['permission']['permission'] == 'event-update')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-success" href="{{ url('/admin/event/edit/'.$event->event_unique_id)}}" ><span>Edit</span></a>
                    @endif
                    @if($permissions['permission']['permission'] == 'event-delete')
                    <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/event/delete/'.$event->id)}}" ><span>Delete</span></a>          
                    @endif
                    @endforeach
                        </td>
                    </tr>
                    @endforeach
          
                    </tbody>
                        
                </table>
                <div class="pagination">
                    {{$events->links()}}
                    <p>
                        Displaying {{$events->count()}} of {{ $events->total() }} event(s).
                    </p>
                </div>
            </div>
                </div>
                
            </div>
        </div>
        

@endsection