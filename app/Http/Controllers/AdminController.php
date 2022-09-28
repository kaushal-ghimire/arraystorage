<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Manager;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Member;
use App\Models\Supplier;
use App\Models\PaymentRequest;
use Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index()
    {
        $user = User::where('role',1)->get();

        $manager = User::where('role',2)->get();

        $member = User::where('role',3)->get();

        $customer = User::where('role',4)->get();

        $product = Product::count();
        $order_details = OrderDetails::count();

        return view('admin.dashboard',compact('user','manager','member','customer','product','order_details'));
    }
/* -------------------------- USER DATA -------------------------- */

    public function userIndex(){
        return view('admin.user.index');
    }

    public function createUser(){
        return view('admin.user.create');
    }


    public function store(Request $req){
        $this->validate($req,[
            'name'=> 'required|string',
            'address'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=> 'required|string'
        ]);

        $user = User::create([
            'role'   =>  1,
            'name'  => ucwords($req->name),
            'email' => $req->email,
            'address'=>$req->address,
            'password' =>Hash::make($req->password)
        ]);

        if($user->save()){
            Session::flash('success','User added successfully');
            return redirect()->route('admin.user.index');
        }
    }

    public function getAllUsers()
    {
        $user = User::where('role',1)
        ->select('users.id','users.name','users.address','users.email','users.created_at')
        ->get();

        return Datatables::of($user)
            ->editColumn('created_at', function($user) {
        return $this->getParsedDatetime($user->created_at);  
            })
            
            ->addColumn('action', function ($user) {
                $action = '<div class="btn-group " role="group" >
                        <a href=" '.route('admin.user.edit', $user->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';
                        // $action .= '<a href="'.route('admin.user.delete', $user->id).'" class="btn btn-danger btn-round btn-mini waves-effect waves-light"><i class="fas fa-trash" aria-hidden-sm="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';
                    '</div>';
                return ($action);
            })
            ->rawColumns(['created_at','action'])

            ->make(true);
    }
    public function editUser($id){
        
        $users = User::where('id',$id)->first();
        return view('admin.user.edit',compact('users'));
      
    }
    public function userUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|string']);

        User::whereId($id)->update([
            'name'=>$request['name'],
            'address'=>$request['address'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'avatar'=>$request['avatar'],
            
        ]);
        return redirect()->route('admin.user.index');
    }

    public function deleteUser($id){
        $user=User::where('id',$id);
        
        if($user->delete()){
        Session::flash('success', 'User Deleted Successfully');   
        return back();
        }
    }

