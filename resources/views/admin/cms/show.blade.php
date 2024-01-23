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
            <h1>Update {{$cms[0]['title']}}</h1>
            <hr>
                <form action="{{ url('/admin/cms-detail/create/'.$cms[0]['id'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <label>Title</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" disabled value ="{{$cms[0]['title']}}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>{{$cms[0]['title']}} Title</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name ="title" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>{{$cms[0]['title']}} Description</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea id="description" name ="description"  rows="4" class="form-control no-resize" placeholder="Enter The Description..." ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 images-container">
                            <div class="d-flex">
                                <label>{{$cms[0]['title']}} Images</label>
                                <button type="button" style="float:right;" href="#" class="add-image btn btn-primary">Add Another Image</button>
                            </div>
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