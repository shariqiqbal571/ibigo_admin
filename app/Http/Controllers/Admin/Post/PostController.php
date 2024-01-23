<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use Carbon\Carbon;
use App\Time\Time;

class PostController extends Controller
{
    private $time;
    public function __construct(Time $time)
    {
        $this->time = $time;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $value = 'normal';
        $posts = Post
        ::orderBy('id', 'desc')->with(['userPost'])
        ->select(['id','user_id','created_at'])
       ->whereHas('userPost',function($user) use ($value){
               $user->where('user_type',$value);
       })
       ->where('spot_id',null)
       ->where('group_id',null)
       ->where('event_id',null)
       ->paginate(10);
    //    ->get(['id','user_id','created_at'])
    //    ->toArray();
    //    return $posts;
        // echo "<pre>";
        // print_r($posts);
        // exit(); 


        
        return view('admin/post/view',['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($unique,$id)
    {
        $posts = Post::with(['userPost','postLike','postLike.user','postComment','postComment.user','postImages','postVideos','postAudios'])
       ->where('id',$id)
       ->get()
       ->toArray();
       
       $like['count_like'] = [];
       $like['count_comment'] = [];
       
        foreach($posts as $key => $value) {
            $like['count_like'][] = count($value['post_like']);
            $like['count_comment'][] = count($value['post_comment']);
        }

        $current = strtotime( $posts[0]['created_at'] );
        $previous = $this->time->timePrevious($current);

        // echo $previous.'<br>';
        // exit();
        // echo "<pre>";
        // print_r($posts);
        // exit(); 

        return view('admin/post/show')->with(compact('posts','like','previous'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return redirect('/admin/post')->with('msg','Post Delete Successfully.');
    }

    public function commentDelete($id)
    {
        PostComment::find($id)->delete();
        return redirect('/admin/post')->with('msg','User Comment Delete Successfully.');
    }
    
}


