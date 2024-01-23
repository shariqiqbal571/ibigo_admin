@extends('../layout/admin_layout')
<style>
.hide + label:before{
    border:none !important;
}

.hide:checked + label:before {
    border-right: 2px solid #000 !important;
    border-bottom: 2px solid #000 !important;
}
input#sname {
    background-color: hsl(0deg 0% 50% / 14%);
    
}
</style>
@section('content')

<section class="content">
        <div class="card">
            <div class="body"> 
            <h1>Add a new spot</h1>
            <hr> 
                <form action="{{ url('/admin/spot/store')}}" method="post"  enctype="multipart/form-data" >
                    @csrf
                    <div class="row">

                    <div class="col-sm-12">
                        <label>Account Type</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="radio" id="basic"  name="business_type" value="basic">
                                <label for="basic">Basic Account</label>
                                <input type="radio" id="premium"  name="business_type" value="premium">
                                <label for="premium">Premium Account</label>     
                            </div>
                            @if($errors->any())
                                    <span class="text-danger" >{{ $errors->first('business_type') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                
                                <input type="checkbox" class="md_checkbox" id="md_checkbox" class="filled-in" name= ""  >
                                <label for="md_checkbox">I will Add Business Details Manually</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" id="splace">
                        <label >Spot Place</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input id="place" type="text" name ="spot_place" value="{{ old('spot_place')}}" class="form-control" placeholder="Enter your Spot Place">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" id="spot-name" style="display:none;">
                        <label >Spot Name</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="spot_name" value="{{ old('spot_name')}}" class="form-control" placeholder="Enter your Spot Name">
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label >User Profile</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="file" name ="user_profle" value="{{ old('user_profle')}}" class="form-control">
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-6">
                        <label >User Cover</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="file" name ="user_cover" value="{{ old('user_cover')}}"  class="form-control" >
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-6">
                        <label >Spot Profile</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="file" name ="spot_profile" value="{{ old('spot_profile')}}" class="form-control">
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-6">
                        <label >Spot Cover</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="file" name ="spot_cover" value="{{ old('spot_cover')}}" class="form-control" >
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm-6">
                        <label >Shot Description</label>
                        <div class="form-group">
                            <div class="form-line">
                            <textarea id="description" name ="short_description"  rows="4" class="form-control no-resize" placeholder="Enter your Shot Description..." >{{ old('short_description')}}</textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-6">
                        <label >Long Description</label>
                        <div class="form-group">
                            <div class="form-line">
                            <textarea id="description1" name ="long_description"  rows="4" class="form-control no-resize" placeholder="Enter your Long Description..." >{{ old('long_description')}}</textarea>
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">
                    <label >Spot Street & House Number</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="street_no" value="{{ old('street_no')}}"  class="form-control" placeholder="Enter your Spot Street & House Number">
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">
                        <label >Spot Postal Code</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="postal_code" value="{{ old('postal_code')}}" class="form-control" placeholder="Enter your Spot Postal Code">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label >Spot City</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="city" value="{{ old('city')}}" class="form-control" placeholder="Enter your Spot City">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Email</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="email" name ="email" value="{{ old('email')}}" class="form-control"  placeholder="Enter your Email">
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('email') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">      
                        <label >Phone</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="mobile" value="{{ old('mobile')}}" class="form-control" placeholder="Enter your Phone Number">
                            @if($errors->any())
                                <span class="text-danger" >{{ $errors->first('mobile') }}</span>
                            @endif
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-4">      
                        <label >Spot Phone</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="phone_number"  value="{{ old('phone_number')}}" class="form-control" placeholder="Enter your Phone Number">
                            </div>
                        </div>  
                    </div>
                    <!-- <div class="col-sm-6">
                        <label >Latitude</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="latitude"  value="{{ old('latitude')}}" class="form-control" placeholder="Enter your Latitude">
                            </div>
                        </div> 
                    </div> 
                    <div class="col-sm-6">
                        <label >Longitude</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="longitude"  value="{{ old('longitude')}}" class="form-control" placeholder="Enter your Longitude">
                            </div>
                        </div> 
                    </div> 
                     <div class="col-sm-12">
                    </div> -->

                    <div class="col-sm-6">
                        <label >Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="password"  class="form-control" placeholder="Enter your Password" value="0000" disabled>
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label >Confirm Password</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name ="confirm_password"  class="form-control" placeholder="Enter your Password" value="0000" disabled>
                            
                            </div>
                        </div>
                    </div>  
                    <div class="col-sm-12">
                        <label >Select Interests</label>
                        <div class="form-group">
                            <div class="form-line">
                            @if($interests)
                            @foreach($interests as $interest)
                            
                            <input type="checkbox" id="md_checkbox_{{$interest['id']}}" class=" chk-col-white" name= "user_interests[]" value="{{ $interest['id']}}">
                            <label class="" style="position: absolute;padding: 50px;" for="md_checkbox_{{$interest['id']}}">
                            </label>
                            <img src="{{ asset('storage/images/interests/'.$interest['image'])}}" style="width:100px; height:100px" alt="User" />
                               
                           @endforeach   
                           @endif                   
                            </div>
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div Class="form-group ">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>    
        </div>
            
</section>
@endsection