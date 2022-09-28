<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $suppliers = Supplier::all();
        return view('user.supplier.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        ]);

        $supplier          = new Supplier();
        $supplier->user_id = Auth::id();
        $supplier->name    = $request->name;
        $supplier->business_id    = $request->business;
        $supplier->phone    = $request->phone;
        $supplier->address    = $request->address;
        $supplier->pan    = $request->pan;
        $supplier->date    = $request->date;

        if ($supplier->save()) {
            Session::flash('success', "Supplier Added Successfully");
        return redirect()->route('supplier.index');
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
        $suppliers = Supplier::find($id);

        return view('user.supplier.edit', compact('suppliers'));
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
            'name'=>'required|string']);

        $supplier = Supplier::find($id);
        $supplier->name    = $request->name;
        $supplier->business_id    = $request->business;
        $supplier->phone    = $request->phone;
        $supplier->address    = $request->address;
        $supplier->pan    = $request->pan;
        $supplier->date    = $request->date;
          if($supplier->update()){  
        return redirect()->route('supplier.index');
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
        //
    }
}