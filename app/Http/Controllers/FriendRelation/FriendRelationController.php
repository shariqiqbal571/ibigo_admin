<?php

namespace App\Http\Controllers\FriendRelation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FriendRelation\FriendRelationService;
use Illuminate\Support\Facades\Auth;

class FriendRelationController extends Controller
{
    private $friendRelationService;
    private $data = [];

    public function __construct(
        FriendRelationService $friendRelationService
    )
    {
        $this->friendRelationService = $friendRelationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $data = $this->friendRelationService->users($id);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendRequest(Request $request)
    {
        $from_user_id = Auth::id();
        $this->data['from_user_id'] = $from_user_id;
        $this->data['to_user_id'] = $request->to_user_id;
        $this->data['relation_status'] = 0;
        $data = $this->friendRelationService->request($this->data);
        
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function acceptRequest(Request $request,$from_user_id)
    {
        $to_user_id = Auth::id();
        $this->data['to_user_id'] = $from_user_id;
        $this->data['from_user_id'] = $to_user_id;
        $this->data['relation_status'] = 1;

        return $this->friendRelationService->accepted($this->data);
        
    }


    public function rejectRequest($from_user_id)
    {
        $to_user_id = Auth::id();
        $this->data['to_user_id'] = $from_user_id;
        $this->data['from_user_id'] = $to_user_id;
        $this->data['relation_status'] = 2;

        return $this->friendRelationService->rejected($this->data);
    }

    public function cancelRequest($from_user_id)
    {
        $to_user_id = Auth::id();
        $this->data['to_user_id'] = $from_user_id;
        $this->data['from_user_id'] = $to_user_id;
        $this->data['relation_status'] = 2;

        return $this->friendRelationService->cancel($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function unfriend($from_user_id)
    {
        $to_user_id = Auth::id();
        $this->data['to_user_id'] = $from_user_id;
        $this->data['from_user_id'] = $to_user_id;
        $this->data['relation_status'] = 3;

        return $this->friendRelationService->unfriendUser($this->data);
    }

    public function block($from_user_id)
    {
        $to_user_id = Auth::id();
        $this->data['to_user_id'] = $from_user_id;
        $this->data['from_user_id'] = $to_user_id;
        $this->data['relation_status'] = 4;

        return $this->friendRelationService->blockUser($this->data);
    }

    public function unblock($from_user_id)
    {
        $to_user_id = Auth::id();
        $this->data['to_user_id'] = $from_user_id;
        $this->data['from_user_id'] = $to_user_id;
        $this->data['relation_status'] = 5;

        return $this->friendRelationService->unblockUser($this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friendList()
    {
        $id = Auth::id();
        $friend_list = $this->friendRelationService->getFriends($id);
        if($friend_list)
        {
            return response()->json([
                'friend_list'=> $friend_list,
                'status_code' => 200,
                'status' => true,
            ]);
        }
        else{
            return response()->json([
                'message'=> 'You have no friends! Send request to stay connected!',
                'status_code' => 401,
                'status' => false,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friendRequest()
    {
        $id = Auth::id();
        // echo "<pre>";
        // print_r($user);
        // exit();
        return $this->friendRelationService->friend($id);
    }

    public function show($id)
    {
        return $this->friendRelationService->view($id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friendSuggestion()
    {
        return $this->friendRelationService->getFriendSuggestion();
    }

    public function searchFriends(Request $request)
    {
        $this->data = [
            'search' => $request->search
        ];
        return $this->friendRelationService->searchForFriends($this->data);
    }
}
