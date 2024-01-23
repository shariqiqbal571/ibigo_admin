<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Chat\ChatService;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private $chatService;
    private $data = [];
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->chatService->recent();
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
    public function store(Request $request,$id)
    {
        $this->data = [
            'to_user_id' => $id,
            'message_date_time' => now(),
            'is_read'=> 0
        ];
        if($request->hasFile('image'))
        {
            $destination = 'public/images/chat/';
            $image = $request->file('image');
            $image_name = Str::uuid().$image->getClientOriginalName();

            $path = $image->storeAs($destination,$image_name);

            $this->data['message'] = $image_name;
            $this->data['message_type'] = 'image';

        }
        else{
            $this->data['message'] = $request->message;
            $this->data['message_type'] = 'text';
        }
        return $this->chatService->create($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->chatService->get($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friends()
    {
        return $this->chatService->recentFriends();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request, $id)
    {
        $this->data = [
            'from_user_id'=>$id,
            'is_read'=>1
        ];
        return $this->chatService->readMessage($this->data);
    }

    public function unread(Request $request, $id)
    {
        $this->data = [
            'from_user_id'=>$id,
            'is_read'=>0
        ];
        return $this->chatService->unreadMessage($this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->chatService->deleteChat($id);
    }
}
