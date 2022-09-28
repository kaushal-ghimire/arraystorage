<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return response()->json(['maincategories' => $maincategories], 200);
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
            'name' => 'required|string',
        ]);

        $maincategory          = new MainCategory();
        $maincategory->name    = $request->name;
        $maincategory->user_id = Auth::id();

        if ($maincategory->save()) {
            Session::flash('success', "Main Category Added Successfully");
            return redirect()->route('maincategory.index');

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
        $maincategory = MainCategory::findOrFail($id);
        return $maincategory;
    }


    public function search($id)
    {
            return MainCategory::where('id','like','%'.$id.'%')->get();
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
            'name' => 'required|string']);

        MainCategory::whereId($id)->update([
            'name' => $request['name'],

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
