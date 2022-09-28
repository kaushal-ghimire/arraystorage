<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlideImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Redirect;


class SlideImageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.slide.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG','max:200',
        ]);
        // dd($request->image);
        // dd($request->id);
        // dd($request->all());
        $slide  = new SlideImage();
        $slide->id = $request->id;
        $slide->title = $request->title;
        $slide->image = $this->store_image($request);

        if ($slide->save()) {
            Session::flash('success', "Slide Image Added Successfully");
            return redirect()->route('slide.index');

        }

    }
    public function store_image(Request $request){
    
        if($request->hasFile('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/img'), $filename);
            return $filename;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slide = SlideImage::find($id);

        return view('admin.slide.edit', compact('slide'));
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
        $this->validate($request, [
            'title' => 'required|string',
        ]);

        $data_check = SlideImage::find($id);

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG'
            ]);

            if (file_exists('img/'.$data_check->image)) {
                unlink('img/'.$data_check->image);
            }
        }

        SlideImage::whereId($id)->update([
            'title' => $request['title'],
            'image' => $request->hasFile('image') ? $this->store_image($request) : $data_check->image,

        ]);

        return Redirect::route('slide.index');
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

    public function getAllSlide()
    {

        $slide = SlideImage::all();

        return Datatables::of($slide)
            ->editColumn('created_at', function($slide) {
        return $this->getParsedDatetime($slide->created_at);  
            })
            ->addColumn('image', function ($row) {             
                $url= asset('img/'.$row->image);            
                return '<img src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';       
            })
            ->addColumn('action', function ($slide) {
                $action = '<div class="btn-group " role="group" >';
                    // <a href=" '.route('slide.show',$slide->id).' " class="btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';
                    // if($unit->isSuspend) {
                        $action .= '<a href=" '.route('slide.edit',$slide->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';


                    
                        // $action .= '<a href="'.route('slide.deleting',$slide->id).' " class="btn btn-danger btn-round btn-mini waves-effect waves-light" ><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';
                    // }
                    '</div>';
                return ($action);
            })
            ->rawColumns(['created_at','image','action'])
            ->make(true);
    }
}
