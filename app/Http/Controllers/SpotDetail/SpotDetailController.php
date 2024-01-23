<?php

namespace App\Http\Controllers\SpotDetail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SpotDetail\SpotDetailService;

class SpotDetailController extends Controller
{
    private $spotDetailService;
    private $data = [];

    public function __construct(
        SpotDetailService $spotDetailService
    )
    {
        $this->spotDetailService = $spotDetailService;
    }

    public function post($request,$id)
    {
        $this->data = $request->all();
        $this->data['id'] = $id;
        if($request->hasFile('review_photo'))
        {
            $images = [];
            foreach ($request->file('review_photo') as $image) {
                $destination = 'public/images/review/images';
                $review_photo = uniqid().$image->getClientOriginalName();
                $path = $image->storeAs($destination,$review_photo);
                $images[] = $review_photo;
            }
            $this->data['review_photo'] = implode(',', $images);
        }

        if($request->hasFile('review_video'))
        {
            $videos = [];
            foreach ($request->file('review_video') as $video) {
                $destination = 'public/videos/review/videos';
                $review_video = uniqid().$video->getClientOriginalName();
                $path = $video->storeAs($destination,$review_video);
                $videos[] = $review_video;
            }
            $this->data['review_video'] = $videos;
        }

        return $this->data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->spotDetailService->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadMedia(Request $request,$id)
    {
        $add = $this->post($request, $id);
        $spotDetail = $this->spotDetailService->spotMedia($add);

        return $spotDetail;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $add = $this->post($request, $id);
        $spotDetail = $this->spotDetailService->create($add);

        return $spotDetail;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function like($id)
    {
        return $this->spotDetailService->likeSpot($id);
    }


    public function connected($id)
    {
        return $this->spotDetailService->connectedSpot($id);
    }

    public function invite(Request $request, $id)
    {
        $this->data = [
            'spot_id'=>$id,
        ];
        
        $invited_user_id = [];
        if($request->invited_user_id)
        {
            foreach ($request->invited_user_id as $key => $value) {
                $invited_user_id[] = $value;
            }
            $this->data['invited_user_id'] = implode(',',$invited_user_id);
        }

        // echo "<pre>";
        // print_r($this->data);
        // exit();
        return $this->spotDetailService->inviteFriends($this->data);
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
        $add = $this->post($request, $id);
        $spotDetail = $this->spotDetailService->edit($add);

        return $spotDetail;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->spotDetailService->delete($id);
    }

    public function storeReply(Request $request,$id)
    {
        // $add = $this->post($request, $id);
        $this->data = [
            'spot_id' => $id,
            'review' => $request->review
        ];
        return $this->spotDetailService->addReply($this->data);
    }

    public function updateReply(Request $request,$id)
    {
        // $add = $this->post($request, $id);
        $this->data = [
            'id' => $id,
            'review' => $request->review
        ];
        return $this->spotDetailService->editReply($this->data);
    }

    public function destroyReply($id)
    {
        return $this->spotDetailService->deleteReply($id);
    }
}
