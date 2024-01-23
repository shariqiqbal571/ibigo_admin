<?php

namespace App\Http\Controllers\Admin\SpotReview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpotDetail;
use App\Time\Time;

class SpotReviewController extends Controller
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
        $reviews = SpotDetail::with(['spot','user'])
        ->paginate(10);
        return view('admin/review/view',compact('reviews'));
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
        $reviews = SpotDetail::with(['spot','user','spotDetailPhotos','spotDetailVideos'])
        ->where('id',$id)
        ->get()
        ->toArray();
        // echo "<pre>";
        // print_r($reviews);
        // exit();
         $current = strtotime( $reviews[0]['review_date_time'] );
         $previous = $this->time->timePrevious($current);
        return view('admin/review/show',compact('reviews','current','previous'));
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
        //
    }
}
