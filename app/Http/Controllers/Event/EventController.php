<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\Event\EventService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{

    private $eventService;
    private $validator;
    private $data = [];

    public function __construct(
        EventService $eventService,
        Validator $validator
    )
    {
        $this->eventService = $eventService;    
        $this->validator = $validator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        return $this->eventService->get($user_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request,$id)
    {
        $user_ids = [];
        foreach ($request->user_id as $key => $value) {
            $user_ids[] = $value;
        }

        $group_ids = [];
        foreach ($request->group_id as $key => $value) {
            $group_ids[] = $value;
        }
        $this->data = [
            'event_id' => $id,
            'user_id' => implode(',',$user_ids),
            'group_id' => implode(',',$group_ids),
        ];
        return $this->eventService->eventInvite($this->data);
    }

    public function connected($id)
    {
        return $this->eventService->eventConnected($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->data = $request->all();
        $this->data['user_id'] = Auth::id();

        return  $this->eventService->create($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->eventService->view($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user_id = Auth::id();
        $this->data = [
            'user_id' => $user_id,
            'id' => $id
        ];

        if($request->hasFile('event_cover'))
        {
            $destination = 'public/images/event';
            $cover = $request->file('event_cover');
            $event_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$event_cover);

            $this->data['event_cover'] = $event_cover;
        }

        return  $this->eventService->updateCover($this->data);
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
        $user_id = Auth::id();
        $this->data = $request->all();
        $this->data['id'] = $id;
        $this->data['user_id'] = $user_id;

        return  $this->eventService->edit($this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::id();
        $this->data = [
            'id' => $id,
            'user_id' => $user_id,
        ];
        return  $this->eventService->delete($this->data);
    }
}