/* -------------------------- MANAGER DATA -------------------------- */

    public function managerIndex(){
        return view('admin.manager.index');
    }


    public function createManager(){
        return view('admin.manager.create');
    }

    public function managerStore(Request $req){
        $this->validate($req,[
            'name'=> 'required|string',
            'address'=>'required|string',
            'email'=>'required|email|unique:managers',
            'password'=> 'required|string'
        ]);

        $user = User::create([
            'role'   =>  2,
            'name'  => ucwords($req->name),
            'email' => $req->email,
            'address'=>$req->address,
            'password' =>Hash::make($req->password)
        ]);

        if($user->save()){
            Session::flash('success','Manager added successfully');
            return redirect()->route('admin.manager.index');
        }
    }
    public function getAllManager()
    {
        $manager = User::where('role',2)
        ->select('users.id','users.name','users.address','users.email','users.created_at')
        ->get();

        return Datatables::of($manager)
            ->editColumn('created_at', function($manager) {
                return $this->getParsedDatetime($manager->created_at);
            })
            
            ->addColumn('action', function ($manager) {
                $action = '<div class="btn-group " role="group" >
                <a href=" '.route('admin.manager.edit', $manager->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';
                        // $action .= '<a href="'.route('admin.manager.delete', $manager->id).'" class="btn btn-danger btn-round btn-mini waves-effect waves-light"><i class="fas fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';
                    '</div>';
                return ($action);
            })
            ->rawColumns(['created_at','action'])
            ->make(true);
    }

    public function getAllPayRequest()
    {
        // $id=Auth::id();
       
        $payment = PaymentRequest::
        // where('payment_requests',$id)
        join('users','users.id','=','payment_requests.user_id')
        ->with('getUser')
        ->get();
        // join('payment_requests','payment_requests.id', '=', 'users.name');
        // ->select('payment_requests.id','payment_requests.user_id','payment_requests.amount','payment_requests.status','payment_requests.confirmed_by','payment_requests.confirmed_date','payment_requests.created_at')
        // ->get();
        // dd($unit);

        return Datatables::of($payment)
            ->editColumn('created_at', function($payment) {
                return $this->getParsedDatetime($payment->created_at);
            })
            ->addColumn('confirmed_by', function($name) {
                return $name->getUser->name;
            })
            ->addColumn('user_id', function($name) {
                return $name->getUser->name;
            })
            ->addColumn('action', function ($payment) {
                $action = '<div class="btn-group " role="group" >
                <a href=" '.route('payment.confirm', $payment->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-label hidden-sm">Confirm</span></a>';
                $action .= '<a href="'.route('payment.reject', $payment->id).'" class="btn btn-danger btn-round btn-mini waves-effect waves-light"><i class="fas fa-trash" aria-hidden-sm="true"></i> <span class="btn-label hidden-sm">Reject</span></a>';
            '</div>';

                return ($action);
            })

            ->rawColumns(['created_at','action'])
            ->make(true);
    }

    public function confirmPayment($id)
    {
        dd($id);
        $check = PaymentRequest::find($id);
        $check->status = "1";
        $check->update();
  
        // $check2 = PaymentRequest::where('user_id',$id)->get();
        // foreach($check2 as $cc){
        // $cc->status = "1";
        // $cc->update();
        // }
        return redirect()->back()->with('success','Payment Confirmed');
    }

       /* -------------------------- Cancelling Order -------------------------- */

   public function rejectPayment($id)
   {

    $check = PaymentRequest::where('user_id',$id)->first();
    $check->status = "2";
    $check->update();

    // $check2 = PaymentRequest::where('user_id',$id)->get();
    // foreach($check2 as $cc){
    // $cc->status = "2";
    // $cc->update();
    // }
        return redirect()->back()->with('error','Payment has been rejected');
   }


   public function paymentPending()
   {
    return view ('admin.payment.pending');
   }

   public function getPending()
   {
    $payment = PaymentRequest::where('status', '0')
    ->join('users','users.id','=','payment_requests.user_id')
    ->with('getUser')
    ->get();
      return Datatables::of($payment)
      ->editColumn('created_at', function($payment) {
        return $this->getParsedDateTime($payment->created_at);  
      })
      ->addColumn('action', function ($payment) {
         $action = '<div class="btn-group" role="group">
         <a href=" '.route('admin.payment.show',$payment->user_id).' 
                    " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1">
                    <i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span>
            </a>';
                   '</div>';
         return ($action);
      })
      ->addColumn('user_id', function($name) {
        return $name->getUser->name;
    })

      ->rawColumns(['created_at','action'])
      ->make(true);
  }

  public function paymentApproved()
  {
   return view ('admin.payment.approved');
  }

  public function getApproved()
  {
    $payment = PaymentRequest::where('status', '1')
    ->join('users','users.id','=','payment_requests.user_id')
    ->with('getUser')
    ->get();
      return Datatables::of($payment)
      ->editColumn('created_at', function($payment) {
        return $this->getParsedDateTime($payment->created_at);  
      })
      ->addColumn('action', function ($payment) {
         $action = '<div class="btn-group" role="group">
         <a href=" '.route('admin.payment.show',$payment->user_id).' 
                    " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1">
                    <i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span>
            </a>';
                   '</div>';
         return ($action);
      })
      ->addColumn('user_id', function($name) {
        return $name->getUser->name;
    })

      ->rawColumns(['created_at','action'])
      ->make(true);
 
  }

  public function paymentCancelled()
   {
    return view ('admin.payment.cancelled');
   }

   public function getCancelled()
   {
    $payment = PaymentRequest::where('status', '2')
    ->join('users','users.id','=','payment_requests.user_id')
    ->with('getUser')
    ->get();
      return Datatables::of($payment)
      ->editColumn('created_at', function($payment) {
        return $this->getParsedDateTime($payment->created_at);  
      })
      ->addColumn('action', function ($payment) {
         $action = '<div class="btn-group" role="group">
         <a href=" '.route('admin.payment.show',$payment->user_id).' 
                    " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1">
                    <i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span>
            </a>';
                   '</div>';
         return ($action);
      })
      ->addColumn('user_id', function($name) {
        return $name->getUser->name;
    })

      ->rawColumns(['created_at','action'])
      ->make(true);
   }

   public function show($id)
   { 
     $payment = PaymentRequest::get();
      $paymentid = $id;
      return view('admin.payment.show',compact('payment','paymentid') );
   }
      
    public function editManager($id){
        
        $manager = User::where('id',$id)->first();
        return view('admin.user.edit',compact('manager'));
      
    }

    public function managerUpdate(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required|string']);

        User::whereId($id)->update([
            'name'=>$request['name'],
            'address'=>$request['address'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'avatar'=>$request['avatar'],
            
        ]);
        return redirect()->route('admin.manager.index');
    }

    public function deleteManager($id){
        $manager=Manager::where('id',$id);
        
        if($manager->delete()){
        Session::flash('success', 'Manager Deleted Successfully');   
        return back();
        }
    }

    public function paymentIndex(){
        return view('admin.payment.index');
    }



/* -------------------------- REPORTING - START -------------------------- */

        /*---------------------SALES REPORT---------------------*/

    public function getAllSale(Request $request)
    { 
        
        $columns = array(
                        0 => 'id', 
                        1 => 'Product_Id',
                        2 => 'user_id',
                        3 => 'quantity',
                        4 => 'rate',
                        5 => 'total',
                        6 => 'created_at'
                    );
        
        $totalData = Order::groupBy('product_id')->get()->count();
        // dd($totalData);
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Order::offset($start);
            
            if ($request->data['to_date']) {
                $date_to = $request->data['to_date'];
            }
            else{
                $date_to = date('Y-m-d');
            }

            if($request->data['from_date']) {
                $posts = $posts->whereBetween("created_at",
                                [
                                    $request->data['from_date'],
                                    $date_to
                                ]);
            }
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Order::where('product_id', 'LIKE', '%'.$search.'%')
                            ->orWhere('id', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            if ($request->data['to_date']) {
                $date_to = $request->data['to_date'];
            }
            else{
                $date_to = date('Y-m-d');
            }
            
            if($request->data['from_date']) {
                $posts = $posts->whereBetween("created_at",
                                [
                                    $request->data['from_date'],
                                    $date_to
                                ]);
            }
            
            $totalFiltered = Order::where('product_id', 'LIKE', '%'.$search.'%')
                                    ->orWhere('id', 'LIKE', '%'.$search.'%');
           
            if ($request->data['to_date']) {
                $date_to = $request->data['to_date'];
            }
            else{
                $date_to = date('Y-m-d');
            }
            
            if($request->data['from_date']) {
                $totalFiltered = $totalFiltered->whereBetween("created_at",
                                [
                                    $request->data['from_date'],
                                    $date_to
                                ]);
            }
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->orderBy($order,$dir)
                       // ->with('category')
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            $posts = Order::where('is_confirmed','=', 1)
                           ->groupBy('product_id')
                           ->get();

            // dd($posts);

            foreach ($posts as $post)
            {
                $nestedData['name'] = $post->product->name;
                $nestedData['Product_Id'] = $post['product']->product_id;
                $nestedData['category'] = $post['product']->category->name;
                $nestedData['user_id'] = $post['product']->userOne->name;
                $nestedData['quantity'] = Order::where('product_id',$post->product_id)
                                               ->where('is_confirmed','=',1)
                                               ->sum('quantity');
                $nestedData['rate'] = $post->rate;
                $amt=0;
                $order= Order::where('product_id',$post->product_id)->get();
                foreach($order as $od){
                    $amt+= ($od->quantity * $od->rate)-$od->discount;
                }
                $nestedData['total'] =  $amt;
                $nestedData['created_at'] = $this->getParsedDateTime($post->created_at);
                
                $data[] = $nestedData;
            }
        }
            $total_val = array_column($data, 'total');
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

    /*---------------------PURCHASE REPORT---------------------*/
    
    public function getAllPurchase(Request $request)
{ 
        $columns = array(
                        0 => 'name', 
                        1 => 'Product_Id',
                        2 => 'category',
                        3 => 'purchased_quantity',
                        4 => 'purchase_price',
                        5 => 'purchased_price',
                        7 => 'created_at'
                    );
        
        $totalData = Product::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Product::offset($start);
            
            if ($request->data['to_date']) {
                $date_to = $request->data['to_date'];
            }
            else{
                $date_to = date('Y-m-d');
            }

            if($request->data['from_date']) {
                $posts = $posts->whereBetween("created_at",
                                [
                                    $request->data['from_date'],
                                    $date_to
                                ]);
            }
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Product::where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('id', 'LIKE', '%'.$search.'%')
                            ->orWhere('categories_id', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            if ($request->data['to_date']) {
                $date_to = $request->data['to_date'];
            }
            else{
                $date_to = date('Y-m-d');
            }
            
            if($request->data['from_date']) {
                $posts = $posts->whereBetween("created_at",
                                [
                                    $request->data['from_date'],
                                    $date_to
                                ]);
            }
            
            $totalFiltered = Product::where('name', 'LIKE', '%'.$search.'%')
                                    ->orWhere('id', 'LIKE', '%'.$search.'%')
                                    ->orWhere('categories_id', 'LIKE', '%'.$search.'%');
            
            if ($request->data['to_date']) {
                $date_to = $request->data['to_date'];
            }
            else{
                $date_to = date('Y-m-d');
            }
            
            if($request->data['from_date']) {
                $totalFiltered = $totalFiltered->whereBetween("created_at",
                                [
                                    $request->data['from_date'],
                                    $date_to
                                ]);
            }
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->orderBy($order,$dir)
                       ->with('category')
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['name'] = $post->name;
                $nestedData['id'] = $post->product_id;
                $nestedData['category'] =$post['category']->name;
                $nestedData['purchased_quantity'] = $post->purchased_quantity;
                $nestedData['purchase_price'] = $post->purchase_price;
                $nestedData['purchased_price'] = $post->purchased_price;
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

    /*---------------------STOCK REPORT---------------------*/


    public function getAllStock(Request $request)
    { 
        if($request->ajax())
     {
      if($request->from_date != '' && $request->to_date != '')
      {
        $fromdate= strtotime($request->from_date);
        $todate= strtotime($request->to_date);
       $product = Product::whereBetween('created_at', [date('Y-m-d',$fromdate)." 00:00:00", date('Y-m-d',$todate)." 23:59:59"])->with('category')->get();

       
        
      }
      else
      {

                $product = Product::with('category')->get();

                return Datatables::of($product)
                ->editColumn('created_at', function($product) {
                    return $this->getParsedDateTime($product->created_at);

                })

                ->addColumn('category', function($cat) {
                    return $cat->category->name;

                })
                ->addColumn('quantity', function($product) {
                    return $cat = Order::where('product_id', $product->id)->where('is_confirmed','=',1)->sum('quantity');

                })
                ->addColumn('remaining', function($product){
                     $order = Order::where('product_id', $product->id)->where('is_confirmed','=', 1)
                                ->get()->sum('quantity');
                    
                    return $product->sell_quantity - $order;
                    

                })
                ->rawColumns(['created_at'])
                ->make(true);
            }
    }
}
    /*---------------------TOP SALES REPORT---------------------*/


    public function getAllTop()
    {
        $product = Order::whereMonth('created_at', date('m'))
                  ->orderBy('quantity', 'desc')
                  ->take(10)
                  ->get();
                  

                return Datatables::of($product)
                ->editColumn('created_at', function($product) {
                return $this->getParsedDateTime($product->created_at);
                })
                ->addColumn('name', function($prod) {
                    return $prod->product->name;

                })
                ->addColumn('category', function($cat) {
                    return $cat['product']->category->name;

                })
                ->rawColumns(['created_at'])
                ->make(true);
    }

    /*---------------------DAYBOOK REPORT---------------------*/

    public function getAllDay(Request $request)
    {
        $date_select=$request->date_select;
          if( !empty( $date_select ) ){
       
    

            $product = Product::whereDate('created_at', $date_select)
                               ->get();
            $order = Order::whereDate('created_at', $date_select)
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
           

                return response()->json([
                  'tp'=> $total_pur,
                  'ts'=> $total_sale,
                  'tm'=> $total_mar,
              ]);
            }
    }


     /*---------------------MEMBERSHIP REPORT---------------------*/

      public function getAllMember(Request $request)
{
         $columns = array(
                        0 => 'id', 
                        1 => 'user_id', 
                        2 => 'ref_user_id', 
                        3 => 'name', 
                        4 => 'phone', 
                        5 => 'email', 
                        6 => 'address',
                        7 => 'deposit', 
                        8 => 'remaining',  
                        9 => 'created_at', 
                        // 10 => 'action', 
                        
                    );

        $totalData = Member::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');


        if(empty($request->input('search.value')))
        {       
            $posts = Member::offset($start);
            
            
        }
        else 
        {
            $search = $request->input('search.value'); 
            $posts = Member::where('user_id', 'LIKE', '%'.$search.'%')
                            ->offset($start);

            
            
            $totalFiltered = Member::where('user_id', 'LIKE', '%'.$search.'%');
            
            
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->with('userOne')
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $nestedData['id'] = $key+1;
                $nestedData['ref_user_id'] = $post['userRef']->name;
                $nestedData['user_id'] = $post['userOne']->name; 
                $nestedData['name'] = $post['userOne']->name;
                $nestedData['phone'] = $post['userOne']->role;
                $nestedData['email'] =$post['userOne']->email;
                $nestedData['address'] = $post['userOne']->address;
                $nestedData['deposit'] = $post->deposit;
                $nestedData['remaining'] = $post->remaining;
                $nestedData['created_at'] = $this->getParsedDateTime($post->created_at);
                // $nestedData['action'] = '
                //     <a href='.route('member.show',$post->id).' class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm">View</span> </a>';                
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

    // { 

    //     if($request->ajax())
    //  {
    //   if($request->from_date != '' && $request->to_date != '')
    //   {
    //     $fromdate= strtotime($request->from_date);
    //     $todate= strtotime($request->to_date);
    //    $member = Member::whereBetween('created_at', [date('Y-m-d',$fromdate)." 00:00:00", date('Y-m-d',$todate)." 23:59:59"])->get();
        
    //   }
    //   else
    //   {
        
    //        $member = Member::all();

    //     return Datatables::of($member)
    //         ->editColumn('created_at', function($member) {
    //             return date('Y-M-d', strtotime($member->created_at));
    //         })
    //         ->addColumn('refferal', function($cat) {
    //              $memname= Member::where('id',$cat->refferal)->select('name')->first();

    //              return $memname==null? "Self" : $memname->name;


    //             })

    //         ->addColumn('action', function ($member) {
    //           $memcount= Member::where('refferal',$member->id)->count();


    //             $action = '<div class="btn-group " role="group" >
    //                     <a href=" '.route('member.show',$member->id).' " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';
    //                     $action .= '<a href=" " class="btn btn-danger btn-round btn-mini waves-effect waves-light"><i class="fas fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';

    //                     $action .= '<a href=" " class="btn btn-dark btn-round btn-mini waves-effect waves-light"><span class="btn-label hidden-sm"><strong class="text-xl-center text-success ">'.$memcount.'</strong></span></a>';
    //                 '</div>';
    //             return ($action);
    //         })
            
    //         ->addColumn('commission', function($member) {
    //                 $com=$member->amount*0.12;
                    
    //                 return $com;
    //                 })
            
            
    //         ->make(true);
    //     }
    // }

 
     /*---------------------ORDER REPORT---------------------*/



       public function getConfirmOrder(Request $request)
    { 
        
      $order_details = OrderDetails::all();
      return Datatables::of($order_details)

      ->editColumn('created_at', function($order_details) {
        return $this->getParsedDateTime($order_details->created_at);
      })
      ->addColumn('created_by', function($order_details) {
        return $order_details['getUser']->name;
    })
      ->rawColumns(['created_at'])
      ->make(true);
  
    }

    public function getSuppliers(Request $request)
{ 
        $columns = array(
                        0 => 'id', 
                        1 => 'name',
                        2 => 'total',
                        3 => 'paid',
                        4 => 'due',
                        5 => 'created_at'
                    );
        
        $totalData = Supplier::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {       
            $posts = Supplier::offset($start);
             
        {
            $search = $request->input('search.value'); 
            $posts = Supplier::where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('id', 'LIKE', '%'.$search.'%')
                            ->offset($start);
            
            $totalFiltered = Supplier::where('name', 'LIKE', '%'.$search.'%')
                                    ->orWhere('id', 'LIKE', '%'.$search.'%');
            
            $totalFiltered = $totalFiltered->count();
        }

        $posts = $posts->limit($limit)
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $nestedData['id'] = $key+1;
                $nestedData['name'] =$post->name;
                $nestedData['total'] = '10';
                $nestedData['paid'] = '5';
                $nestedData['due'] = '5';
                $nestedData['created_at'] = $this->getParsedDateTime($post->created_at);
                $nestedData['action'] =
                $action = '<div class="btn-group " role="group">
                            <a class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm" data-toggle="modal" data-target="#addCatModal">Make Payment</span> </a>';
                
                $data[] = $nestedData;
            }
        }
            $total_val = array_column($data, 'total');
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

      

}
}
