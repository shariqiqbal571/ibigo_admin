@extends('../layout/admin_layout')

@section('content')
<section class="content">
        <div class="card">
            <div class="body">
            <h1>Update a Filter</h1>
                <hr>
                <form action="{{ url('/admin/expertise/update/'.$expertise[0]['id'])}}" method="post">
                    @csrf
                    @method('PUT')
                    <h2 class="card-inside-title">Expertise Name</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" value="{{ $expertise[0]['title']}}" name="title" class="form-control" placeholder="Expertise Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('title') }}</span>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-sm-12">
                        <label>Select Icon</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="icon"  id="sel">
                                <option disabled selected>Select Icon</option>
                                    @foreach($fa_array as $fa_arrays)
                                        <option
                                        @if($expertise[0]['icon'] === $fa_arrays)
                                        selected
                                        @endif
                                        value="{{$fa_arrays}}"
                                        class="{{$fa_arrays}}">{{$fa_arrays}}</option>
                                    @endforeach
                                    </select>     
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <label>Select Status</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="status" id="sel">
                                    <option disabled selected>Select Status</option>
                                    <option value="1"
                                    @if($expertise[0]['status'] == 1)
                                    selected
                                    @endif
                                    > Enable</option>
                                    <option value="0"
                                    @if($expertise[0]['status'] == 0)
                                    selected
                                    @endif
                                    > Disable</option>
                               </select>  
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('status') }}</span>
                                    @endif         
                                </div>
                            </div>
                        </div>
                    <div Class="form-group mt-2">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</section>

@endsection