<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Bill;
use Auth;
use Session;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.bill.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all(); 
        return view('user.bill.create', compact('suppliers'));
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
            'bill'=>'required|string',
        ]);

        $bill =new Bill();
        $bill->bill=$request->bill;
        $bill->purchase=$request->purchase;
        $bill->user_id=Auth::id();
        $bill->suppliers_id=$request->supid;

        if($bill->save()){
         Session::flash('success',"Bill Added Successfully");
        return redirect()->back();

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
        $suppliers = Supplier::all();
        $bill = Bill::find($id);
        
        return view('user.bill.edit',compact('bill','suppliers'));
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
        /*$this->validate($request,[
            'bill' => 'required|string']);



        Bill::whereId($request->billid)->update([
            'bill' => $request['bill'],
            'purchase' => $request['pdate']
        ]);
        return redirect()->route('bill.index');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function updateBill(Request $request)
    { 
        // $id= $request->suppliers_id;
        $this->validate($request,[

            'bill' => 'required|string']);

        $bills = Bill::whereId($request->billid);
        $id= $bills->first()->suppliers_id;
        $bills->update([
            'bill' => $request['bill'],
            'purchase' => $request['purchase']
        ]);
        return view('user.bill.index',compact('id'));
    }

    public function destroy($id)
    {
        //
    }
}