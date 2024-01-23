@extends('../layout/admin_layout')
@section('content')
    <section class="content">
        <h1>Add a new RolePermission</h1>
        <div class="card">
            <div class="body">
                <form action="{{ url('admin/role_permission/store')}}" method="post">
                    @csrf  
                    <label>Select Role</label>       
                    <select class="form-control show-tick" name="role_id">
                    <option disabled selected>-- Please select Role--</option>
                      
                        @foreach($roles as $role)
                            <option value="{{ $role->id}}">{{$role->role}}</option>
                        @endforeach
                    </select>
                    <h2 class="card-inside-title">Select Permissions</h2>
                    @foreach($permissions as $permission)
                        <input type="checkbox" id="md_checkbox_{{$permission->id}}" class="filled-in" name= "permission_id[]" value="{{ $permission->id}}">
                        <label for="md_checkbox_{{$permission->id}}">{{ $permission->permission}}</label>
                    @endforeach
                    <div Class="form-group "></br>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form> 
            </div>    
        </div>
    </section>
@endsection