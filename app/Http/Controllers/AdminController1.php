<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Product;
use Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index()
    {
        $user=User::where('role',1)->get();
        return view('admin.dashboard',compact('user'));
    }

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

        // $user = new User();
        // $user->name=$req->name;
        // $user->address=$req->address;
        // $user->email=$req->email;
        // $user->password=$req->password;
            // $user->role=1;

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
                return date('Y-M-d', strtotime($user->created_at));
            })
            
            ->addColumn('action', function ($user) {
                $action = '<div class="btn-group " role="group" >
                    <a href=" '.route('admin.user.edit', [$user->id]).' " class="btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';
                        $action .= '<a href=" '.route('admin.user.edit', $user->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';
                        $action .= '<a href="'.route('admin.user.delete', $user->id).'" class="btn btn-danger btn-round btn-mini waves-effect waves-light"><i class="fas fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';
                    '</div>';
                return ($action);
            })
            
            ->make(true);
    }

    public function editUser($id){
            // $user=DB::Table('users')->where('id','=',$id)->first();
            $user=User::where('id',$id)->first();
            dd($user->email);
      
    }

    public function deleteUser($id){
        $user=User::where('id',$id);
        
        if($user->delete()){
             Session::flash('success', 'User Deleted Successfully');   
        return back();
        }
    }
    public function getAllSale(Request $request)
    { 
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '' && $request->has('prod'))
            {
                $fromdate= strtotime($request->from_date);
                $todate= strtotime($request->to_date);
                $product = Product::where('name','like','%'.$request->prod.'%')
                                    ->whereBetween('created_at', [date('Y-m-d',$fromdate)." 00:00:00", date('Y-m-d',$todate)." 23:59:59"])
                                    ->with('category')
                                    ->get();
            }

            else if($request->has('prod')){
                $product = Product::with('category')
                                    ->where('name','like','%'.$request->prod.'%')
                                    ->get();
            }
            else
            {
                $product = Product::with('category')->get();
            }

            $tables = Datatables::of($product)
                            ->editColumn('created_at', function($product) {
                                return date('Y-M-d', strtotime($product->created_at));
                            })
                            ->addColumn('category', function($cat) {
                                return $cat->category->name;

                            })
                            ->make(true);


            return $tables;
        }
    }
    
    public function getAllPurchase(Request $request)
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

                    }


                return Datatables::of($product)
                ->editColumn('created_at', function($product) {
                    return date('Y-M-d', strtotime($product->created_at));

                })
                ->addColumn('category', function($cat) {
                    return $cat->category->name;

                })
                ->make(true);
            }
    }

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
                    }


                return Datatables::of($product)
                ->editColumn('created_at', function($product) {
                    return date('Y-M-d', strtotime($product->created_at));

                })
                ->addColumn('category', function($cat) {
                    return $cat->category->name;

                })
                ->make(true);
            }
    }

    public function getAllTop()
    {
        $product = Product::whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->get();
/*                $product = Product::whereDate('created_at', date('Y-m-d'))->get();
*/

                return Datatables::of($product)
                ->editColumn('created_at', function($product) {
                    return date('Y-M-d', strtotime($product->created_at));

                })
                ->addColumn('category', function($cat) {
                    return $cat->category->name;

                })
                ->make(true);
    }

    public function getAllDay()
    {
             $product = Product::whereDate('created_at', date('Y-m-d'))->get();

                // $product = Product::with('category')->get();


                return Datatables::of($product)
                ->editColumn('created_at', function($product) {
                    return date('Y-M-d', strtotime($product->created_at));

                })
                ->addColumn('category', function($cat) {
                    return $cat->category->name;

                })
                ->make(true);
    }
    


}
