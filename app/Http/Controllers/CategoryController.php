<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::all();
        return view('user.category.index', compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.category.create');
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
            'name' => 'required|unique:categories,name|string',
            'image' => 'mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG','max:200',

        ]);

        $category          = new Category();
        $category->name    = $request->name;
        $category->image = $this->store_image($request);
        $category->user_id = Auth::id();

        if ($category->save()) {
            Session::flash('success', "Category Added Successfully");
            return redirect()->route('category.index');

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
        return view('user.subcategory.index', [
            'category' => Category::findOrFail($id),
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
        $categories = Category::find($id);

        return view('user.category.edit', compact('categories'));
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


        Category::whereId($id)->update([
            'name' => $request['name'],
            'image' => $request['image'],

        ]);
        return redirect()->route('category.index');
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
        $categories = Category::find($id);

        if ($categories->delete()) {
            Session::flash('success', 'Category Deleted Successfully');
        }
        return redirect()->route('category.index');
    }
}
