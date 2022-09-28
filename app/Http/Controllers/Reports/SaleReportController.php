<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order_details;
use App\Models\Order;
use App\Models\Supplier;


class SaleReportController extends Controller
{

    public function sale( Request $request )
    {
        
        return view('admin.reports.sales');
    }
    public function purchase( Request $request )
    {

        return view('admin.reports.purchase');
    }
    public function stock( Request $request )
    {
                
        return view('admin.reports.stock');
    }
    public function daybook( Request $request)
    {

        $product = Product::whereDay('created_at', date('d'))
                          ->get();
        $order = Order::whereDay('created_at', date('d'))
                       ->where('is_confirmed','=',1)
                       ->get();
        
                  $total_pur=0;
                  $total_sale=0;
                  $total_mar=0;

                foreach($product as $p){
                  $total_pur+=$p->purchased_price;
                  $total_mar+=$p->margin * 0.01 * $p->purchased_price;

                }
                foreach($order as $od){
                 $total_sale+=$od->quantity * $od->rate;
                }


                // dd($total_pur);
        return view('admin.reports.daybook',compact('product','order','total_pur','total_sale','total_mar'));    

                return response()->json([
                  'tp'=> $total_pur,
                  'ts'=> $total_sale,
                  'tm'=> $total_mar,
              ]);

    }
    public function top( )
    {

        return view('admin.reports.top10');
    }
    public function member( Request $request )
    {

        return view('admin.reports.member');
    }
    public function order( Request $request )
    {
        return view('admin.reports.order');
    }
    public function supplier( Request $request )
    {
        $supplier = Supplier::get();
        return view('admin.reports.supplier',compact('supplier'));
    }
    
}
