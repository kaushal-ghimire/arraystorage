<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\ShippingAddress;
use App\Models\OrderDetails;
use Auth;


use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class ManagerController extends BaseController
{
   public function index()
   {     
      $product = Product::count();
      $order_details = OrderDetails::all();

      return view('manager.dashboard',compact('product','order_details'));
   }
   public function orderIndex()
   {
      return view('manager.order.index');
   }

   public function productIndex(){
    return view('manager.productIndex');
    }

    

    public function Products(){
        $id= Auth::id();
        $product = Product::select('products.id','products.Product_Id','products.name','products.size','products.color','products.image','products.purchased_quantity','products.purchase_price','products.unit','products.vat','products.purchased_price','products.sell_quantity','products.margin','products.delivery_charge','products.discount','products.selling_price','products.description','products.created_at','users.name as username')
        ->join('users','products.user_id','=','users.id')
        ->where('users.id',$id)
        // ->groupBy('product_id')
        ->get();

        return Datatables::of($product)
            ->rawColumns(['created_at'])
            ->editColumn('created_at', function($product) {
        return $this->getParsedDatetime($product->created_at);  
            })
            ->addColumn('image', function ($row) {             
                $url= asset('img/'.$row->image);            
                return '<img src="'.$url.'" border="0" width="50" class="img-rounded" align="center" />';       
            })
            
            
            ->rawColumns(['created_at','image'])

            ->make(true);
    }

/* -------------------------- Order Details -------------------------- */

   public function getAllOrder(Request $request)

      {
         $columns = array(
                        0 => 'id', 
                        1 => 'bill_id', 
                        2 => 'total', 
                        3 => 'discount', 
                        4 => 'grand_total', 
                        5 => 'date', 
                        6 => 'received',
                        7 => 'delivery_location',
                        8 => 'mobile', 
                        9 => 'is_active', 
                        10 => 'is_confirmed', 
                        11 => 'created_by', 
                        12 => 'created_at', 
                        13 => 'action', 
                        
                    );

        $totalData = OrderDetails::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = OrderDetails::offset($start);
            
            
        }
        else 
        {
            $search = $request->input('search.value');

            $posts = OrderDetails::where('bill_id', 'LIKE', '%'.$search.'%')
                                   ->offset($start);

            
            
            $totalFiltered = OrderDetails::where('bill_id', 'LIKE', '%'.$search.'%');
            
            
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->orderBy($order,$dir)
                       ->with('getUser')
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $nestedData['id'] = $key+1;
                $nestedData['bill_id'] =$post->bill_id; 
                $nestedData['total'] = $post->total;
                $nestedData['discount'] = $post->discount;
                $nestedData['grand_total'] = $post->total-$post->discount;
                $nestedData['date'] = $this->getParsedDateTime($post->date);
                $nestedData['received'] = $post->received;
                $nestedData['delivery_location'] = $post->delivery_location;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['is_active'] = $post->is_active;
                $nestedData['is_confirmed'] = $post->is_confirmed;
                $nestedData['created_by'] = $post['getUser']->name;
                $nestedData['created_at'] = $this->getParsedDateTime($post->created_at);
                $nestedData['action'] =
                $action = '<div class="btn-group " role="group">
                            <a href='.route('manager.order.show',$post->bill_id).' class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm">View</span> </a>';
                 
                //  <a href='.route('order.confirm',$post->bill_id).'  class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm" >Confirm</span> </a>
                 
                // <a href='.route('order.cancel',$post->bill_id).' class="btn btn-danger btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm">Cancel</span> </a>'; 
                    '</div>';              
                $data[] = $nestedData;
            }
        }
               $total_val = array_column($data, 'purchased_price');
            $total_sum = array_sum($total_val);
        $json_data = array(
            "draw"            => intval($request->input('draw')),  // intval($request->input('draw'))
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
            "total_balance"   => $total_sum
        );
        echo json_encode($json_data);
}

