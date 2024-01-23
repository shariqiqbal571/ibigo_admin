<?php

namespace App\Http\Controllers\UserGroupRelation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GroupUser\GroupUserService;
use Illuminate\Support\Facades\Auth;

class UserGroupRelationController extends Controller
{
    private $groupUserService;
    private $data = [];

    public function __construct(GroupUserService $groupUserService)
    {
        $this->groupUserService = $groupUserService;
    }

    public function userGroupId($groupId)
    {
        $id = Auth::id();
        return $this->data = [
            'user_id' => $id,
            'group_id' => $groupId
        ];
    }

    public function invitedId($request,$groupId)
    {
        $id = Auth::id();
        $user_id = [];
        foreach ($request->user_id as $key => $value) {
            $user_id[] = $value;
        }
        return $this->data = [
            'user_id' => implode(',',$user_id),
            'group_id' => $groupId,
            'invited_by' => $id
        ];
    }

    public function index($groupId)
    {
        return $this->groupUserService->getInvitedFriends($groupId);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptRequest(Request $request,$groupId)
    {
        $id = Auth::id();
        $this->data = [
            'user_id' => $request->user_id,
            'group_id' => $groupId,
            'invited_by' => $id
        ];
        return $this->groupUserService->accept($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leaveGroup($groupId)
    {
        $data = $this->userGroupId($groupId);
        return $this->groupUserService->leave($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendInvitation(Request $request, $groupId)
    {
        $data = $this->invitedId($request,$groupId);

        return $this->groupUserService->send($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function joinRequest($groupId)
    {
        $data = $this->userGroupId($groupId);

        return $this->groupUserService->join($data);
    }

    public function pendingInvitation()
    {
        return $this->groupUserService->getPendingInvitation();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelRequest($groupId)
    {
        $data = $this->userGroupId($groupId);

        return $this->groupUserService->cancel($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmInvitation(Request $request,$groupId)
    {
        $data = $this->userGroupId($groupId);

        return $this->groupUserService->confirm($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectInvitation($groupId)
    {
        $data = $this->userGroupId($groupId);

        return $this->groupUserService->reject($data);
    }

    public function makeAdmin(Request $request,$groupId)
    {
        $id = Auth::id();
        $this->data = [
            'user_id' => $request->user_id,
            'group_id' => $groupId,
            'invited_by' => $id
        ];

        return $this->groupUserService->adminOrNot($this->data);
    }

    public function removeMember(Request $request,$groupId)
    {
        $id = Auth::id();
        $this->data = [
            'user_id' => $request->user_id,
            'group_id' => $groupId,
            'auth_id' => $id
        ];
        return $this->groupUserService->removeUser($this->data);
    }

}
