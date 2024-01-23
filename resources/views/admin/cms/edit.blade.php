@extends('../layout/admin_layout')

@section('content')

<style>
    option{
        height:100px;
        Scroll-behavior:smooth;
     
    }
    .text{
        padding-left:10px !important;
    }
    
</style>

<section class="content">
        <div class="card">
            <div class="body">
            <h1>Update {{$cms[0]['cms']['title']}}</h1>
            <hr>
                <form action="{{ url('/admin/cms-detail/update/'.$cms[0]['id'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <label>Title</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" disabled value ="{{$cms[0]['cms']['title']}}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>{{$cms[0]['cms']['title']}} Title</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" value="{{$cms[0]['title']}}" name ="title" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>{{$cms[0]['cms']['title']}} Description</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea id="description" name ="description"  rows="4" class="form-control no-resize" placeholder="Enter The Description..." >{{$cms[0]['description']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 images-container">
                            <div class="d-flex">
                                <label>{{$cms[0]['cms']['title']}} Images</label>
                                <button type="button" style="float:right;" href="#" class="add-image btn btn-primary">Add Another Image</button>
                            </div>
                            @if($cms[0]['cms_detail_image'])
                            <div class="row">
                                @foreach($cms[0]['cms_detail_image'] as $images)
                                    <div class="col-sm-2" style="position:relative;">
                                        <img src="{{asset('storage/images/cms/'.$images['images'])}}" width="100" height="100" alt="" srcset="">
                                        <a href="{{url('/delete-image/'.$images['id'])}}" style="position:absolute;right:45px;"><div style="margin:auto;cursor:pointer;border-radius:50%;padding: 5px 8px;" class="btn btn-danger"><i class="material-icons">cancel</i></div></a>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                            <div class="form-group image">
                                <div class="form-line">
                                    <input type="file" name="image[]" accept="image/*" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div Class="form-group mt-2">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
</section>
@endsection