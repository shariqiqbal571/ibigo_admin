<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->paginate(10);
        return view('admin/page/view')->with(compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/page/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'page_title' => 'required',
            'page_status' => 'required',
        ]);
        if($validator->passes())
        {

            $page = new Page;
            $page->page_title = $request->page_title;
            $page->page_description = $request->page_description;
            $slug_title =  Str::slug($request->page_title);
            $page->page_slug =   $slug_title;
            $page->page_unique_id = Str::random(32);
            $page->page_status = $request->page_status;
            $page->save();
            return redirect('/admin/page')->with('msg','Create  Page Successfully.');
        }
        else
        {
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::where('page_unique_id',$id)->get()->toarray();
        // echo "<pre>";
        // print_r($page) ;
        // exit;
        return view('admin/page/update')->with(compact('page'));
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
        
        $validator = Validator::make($request->all(),[
            'page_title' => 'required',
            'page_status' => 'required',
        ]);
        if($validator->passes())
        {
            
            $page = Page::find($id);
            $page->page_title = $request->page_title;
            $page->page_slug =   Str::slug($request->page_title);
            $page->page_description = $request->page_description;
            $page->page_status = $request->page_status;
            $page->save();
            return redirect('/admin/page')->with('msg','Update  Page Successfully');
        }    
        else 
        {
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::find($id)->delete();
        return redirect('/admin/page')->with('msg','Page Delete Successfully.');
    }
}
