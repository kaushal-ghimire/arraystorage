<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        return response()->json(['subcategories' => $subcategories], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all(); 
       return view('user.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
    'name'=>'required|string',
    'category'=>'required|integer',
    ]);

    $subcategory =new Subcategory();
    $subcategory->name=$request->name;
    $subcategory->user_id=Auth::id();
    $subcategory->categories_id=$request->category;
    /*Subcategory::create([
                'name' => $request['name'],
                'category' => $request['category'],
                'category_id'=>$request->category,
                'user_id' =>$request->user,
            ]);*/
        
    if($subcategory->save()){
        Session::flash('success',"SubCategory Added Successfully");
        return redirect()->route('subcategory.index');

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
        $subcategory = Subcategory::findOrFail($id);
        return $subcategory;
    }

    public function search($id)
    {
            return Subcategory::where('id','like','%'.$id.'%')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $subcategories = SubCategory::find($id);
        
        return view('user.subcategory.edit',compact('subcategories','categories'));
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
        $this->validate($request,[
            'name' => 'required|string']);


        Subcategory::whereId($id)->update([
        'name' => $request['name'],
        'categories_id'=>$request->category,
       
         ]);
        return redirect()->route('subcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        $subcategories = Subcategory::find($id);
         
         if($subcategories->delete()){
           Session::flash('success', 'SubCategory Deleted Successfully'); 
         } 
         
            return redirect()->route('subcategory.index');
    }
}
