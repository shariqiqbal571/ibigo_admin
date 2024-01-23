<?php

namespace App\Http\Controllers\GroupChat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GroupChat\GroupChatService;

class GroupChatController extends Controller
{
    private $groupChatService;
    private $data = [];

    public function __construct(
        GroupChatService $groupChatService
    )
    
    {
        $this->groupChatService = $groupChatService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->groupChatService->get();
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
    public function store($groupId,Request $request)
    {
        $this->data = [
            'group_id'=>$groupId,
            'message'=>$request->message
        ];
        return $this->groupChatService->create($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->groupChatService->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return $this->groupChatService->deleteAll($id);
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
        return $this->groupChatService->delete($id);
    }
}
