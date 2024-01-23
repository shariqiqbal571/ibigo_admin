@extends('../../layout/admin_layout')

@section('content')

    <section class="content">
    <div class="card">
        <div class="body">
            <h1>Add a new Event</h1><hr>
            <form action="{{ url('/admin/event/store')}}" method="post">
                @csrf
                <div class="row clearfix">  
                    <div class="col-sm-12">
                        <label>Event Title</label>
                        <div Class="form-group">
                            <div class="form-line">
                                <input type="text" name="event_title"  class="form-control" placeholder="Event Title" />
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('event_title') }}</span>
                                @endif  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Start Date Time</label>
                        <div Class="form-group">
                            <div class="form-line">
                                <input type="datetime-local"  name="start_date_time"  class="form-control"  />
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('start_date_time') }}</span>
                                @endif  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>End Date Time</label>
                        <div Class="form-group">
                            <div class="form-line">
                                <input type="datetime-local"  name="end_date_time"  class="form-control"  />
                                @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('end_date_time') }}</span>
                                @endif  
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label > Event Description</label>
                        <div class="form-group">
                            <div class="form-line">
                            <textarea id="description" name ="event_description"  rows="4" class="form-control no-resize" placeholder="Enter your Event Details..." ></textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <label >Location</label>
                        <div class="form-group">
                            <div class="form-line">
                            <input type="text"  name="event_location"  class="form-control"  />
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('event_location') }}</span>
                            @endif 
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div Class="form-group mt-2">
                            <button type="submit" class="btn btn-info">Submit</button>&nbsp;&nbsp;
                     </div>
                </div>
            </form>
        </div>
    </div>       

    </section>

@endsection