<?php

namespace App\Http\Controllers\BusinessUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BusinessUser\BusinessUserService;
use App\Services\User\UserService;

class BusinessUserController extends Controller
{
    private $data = [];
    private $businessUserService;
    private $userService;
    public function __construct(
        BusinessUserService $businessUserService,
        UserService $userService
    )
    {
        $this->businessUserService = $businessUserService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayment(Request $request)
    {
        $this->data = [
            'id' => $request->id
        ];
        return $this->businessUserService->payment($this->data);
    }

    public function mailTestFor(Request $request)
    {
        return $this->businessUserService->mailTest($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(Request $request)
    {
        $user = $request->only([
            'email',
            'password'
        ]); 

        $data = $this->userService->loginResponse($user);

        return $data;
    }

    public function add($request)
    {
        $this->data = $request->all();
        if($request->hasFile('profile')){
            $destination = 'public/images/user/profile';
            $profile = $request->file('profile');
            $user_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$user_profile);

            $this->data['profile'] = $user_profile;
        }

        if($request->hasFile('cover')){
            $destination = 'public/images/user/cover';
            $cover = $request->file('cover');
            $user_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$user_cover);

            $this->data['cover'] = $user_cover;
        }

        if($request->user_interests)
        {
            $interests = [];
            foreach($request->user_interests as $interest)
            {
                $interests[] = $interest;

            }
            $this->data['user_interests'] = implode(',',$interests);
        }

        return $this->data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->add($request);

        $spotUser = $this->businessUserService->create($data);
        
        return $spotUser;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return $this->businessUserService->profile();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfileCover(Request $request)
    {
        if($request->hasFile('profile')){
            $destination = 'public/images/user/profile';
            $profile = $request->file('profile');
            $user_profile = uniqid().$profile->getClientOriginalName();
            $path = $profile->storeAs($destination,$user_profile);

            $this->data['profile'] = $user_profile;
        }

        if($request->hasFile('cover')){
            $destination = 'public/images/user/cover';
            $cover = $request->file('cover');
            $user_cover = uniqid().$cover->getClientOriginalName();
            $path = $cover->storeAs($destination,$user_cover);

            $this->data['cover'] = $user_cover;
        }

        return $this->businessUserService->updatePictures($this->data);
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
        $data = $this->add($request);

        $spotUser = $this->businessUserService->edit($data);
        
        return $spotUser;
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
