<?php

namespace App\Http\Controllers\Admin\Filter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Filter;
use Illuminate\Support\Str;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = Filter::orderBy('id', 'desc')->paginate(10);

        return view('admin/filters/view',compact('filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/filters/add');
        
    }

    /**
     * Store a newly created resource in storage.
     *filter
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'type' =>'required',
            'status' =>'required',
            'category' =>'required',
        ]);
        if($validator->passes())
        {
            $filter = new Filter;
            $filter->name = $request->name;
            $filter->slug = Str::slug($request->name,'-');
            $filter->unique_id = Str::uuid();;
            $filter->type = $request->type;
            $filter->status = $request->status;
            $filter->category = $request->category;
            $filter->save();
            return redirect('admin/filters')->with('msg','Filter add successfully!');
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
    public function show($id,$slug)
    {
        $filter = Filter::where('unique_id',$id)->where('slug',$slug)->get();
        
        return view('admin/filters/view',compact('filter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$slug)
    {
        $filter = Filter::where('unique_id',$id)->where('slug',$slug)->get()->toArray();
        // echo "<pre>";
        // print_r($filter);
        // exit();
        return view('admin/filters/update',compact('filter'));
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
            'name' =>'required',
            'type' =>'required',
            'status' =>'required',
            'category' =>'required',
        ]);
        
        if($validator->passes())
        {
            $filter = Filter::find($id);
            $filter->name = $request->name;
            $filter->slug = Str::slug($request->name,'-');
            $filter->type = $request->type;
            $filter->status = $request->status;
            $filter->category = $request->category;
            $filter->save();

            return redirect('admin/filters')->with('msg','Filter update successfully!');
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
        $filter = Filter::find($id);
        $filter->delete();
        return redirect('admin/filters')->with('msg','Filter deleted successfully!');
    }
}
