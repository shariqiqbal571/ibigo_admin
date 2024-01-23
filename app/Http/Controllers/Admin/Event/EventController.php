<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use Illuminate\Support\Str;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('id', 'desc')->paginate(10);
        return view('admin/event/view')->with(compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/event/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'event_title' =>'required',
            'start_date_time' =>'required',
            'end_date_time' =>'required',
            'event_location' =>'required',
        ]);
        if($validator->passes())
        {
            $event = new Event;
            $event->event_title = $request->event_title;
            $event->event_slug = Str::slug($request->event_title);
            $event->event_unique_id = Str::random(32);
            $event->start_date_time = $request->start_date_time;
            $event->end_date_time = $request->end_date_time;
            $event->event_description = $request->event_description;
            $event->event_location = $request->event_location;
            $event->save();
            return redirect('/admin/event')->with('msg','Create Event Successfully.');
        }
        else
        {
            return back()->withErrors($validator)->withInput();
        }   
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
    public function edit($id)
    {
        $events = Event::where('event_unique_id',$id)->get()->toArray();
        // echo "<pre>";
        // print_r($events);
        // exit();
        return view('admin/event/update')->with(compact('events'));
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
        $validator = Validator::make($request->all(),[
            'event_title' =>'required',
            'start_date_time' =>'required',
            'end_date_time' =>'required',
            'event_location' =>'required',
        ]);
        if($validator->passes())
        {

            $event = Event::find($id);
            $event->event_title = $request->event_title;
            $event->event_slug = Str::slug($request->event_title);
            $event->start_date_time = $request->start_date_time;
            $event->end_date_time = $request->end_date_time;
            $event->event_description = $request->event_description;
            $event->event_location = $request->event_location;
            $event->save();
            return redirect('/admin/event')->with('msg','Update Event Successfully.');
        }
        else
        {
            return back()->withErrors($validator)->withInput();
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::find($id)->delete();
        return redirect('/admin/event')->with('msg','Delete Event Successfully.');
    }
}