/* --------------------------Showing Orders -------------------------- */

   public function show($id)
   { 
    $order_details = OrderDetails::where('bill_id',$id)->first();
          $orderid = $id;
      return view('manager.order.show',compact('order_details','orderid') );
   }

   public function showAllOrder(Request $request)
   {
    // dd($request->all());

      $columns = array(
                        0 => 'id',
                        1 => 'bill_id', 
                        2 => 'product_id', 
                        3 => 'quantity', 
                        4 => 'rate', 
                        5 => 'discount', 
                        6 => 'total', 
                        7 => 'date', 
                        8 => 'is_confirmed', 
                        9 => 'confirmed_date', 
                        10 => 'deliver_date', 
                        11 => 'confirmed_by', 
                        12 => 'created_at', 
                        
                    );

        $totalData = Order::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {    

            $posts = Order::offset($start);
            
            
        }
        else 
        {

            $search = $request->input('search.value'); 
            $posts = Order::where('id', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            
            
            $totalFiltered = Order::where('id', 'LIKE', '%'.$search.'%');
            
            
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->orderBy($order,$dir)
                       ->with('getProduct')
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            $posts = Order::where('bill_id','=',$request->orderid)
                            ->get();

            foreach ($posts as $key=>$post)

            {
                
                $nestedData['id'] = $key+1;
                $nestedData['bill_id'] = $post->bill_id;
                $nestedData['product_id'] = $post['getProduct']->name;
                $nestedData['quantity'] = $post->quantity;
                $nestedData['rate'] = $post->rate;
                $nestedData['discount'] = $post->discount;
                $nestedData['total'] =($post->rate-$post->discount)*$post->quantity;
                $nestedData['date'] = $this->getParsedDateTime($post->date);
                $aaa = 0;
                $order= OrderDetails::where('is_confirmed',$post->bill_id)->get();
                foreach($order as $od){
                $aaa+= $od->is_confirmed;
                }  
                // $nestedData['is_confirmed'] = $aaa;
              
                $nestedData['is_confirmed'] = $post->is_confirmed;
                $nestedData['confirmed_date'] = $this->getParsedDateTime($post->confirmed_date);
                $nestedData['deliver_date'] = $post->deliver_date;
                $nestedData['confirmed_by'] = $post['getUser']->name;
                $nestedData['created_at'] = $this->getParsedDateTime($post->created_at);
                
                $data[] = $nestedData;
            }
        }
            $total_val = array_column($data, 'purchased_price');
            $total_sum = array_sum($total_val);
        $json_data = array(
            "draw"            => intval($request->input('draw')),  // intval($request->input('draw'))
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data,
            "total_balance"   => $total_sum
        );
        echo json_encode($json_data); 
   }

   /* -------------------------- Confirming Order -------------------------- */


   public function confirmOrder($id)
   {
       // dd($id);
      $check = OrderDetails::where('bill_id',$id)->first();
      $check->is_confirmed = "1";
      $check->update();

      $check2 = Order::where('bill_id',$id)->get();
      foreach($check2 as $cc){
      $cc->is_confirmed = "1";
      $cc->update();
  }
       return redirect()->back()->with('success','Order Confirmed');

   }

   /* -------------------------- Cancelling Order -------------------------- */

   public function cancelOrder($id)
   {
       // dd($id);
      $check = OrderDetails::where('bill_id',$id)->first();
      $check->is_confirmed = "2";
      $check->update();

      $check2 = Order::where('bill_id',$id)->get();
      foreach($check2 as $cc){
      $cc->is_confirmed = "2";
      $cc->update();
  }
       return redirect()->back()->with('error','Order has been cancelled');

   }


/* --------------------------Show Pending Order -------------------------- */
   public function orderPending()
   {
    return view ('manager.order.pending');
   }

   public function getPending()
   {
    $order_details = OrderDetails::where('is_confirmed', '0')->get();
      return Datatables::of($order_details)
      ->editColumn('created_at', function($order_details) {
        return $this->getParsedDateTime($order_details->created_at);  
      })
      ->addColumn('action', function ($order_details) {
         $action = '<div class="btn-group" role="group">
         <a href=" '.route('manager.order.show',$order_details->bill_id).' 
                    " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1">
                    <i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span>
            </a>';
                   '</div>';
         return ($action);
      })

      ->rawColumns(['created_at','action'])
      ->make(true);
  }

/* --------------------------Show Approved Order -------------------------- */
   
   public function orderApproved()
   {
    return view ('manager.order.approved');
   }

   public function getApproved()
   {
    $order_details = OrderDetails::where('is_confirmed', '1')->get();
      return Datatables::of($order_details)
      ->editColumn('created_at', function($order_details) {
        return $this->getParsedDateTime($order_details->created_at);  
      })
      ->addColumn('action', function ($order_details) {
         $action = '<div class="btn-group" role="group">
         <a href=" '.route('manager.order.show',$order_details->bill_id).' 
                    " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1">
                    <i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span>
            </a>';
                   '</div>';
         return ($action);
      })

      ->rawColumns(['created_at','action'])
      ->make(true);
   }
/* --------------------------Show Cancelled Order -------------------------- */
   
   public function orderCancelled()
   {

    return view ('manager.order.cancelled');
   }

   public function getCancelled()
   {
    $order_details = OrderDetails::where('is_confirmed', '2')->get();
      return Datatables::of($order_details)
      ->editColumn('created_at', function($order_details) {
        return $this->getParsedDateTime($order_details->created_at);  
      })
      ->addColumn('action', function ($order_details) {
         $action = '<div class="btn-group" role="group">
         <a href=" '.route('manager.order.show',$order_details->bill_id).' 
                    " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1">
                    <i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span>
            </a>';
                   '</div>';
         return ($action);
      })

      ->rawColumns(['created_at','action'])
      ->make(true);
   }
    

}