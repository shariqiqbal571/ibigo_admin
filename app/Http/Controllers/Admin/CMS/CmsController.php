<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\CMS;
use App\Models\CmsDetail;
use App\Models\CmsDetailImage;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cms = CMS::all();
        return view('admin/cms/view',compact('cms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $cms = CmsDetail::with(['cmsDetailImage','cms'])->get();
        // echo "<pre>";
        // print_r($cms);
        // exit();
        return view('admin/cms/view-detail',compact('cms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $cms = new CmsDetail;
        $cms->cms_id = $id;
        $cms->title = $request->title;
        $cms->description = $request->description;
        $cms->save();

        $cms_id = $cms->id;

        if($request->hasFile('image'))
        {
            foreach($request->file('image') as $images)
            {
                $destination = 'public/images/cms';
                $image = Str::uuid().$images->getClientOriginalName();
                $path = $images->storeAs($destination,$image);

                $imagesCms = new CmsDetailImage;
                $imagesCms->cms_detail_id = $cms_id;
                $imagesCms->images = $image;
                $imagesCms->save();
            }
        }
        return redirect('/admin/cms-detail')->with('msg','Cms Detail add successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$slug)
    {
        $cms = CMS::where('unique_id',$id)->where('slug',$slug)->get()->toArray();
        // echo "<pre>";
        // print_r($cms);
        // exit();
        return view('admin/cms/show',compact('cms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$slug)
    {
        $cms = CMS::where('unique_id',$id)->where('slug',$slug)->get()->toArray();
        // echo "<pre>";
        // print_r($cms);
        // exit();
        return view('admin/cms/update',compact('cms'));
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
            'title'=>'required',
        ]);
        if($validator->passes()) 
        {
            $cms = Cms::find($id);
            $cms->title = $request->title;
            $cms->slug = Str::slug($request->title,'-');
            if($request->hasFile('image')){
                $destination = 'public/images/cms';
                $photo = $request->file('image');
                $photos = uniqid().$photo->getClientOriginalName();
                $path = $photo->storeAs($destination,$photos);
    
                $cms->image = $photos;
            }
            $cms->save();
            // else{
            //     $cms->image = $request->oldImage;
            // }
            $request->session()->flash('msg','Update '. $request->title .' Successfully.');
            return redirect('/admin/cms');
        }
        else{
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
        CmsDetail::destroy($id);
        CmsDetailImage::where('cms_detail_id',$id)->delete();
        return redirect('/admin/cms-detail');
    }

    public function editDetail($id,$slug)
    {
        $cms = CmsDetail::with(['cmsDetailImage','cms'])
        ->whereHas('cms',function($query) use ($id,$slug){
            $query->where('unique_id',$id)->where('slug',$slug);
        })
        ->get()->toArray();
        
        // echo "<pre>";
        // print_r($cms);
        // exit();
        return view('admin/cms/edit',compact('cms'));
    }

    public function delete($id) 
    {
        CmsDetailImage::where('id',$id)->delete();
        return redirect()->back();
    }

    public function updateDetail(Request $request,$id)
    {
        $cms = CmsDetail::find($id);
        $cms->title = $request->title;
        $cms->description = $request->description;
        $cms->save();

        $cms_id = $cms->id;

        if($request->hasFile('image'))
        {
            foreach($request->file('image') as $images)
            {
                $destination = 'public/images/cms';
                $image = Str::uuid().$images->getClientOriginalName();
                $path = $images->storeAs($destination,$image);

                $imagesCms = new CmsDetailImage;
                $imagesCms->cms_detail_id = $cms_id;
                $imagesCms->images = $image;
                $imagesCms->save();
            }
        }
        return redirect('/admin/cms-detail')->with('msg','Cms Detail update successfully!');
    }
}
