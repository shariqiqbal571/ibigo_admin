@extends('../layout/admin_layout')

@section('content')

<section class="content">
        <div class="card">
            <div class="body">
            <h1>Add a new Role</h1>
            <hr>
                <form action="{{ url('/admin/role/store')}}" method="post">
                    @csrf
                    <h2 class="card-inside-title">Role Name</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('name') }}</span>
                                    @endif  
                                </div>
                                <h2 class="card-inside-title">Select Permissions</h2>
                    @foreach($permissions as $permission)
                        <input type="checkbox" id="md_checkbox_{{$permission->id}}" class="filled-in" name= "permission_id[]" value="{{ $permission->id}}">
                        <label for="md_checkbox_{{$permission->id}}">{{ $permission->permission}}</label>
                    @endforeach
                        </div>
                        <div Class="form-group mt-2">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                    </div>
                   
                </form>
                </div>
            </div>
        </div>
</section>
@endsection