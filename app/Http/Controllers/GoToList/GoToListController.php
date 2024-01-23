<?php

namespace App\Http\Controllers\GoToList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoToList\GoToListService;

class GoToListController extends Controller
{
    private $goToListService;
    private $data = [];

    public function __construct(
        GotoListService $goToListService
    )
    {
        $this->goToListService = $goToListService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->goToListService->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOtherSpots()
    {
        return $this->goToListService->otherSpots();
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
        return $this->goToListService->add($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->goToListService->single($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function likeGoTo($id)
    {
        return $this->goToListService->like($id);
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
        $this->data = [
            'spot_id'=>$request->spot_id,
            'id'=>$id
        ];

        return $this->goToListService->edit($this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->goToListService->delete($id);
    }
}
