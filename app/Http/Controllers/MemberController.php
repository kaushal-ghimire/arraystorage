<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Member;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Session;

class MemberController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function levelIndex()
    {
        return view ('member.level.index1');
    }

    public function create()
    {
        return view('member.level.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    public function storeLevel(Request $request)
    {
        $this->validate($request, [
            'level' => 'required|string',
            'commission' => 'required|integer',

        ]);

        $level          = new Level();
        $level->level    = $request->level;
        $level->commission = $request->commission;

        if ($level->save()) {
            Session::flash('success', "Level Added Successfully");
            return redirect()->route('membership.level');

        }
    }
    public function editLevel($id)
    {
        $level = Level::find($id);

        return view('member.level.edit', compact('level'));
    }

    public function levelUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'level' => 'required|string',
            'commission' => 'required|string']);

        Level::whereId($id)->update([
            'level' => $request['level'],
            'commission' => $request['commission'],

        ]);
        return redirect()->route('membership.level');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function show($id)
    { 
      $member = User::find($id)->name;
      $memberid = $id;
      return view('member.show',compact('member','memberid') );

    }


     /*---------------------MEMBERS---------------------*/

      public function getMembers(Request $request)
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
                        10 => 'action', 
                        
                    );

        $totalData = Member::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');


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
                       // ->orderBy($order,$dir)
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $key=>$post)
            {
                $nestedData['id'] = $key+1;
                $nestedData['user_id'] = $post['userOne']->name; 
                $nestedData['ref_user_id'] = $post['userRef']->name;;
                $nestedData['name'] = $post['userOne']->name;
                $nestedData['phone'] = $post['userOne']->role;
                $nestedData['email'] =$post['userOne']->email;
                $nestedData['address'] = $post['userOne']->address;
                $nestedData['deposit'] = $post->deposit;
                $nestedData['remaining'] = $post->remaining;
                $nestedData['created_at'] = $this->getParsedDatetime($post->created_at);
                $nestedData['action'] = '
                    <a href='.route('member.show',$post->user_id).' class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm">View</span> </a>';                
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
        
    //        $member = Member::all();
    //     return Datatables::of($member)
    //         ->editColumn('created_at', function($member) {
    //             return $this->getParsedDatetime($member->created_at);
    //         })
    //         ->addColumn('refferal', function($cat) {
    //              $memname= Member::where('id',$cat->refferal)->select('name')->first();

    //              return $memname==null? "self" : $memname->name;


    //             })
    //         ->addColumn('action', function ($member) {
    //           $memcount= Member::where('refferal',$member->id)->count();


    //             $action = '<div class="btn-group " role="group" >
    //                     <a href=" '.route('member.show',$member->id).' " class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';
    //                     $action .= '<a href=" " class="btn btn-danger btn-round btn-mini waves-effect waves-light"><i class="fas fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';

    //                     $action .= '<a href=" '.route('member.show',$member->id).'" class="btn btn-dark btn-round btn-mini waves-effect waves-light"><span class="btn-label hidden-sm"><strong class="text-xl-center text-light ">'.$memcount.'</strong></span></a>';
    //                 '</div>';
    //             return ($action);
    //         })
            
    //         ->rawColumns(['created_at','action'])
    //         ->make(true);
    // }
    public function showAllMembers(Request $request)
    // { 
    //     // dd($request->all());
    //   $member = Member::where('ref_user_id','=',$request->memberid)
    //   ->get();  
    //      // dd($order);
    //      return Datatables::of($member)
    //   ->editColumn('created_at', function($member) {
    //      return date('Y-M-d', strtotime($member->created_at));
    //   })
    //   ->rawColumns(['created_at'])

    //   ->make(true);
    // }

    {
         $columns = array(
                        0 => 'id', 
                        1 => 'user_id', 
                        2 => 'name', 
                        3 => 'phone', 
                        4 => 'email', 
                        5 => 'address',
                        6 => 'deposit', 
                        7 => 'remaining',  
                        8 => 'created_at', 
                        
                    );

        $totalData = Member::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');


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
                       // ->orderBy($order,$dir)
                       ->get();

     
        $data = array();
        if(!empty($posts))
        {
            $posts = Member::where('ref_user_id','=',$request->memberid)
                            ->get();
            foreach ($posts as $key=>$post)
            {
                $nestedData['id'] = $key+1;
                $nestedData['user_id'] = $post['userOne']->name; 
                $nestedData['name'] = $post['userOne']->name;
                $nestedData['phone'] = $post['userOne']->role;
                $nestedData['email'] =$post['userOne']->email;
                $nestedData['address'] = $post['userOne']->address;
                $nestedData['deposit'] = $post->deposit;
                $nestedData['remaining'] = $post->remaining;
                $nestedData['created_at'] = $this->getParsedDatetime($post->created_at);
                $nestedData['action'] = '
                     <a href='.route('member.show',$post->id).' class="btn btn-primary btn-round btn-mini waves-effect waves-light mr-1"><span class="btn-label hidden-sm">View</span> </a>';                
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function membershipAmount()
    {
        $membership = Membership::all();
        return view('member.membership',compact('membership'));
    }

    public function getAllMembership()
    {
        $membership = Membership::all();

        return Datatables::of($membership)
            ->editColumn('created_at', function($member) {
                return $this->getParsedDatetime($member->created_at);
            })
            
            ->addColumn('action', function ($membership) {
                $action = '<div class="btn-group " role="group">
                    <a href=" '.route('member.editMembership', $membership->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';
                return ($action);
            })
            ->rawColumns(['created_at','action'])
            ->make(true);
    }


    public function createMembership()
    {
        return view('member.set_membership');
    }


    public function membershipStore(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|string',
            
        ]);

        $membership          = new Membership();
        $membership->amount    = $request->amount;

        if ($membership->save()) {
            Session::flash('success', "Membership Amount Added Successfully");
            return redirect()->route('membership.amount');

        }

    }

    public function editMembership($id)
    {
        $membership = Membership::find($id);

        return view('member.edit_membership', compact('membership'));
    }

    public function membershipUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'amount' => 'required|string']);

        Membership::whereId($id)->update([
            'amount' => $request['amount'],

        ]);
        return redirect()->route('membership.amount');
    }

    public function getAllLevel()
    {
        $level = Level::all();
        return Datatables::of($level)
            ->editColumn('created_at', function($level) {
                return $this->getParsedDatetime($level->created_at);
            })
            
            ->addColumn('action', function ($level) {
                $action = '<div class="btn-group " role="group" >
                    <a href=" '.route('level.edit', $level->id).' " class="btn btn-success btn-round btn-mini waves-effect waves-light"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';
                        
                    '</div>';
                return ($action);
            })
            ->rawColumns(['created_at','action'])
            ->make(true);
    }
}
