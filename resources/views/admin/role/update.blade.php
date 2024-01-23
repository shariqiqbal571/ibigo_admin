@extends('../layout/admin_layout')

@section('content')
<section class="content">
        <div class="card">
            <div class="body">
            <h1>Update a Role</h1>
                <hr>
                <form action="{{ url('/admin/role/update/'.$roles->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <h2 class="card-inside-title">Role Name</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" value="{{ $roles->role}}" name="name" class="form-control" placeholder="Enter Name" />
                                    @if($errors->any())
                                        <span class="text-danger" >{{ $errors->first('name') }}</span>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($permissions)
                        @foreach($permissions as $permission)
                            <input
                                @foreach($rolePermission as $rolePermissions)
                                    @if($permission->id === $rolePermissions['permission_id'])
                                        checked
                                    @endif
                                @endforeach
                            type="checkbox" id="md_checkbox_{{$permission->id}}" class="filled-in" name= "permission_id[]" value="{{ $permission->id}}">
                            <label for="md_checkbox_{{$permission->id}}">{{ $permission->permission}}</label>
                        @endforeach
                    @endif
                    <div Class="form-group mt-2">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
</section>

@endsection