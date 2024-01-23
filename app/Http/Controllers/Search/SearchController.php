<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Search\SearchService;

class SearchController extends Controller
{
    private $searchService;
    private $data= [];
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->searchService->notifications();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->data = [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ];

        return $this->searchService->spotSuggestion($this->data);
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
            'search_text'=>$request->search_text,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'searchAddress'=>$request->searchAddress
        ];
        return $this->searchService->get($this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function allExpertise()
    {
        return $this->searchService->getAllExpertise();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->data = [
            'search_city' =>  isset($request->search_city)?$request->search_city:null,
            'search_weekend' =>  isset($request->search_weekend)?$request->search_weekend:null,
            'search_week' =>  isset($request->search_week)?$request->search_week:null,
            'search_month' =>  isset($request->search_month)?$request->search_month:null,
            'from' => isset($request->from)?$request->from:null,
            'to'=> isset($request->to)?$request->to:null,
        ];
        if($request->search_who){
            $who = [];
            foreach ($request->search_who as $key => $value) {
                $who[] = $value;               
            }
            $this->data['search_who'] = $who;
        }
        if($request->search_what){
            $what = [];
            foreach ($request->search_what as $key => $value) {
                $what[] = $value;               
            }
            $this->data['search_what'] = $what;
        }
        if($request->search_category){
            $category = [];
            foreach ($request->search_category as $key => $value) {
                $category[] = $value;               
            }
            $this->data['search_category'] = $category;
        }
        if($request->search_special){
            $special = [];
            foreach ($request->search_special as $key => $value) {
                $special[] = $value;               
            }
            $this->data['search_special'] = $special;
        }
        return $this->searchService->searchWithFilters($this->data);
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
        return $this->searchService->changeStatus($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->searchService->deleteNoti($id);
    }

    public function show()
    {
        return $this->searchService->count();
    }

    public function updateCount()
    {
        return $this->searchService->update();
    }
}
