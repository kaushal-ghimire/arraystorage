<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maincategories = MainCategory::all();
        return view('user.gendercategory.index',compact('maincategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.gendercategory.create');
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
            'name' => 'required|unique:maincategories,name|string',
            'image' => 'mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG','max:200',
        ]);
        // dd($request->image);
        // dd($request->id);
        // dd($request->all());
        $maincategory  = new MainCategory();
        $maincategory->id = $request->id;
        $maincategory->name = $request->name;
        $maincategory->image = $this->store_image($request);
        $maincategory->user_id = Auth::id();

        if ($maincategory->save()) {
            Session::flash('success', "Main Category Added Successfully");
            return redirect()->route('maincategory.index');

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
        return view('user.gendercategory.index', [
            'maincategory' => MainCategory::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $maincategories = MainCategory::find($id);

        return view('user.gendercategory.edit', compact('maincategories'));
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
            'name' => 'required|string',
            'image' => 'mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG','max:200']);

        MainCategory::whereId($id)->update([
            'name' => $request['name'],
            'image' => $request['image']

        ]);
        return redirect()->route('maincategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        dd($id);
        $maincategories = MainCategory::find($id);

        if ($maincategories->deleting()) {
            Session::flash('success', 'Main Category Deleted Successfully');
        }
        return redirect()->route('maincategory.index');
    }
}