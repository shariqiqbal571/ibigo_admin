<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $postService;
    private $data = [];

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function userPost()
    {
        return $this->postService->getUserPost();
    }

    public function checkinPost()
    {
        return $this->postService->getcheckinPost();
    }

    public function groupPost()
    {
        return $this->postService->getGroupPost();
    }

    public function spotPost()
    {
        return $this->postService->getSpotPost();
    }

    public function recentUser()
    {
        return $this->postService->getRecentUser();
    }

    public function sharePost($id)
    {
        return $this->postService->getSharePost($id);
    }

    public function shareUpdatePost(Request $request,$id)
    {
        $share_group_id = [];
        if($request->shared_group_id)
        {
            foreach ($request->shared_group_id as $shared_group_id)
            {
                $share_group_id[] = $shared_group_id;
            }
            $this->data['shared_group_id'] = implode(',',$share_group_id);
        }

        $share_user_id = [];
        if($request->shared_user_id)
        {
            foreach ($request->shared_user_id as $shared_user_id)
            {
                $share_user_id[] = $shared_user_id;
            }
            $this->data['shared_user_id'] = implode(',',$share_user_id);
        }
        return $this->postService->sendShareUpdate($this->data,$id);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return $this->postService->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function commentPost(Request $request,$id)
    {
        $this->data = [
            'post_id'=>$id,
            'comment'=>$request->comment
        ];        
        return $this->postService->comment($this->data);
    }

    public function updateCommentPost(Request $request,$id)
    {
        $this->data = [
            'id' =>$id,
            'comment' =>$request->comment
        ];
        return $this->postService->updateComment($this->data);
    }

    public function deleteCommentPost($id)
    {
        return $this->postService->deleteComment($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->data = $request->all();
        if($request->hasFile('post_images'))
        {
            $images = [];
            foreach ($request->file('post_images') as $image) {
                $destination = 'public/images/post/images';
                $post_images = uniqid().$image->getClientOriginalName();
                $path = $image->storeAs($destination,$post_images);
                $images[] = $post_images;
            }
            $this->data['post_images'] = implode(',', $images);
        }

        if($request->hasFile('post_videos'))
        {
            $videos = [];
            foreach ($request->file('post_videos') as $video) {
                $destination = 'public/videos/post/videos';
                $post_videos = uniqid().$video->getClientOriginalName();
                $path = $video->storeAs($destination,$post_videos);
                // $video->move($destination,$post_videos);
                $videos[] = $post_videos;
            }
            $this->data['post_videos'] = $videos;
        }

        // echo "<pre>";
        // print_r($this->data['post_videos']);
        // exit();
        if($request->hasFile('post_audios'))
        {
            $audios = [];
            foreach ($request->file('post_audios') as $audio) {
                $destination = 'public/audios/post/audios';
                $post_audios = uniqid().$audio->getClientOriginalName();
                $path = $audio->storeAs($destination,$post_audios);
                // $audio->move($destination,$post_audios);
                $audios[] = $post_audios;
            }
            $this->data['post_audios'] = $audios;
        }

        if($request->hasFile('record_images'))
        {
            $images = [];
            foreach ($request->file('record_images') as $image) {
                $destination = 'public/images/post/images';
                $record_images = uniqid().$image->getClientOriginalName();
                $path = $image->storeAs($destination,$record_images);
                $images[] = $record_images;
            }
            $this->data['record_images'] = implode(',', $images);
        }

        if($request->hasFile('record_videos'))
        {
            $videos = [];
            foreach ($request->file('record_videos') as $video) {
                $destination = 'public/videos/post/videos';
                $record_videos = uniqid().$video->getClientOriginalName();
                $path = $video->storeAs($destination,$record_videos);
                // $video->move($destination,$record_videos);
                $videos[] = $record_videos;
            }
            $this->data['record_videos'] = $videos;
        }

        if($request->hasFile('record_audios'))
        {
            $audios = [];
            foreach ($request->file('record_audios') as $audio) {
                $destination = 'public/audios/post/audios';
                $record_audios = uniqid().$audio->getClientOriginalName();
                $path = $audio->storeAs($destination,$record_audios);
                // $audio->move($destination,$record_audios);
                $audios[] = $record_audios;
            }
            $this->data['record_audios'] = $audios;
        }

        $tagged_user_id = [];
        if($request->tagged_user_id)
        {
            foreach ($request->tagged_user_id as $key => $value) {
                $tagged_user_id[] = $value;
            }
            $this->data['tagged_user_id'] = implode(',',$tagged_user_id);
        }

        $user_ids = [];
        if($request->user_id)
        {
            foreach ($request->user_id as $key => $value) {
                $user_ids[] = $value;
            }
            $this->data['user_ids'] = implode(',',$user_ids);
        }
        $post = $this->postService->create($this->data);

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data[] = $id; 
        return $this->postService->view($this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function likePost(Request $request ,$id)
    {
        return $this->postService->like($id);
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
        $this->data = $request->all();
        $this->data['id'] = $id;
        if($request->hasFile('post_images'))
        {
            $images = [];
            foreach ($request->file('post_images') as $image) {
                $destination = 'public/images/post/images';
                $post_images = uniqid().$image->getClientOriginalName();
                $path = $image->storeAs($destination,$post_images);
                $images[] = $post_images;
            }
            $this->data['post_images'] = implode(',', $images);
        }

        if($request->hasFile('post_videos'))
        {
            $videos = [];
            foreach ($request->file('post_videos') as $video) {
                $destination = 'public/videos/post/videos';
                $post_videos = uniqid().$video->getClientOriginalName();
                $path = $video->storeAs($destination,$post_videos);
                $videos[] = $post_videos;
            }
            $this->data['post_videos'] = implode(',', $videos);
        }

        if($request->hasFile('post_audios'))
        {
            $audios = [];
            foreach ($request->file('post_audios') as $audio) {
                $destination = 'public/audios/post/audios';
                $post_audios = uniqid().$audio->getClientOriginalName();
                $path = $audio->storeAs($destination,$post_audios);
                $audios[] = $post_audios;
            }
            $this->data['post_audios'] = implode(',', $audios);
        }

        $tagged_user_id = [];
        if($request->tagged_user_id)
        {
            foreach ($request->tagged_user_id as $tagged_user_id)
            {
                $tagged_user_id[] = $tagged_user_id;
            }
            $this->data['tagged_user_id'] = implode(',',$tagged_user_id);
        }

        $post = $this->postService->edit($this->data);

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->postService->delete($id);
    
    }

    public function allPost($take)
    {
        return $this->postService->getAllPost($take);
    }

    public function sharePostInGroup(Request $request,$id)
    {
        $this->data = $request->all();
        if($request->hasFile('post_images'))
        {
            $images = [];
            foreach ($request->file('post_images') as $image) {
                $destination = 'public/images/post/images';
                $post_images = uniqid().$image->getClientOriginalName();
                $path = $image->storeAs($destination,$post_images);
                $images[] = $post_images;
            }
            $this->data['post_images'] = implode(',', $images);
        }

        if($request->hasFile('post_videos'))
        {
            $videos = [];
            foreach ($request->file('post_videos') as $video) {
                $destination = 'public/videos/post/videos';
                $post_videos = uniqid().$video->getClientOriginalName();
                $path = $video->storeAs($destination,$post_videos);
                // $video->move($destination,$post_videos);
                $videos[] = $post_videos;
            }
            $this->data['post_videos'] = $videos;
        }

        // echo "<pre>";
        // print_r($this->data['post_videos']);
        // exit();
        if($request->hasFile('post_audios'))
        {
            $audios = [];
            foreach ($request->file('post_audios') as $audio) {
                $destination = 'public/audios/post/audios';
                $post_audios = uniqid().$audio->getClientOriginalName();
                $path = $audio->storeAs($destination,$post_audios);
                // $audio->move($destination,$post_audios);
                $audios[] = $post_audios;
            }
            $this->data['post_audios'] = $audios;
        }

        if($request->hasFile('record_images'))
        {
            $images = [];
            foreach ($request->file('record_images') as $image) {
                $destination = 'public/images/post/images';
                $record_images = uniqid().$image->getClientOriginalName();
                $path = $image->storeAs($destination,$record_images);
                $images[] = $record_images;
            }
            $this->data['record_images'] = implode(',', $images);
        }

        if($request->hasFile('record_videos'))
        {
            $videos = [];
            foreach ($request->file('record_videos') as $video) {
                $destination = 'public/videos/post/videos';
                $record_videos = uniqid().$video->getClientOriginalName();
                $path = $video->storeAs($destination,$record_videos);
                // $video->move($destination,$record_videos);
                $videos[] = $record_videos;
            }
            $this->data['record_videos'] = $videos;
        }

        if($request->hasFile('record_audios'))
        {
            $audios = [];
            foreach ($request->file('record_audios') as $audio) {
                $destination = 'public/audios/post/audios';
                $record_audios = uniqid().$audio->getClientOriginalName();
                $path = $audio->storeAs($destination,$record_audios);
                // $audio->move($destination,$record_audios);
                $audios[] = $record_audios;
            }
            $this->data['record_audios'] = $audios;
        }

        $tagged_user_id = [];
        if($request->tagged_user_id)
        {
            foreach ($request->tagged_user_id as $key => $value) {
                $tagged_user_id[] = $value;
            }
            $this->data['tagged_user_id'] = implode(',',$tagged_user_id);
        }

        $user_ids = [];
        if($request->user_id)
        {
            foreach ($request->user_id as $key => $value) {
                $user_ids[] = $value;
            }
            $this->data['user_ids'] = implode(',',$user_ids);
        }
        $this->data['post_id'] = $id;
        return $this->postService->share($this->data);
    }

    public function allGroupPost($id)
    {
        return $this->postService->getAllGroupPost($id);
    }
}
