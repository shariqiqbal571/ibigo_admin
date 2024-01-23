@extends('../layout/admin_layout')

@section('content')

<section class="content">
        <div class="card">
            <div class="body">
            <h1>Add a new Filter</h1>
            <hr>
                <form action="{{ url('/admin/filters/store')}}" method="post">
                    @csrf
                    <h2 class="card-inside-title">Filter Name</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" class="form-control" placeholder="Filter Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('name') }}</span>
                                    @endif  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <label>Select Type</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="type" id="sel1">
                                    <option disabled selected>Select Type</option>
                                    <option value="text"> Text</option>
                                    <option value="datetime-local"> Date & Time</option>
                                    <option value="checkbox"> Checkbox</option>
                                    <option value="radio"> Radio</option>
                               </select>  
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('type') }}</span>
                                    @endif         
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <label>Select Status</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="status" id="sel2">
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
                        <label>Select Category</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="category" id="sel3">
                                    <option disabled selected>Select Category</option>
                                    <option value="address"> Address</option>
                                    <option value="who"> Who</option>
                                    <option value="what"> What</option>
                                    <option value="when"> When</option>
                                    <option value="categorieen"> Categorieen</option>
                                    <option value="specials"> Specials</option>
                               </select>     
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('category') }}</span>
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