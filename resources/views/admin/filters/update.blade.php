@extends('../layout/admin_layout')

@section('content')
<section class="content">
        <div class="card">
            <div class="body">
            <h1>Update a Filter</h1>
                <hr>
                <form action="{{ url('/admin/filters/update/'.$filter[0]['id'])}}" method="post">
                    @csrf
                    @method('PUT')
                    <h2 class="card-inside-title">Filter Name</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" value="{{ $filter[0]['name']}}" name="name" class="form-control" placeholder="Filter Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('name') }}</span>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label>Select Type</label>
                            <div class="form-group">
                                <div class="form-line">
                                <select class="form-control" name="type" id="sel">
                                    <option disabled selected>Select Type</option>
                                    <option value="text"
                                    @if($filter[0]['type'] == 'text')
                                    selected
                                    @endif
                                    > Text</option>
                                    <option value="datetime-local"
                                    @if($filter[0]['type'] == 'datetime-local')
                                    selected
                                    @endif
                                    > Date & Time</option>
                                    <option value="checkbox"
                                    @if($filter[0]['type'] == 'checkbox')
                                    selected
                                    @endif
                                    > Checkbox</option>
                                    <option value="radio"
                                    @if($filter[0]['type'] == 'radio')
                                    selected
                                    @endif
                                    > Radio</option>
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
                                <select class="form-control" name="status" id="sel">
                                    <option disabled selected>Select Status</option>
                                    <option value="1"
                                    @if($filter[0]['status'] == 1)
                                    selected
                                    @endif
                                    > Enable</option>
                                    <option value="0"
                                    @if($filter[0]['status'] == 0)
                                    selected
                                    @endif
                                    > Disbale</option>
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
                                    <option value="address"
                                    @if($filter[0]['category'] == 'address')
                                    selected
                                    @endif
                                    > Address</option>
                                    <option value="who"
                                    @if($filter[0]['category'] == 'who')
                                    selected
                                    @endif
                                    > Who</option>
                                    <option value="what"
                                    @if($filter[0]['category'] == 'what')
                                    selected
                                    @endif
                                    > What</option>
                                    <option value="when"
                                    @if($filter[0]['category'] == 'when')
                                    selected
                                    @endif
                                    > When</option>
                                    <option value="categorieen"
                                    @if($filter[0]['category'] == 'categorieen')
                                    selected
                                    @endif
                                    > Categorieen</option>
                                    <option value="specials"
                                    @if($filter[0]['category'] == 'specials')
                                    selected
                                    @endif
                                    > Specials</option>
                               </select>     
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('category') }}</span>
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