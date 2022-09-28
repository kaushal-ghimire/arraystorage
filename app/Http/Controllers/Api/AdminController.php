<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index()
    {
        $user=User::where('role',1)->get();
        return response()->json(['users' => $user], 200);
    }

    public function login(Request $request)
    {
         
       // dd("here");
        $email = $request->email;
        $password = $request->password;

        //var_dump("$email, $password"); die();

        if(Auth::attempt(['email'=>$email,'password'=>$password,'is_active'=>'1','user_type'=>'3'], true)){
            return response()->json(['success'=>true,'message'=>'Successfully logged in',
                'user_type'=>'3','user'=>Auth::user()
            ]);
        }
        else{
           return response()->json(['success'=>false,'message'=>'Invalid username or password']);
        
        }
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
                'password' =>Hash::make($req->password),
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
        dd($user->name);
    }

}
