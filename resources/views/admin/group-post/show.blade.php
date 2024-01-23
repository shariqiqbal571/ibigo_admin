@extends('../../layout/admin_layout')

@section('content')

<section class="content">
    <div class="body">
        <div class="table-responsive">
            <div class="card">
                <div class="header">
                    <div class="row">
                        <div class="col-sm-10">
                            <h2>Group Post Information</h2>
                        </div></br>
                    </div>
                </div>
                <div class="body">
                    <div class="row">
                    <div class="col-sm-12">
                        <div style=" display: flex;" width="25%">
                            @if(!$posts[0]['user_post']['user_profile'])
                                <img  src="{{ asset('assets/images/post-profile.png')}}" style="width:50px; height: 50px; margin-right:15px;  border-radius: 50%;" controls alt="User" />
                            @else
                                <img  src="{{ asset('storage/images/user/profile/'.$posts[0]['user_post']['user_profile'])}}" style="width:50px; height: 50px; margin-right:15px;  border-radius: 50%;" controls alt="User" />
                            @endif
                        <div>
                            <label style="color:#00BDFE">{{$posts[0]['user_post']['fullname']}}</label>
                            <p>{{$previous}} ago</p>

                            </div>
                        </div> 
                    </div>
                        @if(isset($posts[0]['post_images'][0]['post_images']))
                        <div class="col-sm-12">
                            <label>Post Image</label>
                        </div>                           
                        @foreach($posts[0]['post_images'] as $key => $post)
                        <div class="col-sm-2">
                            <div Class="form-group">
                                <div class="form-line">
                                    <img  src="{{ asset('storage/post/post_images/'.$post['post_images'])}}" style="border-radius: 50px; width:100%;height:200px;" controls alt="User" />
                                </div>  
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if(isset($posts[0]['post_videos'][0]['post_videos']))
                            <div class="col-sm-12">
                                <label>Post video</label>
                            </div>
                                @foreach($posts[0]['post_videos'] as $key => $post)
                                <div class="col-sm-3">
                                    <div Class="form-group">
                                        <div class="form-line">
                                            <video style="border-radius: 10px; width:100%;height:200px;" controls>
                                                <source src="{{ asset('storage/post/post_videos/'.$post['post_videos'])}}" type="video/ogg">
                                            </video>
                                        </div>  
                                    </div>
                                </div>        
                            @endforeach 
                        @endif


                        @if(isset($posts[0]['post_audios'][0]['post_audios']))
                            <div class="col-sm-12">
                                <label>Post Audio</label>
                            </div> 
                            @foreach($posts[0]['post_audios'] as $key => $post) 
                            <div class="col-sm-3">  
                                <div Class="form-group">
                                    <div class="form-line">
                                        <audio controls>
                                            <source src="{{ asset('storage/post/post_audios/'.$post['post_audios'])}}" type="audio/mpeg">
                                        </audio>
                                    </div>  
                                </div>
                            </div>
                            @endforeach 
                        @endif
                    
                        <div class="col-sm-10">
                      
                                <i  style="float:left;" class="material-icons">favorite</i>
                                <p style="float:left;margin: 4px;">Like ( {{isset($like['count_like'][0]) ? $like['count_like'][0] : '0'}} )</p>
    
                        </div>
                        <div class="col-sm-2">
                            <i  style="float:left;" class="material-icons">comment</i>
                            <p style="float:left;margin: 4px;">Comment ( {{isset($like['count_comment'][0]) ? $like['count_comment'][0] : '0'}} )</p>
                        </div>

                        @foreach($posts[0]['post_comment'] as $key => $post)  
                            @if(isset($post['comment']))
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-2 text-center" style="margin-top: 35px !important; padding-right: 0 !important">
                                            @if(!$post['user']['user_profile'])
                                                <img  src="{{ asset('assets/images/post-profile.png')}}" style="width:100px; height: 100px; margin-right:15px;  border-radius: 50%;" controls alt="User" />
                                            @else
                                                <img  src="{{ asset('storage/images/user/profile/'.$post['user']['user_profile'])}}" style="width:100px; height: 100px; margin-right:15px;  border-radius: 50%;" controls alt="User"/>
                                            @endif
                                        </div>
                                        <div class="col-sm-10" style="padding-left: 0 !important">
                                            <div class="header">
                                                <h2>
                                                    {{$posts[0]['user_post']['first_name'].' '.$posts[0]['user_post']['last_name']}} 
                                                <small>
                                               
                                                    {{date('F j, Y, g:i a',strtotime($post['updated_at'] ))}}
                                                </small>
                                                </h2>
                                            </div>
                                            <div class="body">
                                               {{$post['comment'] }}
                                                
                                                </br></br>
                                                <a style="padding-top: 5px;" class="badge rounded-pill btn btn-danger" href="{{ url('/admin/group-post/comment/delete/'.$post['id'])}}" ><span>Delete</span></a>                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif    
                        @endforeach
                    </div>
                </div>
               
            </div>        
        </div>
    </div>
    <script>
       
    </script>
        

@endsection