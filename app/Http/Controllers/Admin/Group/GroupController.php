<?php

namespace App\Http\Controllers\Admin\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Models\GroupUser;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $value = 'normal';
        $groups = Group::with(['adminGroup'])
        ->select(['id','user_id','group_name'])
        ->whereHas('adminGroup',function($user) use ($value){
                $user->where('user_type',$value);
        })
        ->paginate(10);
        // echo "<pre>";
        // print_r($groups);
        // exit();
        return view('admin/group/view',['groups'=>$groups]);
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
    public function show($id)
    {
      
        $groups = Group::with(['groupStatus','groupStatus.user'])
        ->where('id', $id)->get()->toArray();
        
        $groupUser = GroupUser::select(DB::raw("count('id') as count"))
        ->where('group_id',$id)->where('group_status',3)->get()->toArray();

        $requestedUser = GroupUser::select(DB::raw("count('id') as group_status"))
        ->where('group_id',$id)->where('group_status',1)->get()->toArray();
        
        // echo "<pre>";
        // print_r($groups);
        // exit();
        return view('admin/group/show')->with(compact('groupUser','groups','requestedUser'));
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
