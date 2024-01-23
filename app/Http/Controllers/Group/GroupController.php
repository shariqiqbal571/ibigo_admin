<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Group\GroupService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    private $groupService;
    private $data = [];

    public function __construct(
        GroupService $groupService
    )
    
    {
        $this->groupService = $groupService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->groupService->groups();
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
        $this->data = $request->all();

        if($request->hasFile('group_profile'))
        {
            $destination = 'public/images/group/group_profile';
            $profile = $request->file('group_profile');
            $group_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$group_profile);
            
            $this->data['group_profile'] = $group_profile;
        }

        if($request->hasFile('group_cover'))
        {
            $destination = 'public/images/group/group_cover';
            $cover = $request->file('group_cover');
            $group_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$group_cover);
            
            $this->data['group_cover'] = $group_cover;
        }

        $users=[];
        if($request->user_id)
        {
            foreach($request->user_id as $key => $user_id)
            {
                $users[] = $user_id;
            }
        }

        $admins=[];
        if($request->admin_id)
        {
            foreach($request->admin_id as $key => $admin_id)
            {
                $admins[] = $admin_id;
            }
        }
        $admins[] = Auth::id();
        $this->data['user_id'] = $users;
        $this->data['admin_id'] = $admins;
        // echo "<pre>";
        // print_r($this->data);
        // exit();
        return $this->groupService->create($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo "<pre>";
        // print_r($this->data);
        // exit();
        return $this->groupService->group($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userGroup()
    {
        return $this->groupService->usersGroups();
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->data = [
            'id' => $id,
            'group_name'=>$request->group_name,
            'group_slug'=>$request->group_slug,
            'group_description'=>$request->group_description,
            'group_profile'=>$request->group_profile,
            'group_cover'=>$request->group_cover,
        ];

        if($request->hasFile('group_profile'))
        {
            $destination = 'public/images/group/group_profile';
            $profile = $request->file('group_profile');
            $group_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$group_profile);
            
            $this->data['group_profile'] = $group_profile;
        }

        if($request->hasFile('group_cover'))
        {
            $destination = 'public/images/group/group_cover';
            $cover = $request->file('group_cover');
            $group_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$group_cover);
            
            $this->data['group_cover'] = $group_cover;
        }
        // echo "<pre>";
        // print_r($this->data);
        // exit();
        return $this->groupService->edit($this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->groupService->delete($id);
    }

    public function groupOrUser($id)
    {
        return $this->groupService->getGroupOrUser($id);
    }

    public function searchGroup(Request $request)
    {
        $this->data = [
            'search'=>$request->search
        ];
        return $this->groupService->getSearchGroup($this->data);
    }
}
