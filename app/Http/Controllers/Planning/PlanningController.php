<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Planning\PlanningService;

class PlanningController extends Controller
{
    private $planningService;
    private $data = []; //

    public function __construct(PlanningService $planningService)
    {
        $this->planningService = $planningService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->planningService->get();
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
        $this->data = [
            'spot_id'=>$request->spot_id,
            'event_id'=>$request->event_id,
            'planning_title'=>$request->planning_title,
            'planning_description'=>$request->planning_description,
            'start_date_time'=>$request->start_date_time,
            'end_date_time'=>$request->end_date_time,
        ];
        $user_ids = [];
        if($request->invite_user_id)
        {
            foreach ($request->invite_user_id as $invite_user_id)
            {
                $user_ids[] = $invite_user_id;
            }
            $this->data['invite_user_id'] = implode(',',$user_ids);
        }
        return $this->planningService->add($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return $this->planningService->eventCalender();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendInvitation(Request $request,$id)
    {
        $this->data = [
            'invite_user_id'=>$request->invite_user_id,
            'planning_id'=>$id
        ];
        return $this->planningService->send($this->data);
    }

    public function acceptInvitation($id)
    {
        return $this->planningService->accept($id);
    }

    public function rejectInvitation($id)
    {
        return $this->planningService->reject($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->planningService->share($request->planning_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invitationPending($id)
    {
        return $this->planningService->pending($id);
    }
}
