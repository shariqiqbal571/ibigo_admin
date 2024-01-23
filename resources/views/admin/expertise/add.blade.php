@extends('../layout/admin_layout')

@section('content')

<section class="content">
        <div class="card">
            <div class="body">
            <h1>Add a new Filter</h1>
            <hr>
                <form action="{{ url('/admin/expertise/store')}}" method="post">
                    @csrf
                    <h2 class="card-inside-title">Expertise Name</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="title" class="form-control" placeholder="Expertise Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('title') }}</span>
                                    @endif  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <label>Select Icon</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="icon" id="sel">
                                <option disabled selected>Select Icon</option>
                                @if($fa_array)
                                @foreach($fa_array as $fa_arrays)
                                <option class="{{$fa_arrays}}" value="{{$fa_arrays}}"> {{$fa_arrays}}</option>
                                @endforeach
                                @endif
                               
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
                                    <option value="1"> Enable</option>
                                    <option value="0"> Disable</option>
                               </select>     
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('status') }}</span>
                                    @endif      
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div Class="form-group mt-2">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </div>
                   
                </form>
                </div>
            </div>
        </div>
</section>
@endsection