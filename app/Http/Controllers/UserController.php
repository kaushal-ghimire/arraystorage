<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use App\Models\Unit;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Bill;
use Illuminate\Http\Request;
use Session;
use Response;
use Auth;

class UserController extends BaseController
{

    public function __construct()
    {
        $this->middleware(['auth', 'isUser']);
    }

    public function create(Request $data)
    {
        return view('user.unit.create');
    }

    public function index()
    {
        $units = Unit::count();
        $categories = Category::count();
        $subcategories = Subcategory::count();
        $product = Product::count();
        $maincategories = Maincategory::count();
        $supplier = Supplier::count();
        $bill = Bill::count();
        return view('user.dashboard', compact('units', 'categories', 'subcategories', 'product', 'maincategories', 'supplier', 'bill'));
    }

    public function unitIndex()
    {
        return view('user.unit.index');
    }

    public function unitEdit($id)
    {
        $units = Unit::find($id);

        return view('user.unit.edit', compact('units'));
    }



    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|unique:units'
        ]);

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->user_id = Auth::id();

        if ($unit->save()) {
            Session::flash('success', "Unit Added Successfully");
            return redirect()->route('unit.index');
        }
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string'
        ]);

        Unit::whereId($id)->update([
            'name' => $request['name'],

        ]);
        return redirect()->route('unit.index');
    }


    public function getAllCategory()
    {

        $id = Auth::id();
        $category = Category::select('categories.id', 'categories.name', 'categories.image', 'categories.created_at')
            ->where('user_id', $id)
            ->get();
        // dd($unit);

        return Datatables::of($category)
            ->editColumn('created_at', function ($category) {
                return $this->getParsedDatetime($category->created_at);
            })
            ->addColumn('image', function ($row) {
                $url = asset('img/' . $row->image);
                return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($category) {
                $action = '<div class="btn-group " role="group" >';
                $action .= '<a href=" ' . route('category.edit', $category->id) . ' " class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';


                // } else {
                // $action .= '<a href=" '.route('category.delete',$category->id).' " class="btn btn-danger btn-round btn-mini waves-effect waves-light" ><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';
                // }
                '</div>';
                return ($action);
            })
            ->rawColumns(['created_at', 'image', 'action'])
            ->make(true);
    }
    // public function delete($id)
    // {
    //     $categories= Category::find($id);

    //     if($categories->delete()){
    //          Session::flash('success', 'Category Deleted Successfully');   
    //     return redirect()->route('category.index');
    //       }
    // }


    public function getAllUnits()
    {
        $id = Auth::id();
        $unit = Unit::where('user_id', "=", $id)
            ->select('units.id', 'units.name', 'units.created_at')
            ->get();
        // dd($unit);

        return Datatables::of($unit)
            ->editColumn('created_at', function ($unit) {
                return $this->getParsedDatetime($unit->created_at);
            })
            ->addColumn('action', function ($unit) {
                $action = '<div class="btn-group " role="group" >';
                // <a href=" '.route('unit.create', ['unit'=>$unit->id]).' " class="btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';

                $action .= '<a href=" ' . route('unit.edit', $unit->id) . ' " class="btn btn-success btn-round btn-mini waves-effect waves-light " ><i class="fa fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';

                // $action .= '<a href="" data-href="'.route('unit.deleteUnit',$unit->id).'" class="btnDelete btn btn-danger btn-round btn-mini waves-effect waves-light ml-1" data-unit_id="'.$unit->id.'" ><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';

                '</div>';
                return ($action);
            })
            ->rawColumns(['created_at', 'action'])
            ->make(true);
    }
    //  public function deleteUnit(Request $request)
    // {
    //     // dd($request);
    //     $data_check= Unit::find($request->id);

    //     $data_delete = $data_check->delete();
    //     $notices = array(
    //         'message' => $data_check->name.' deleted Successfully',
    //         'type' =>'success',
    //         'alerted' => 'Done!'

    //     );
    //     return Response::json($notices);


    // }

    public function getAllSubcategory()
    {

        // join('categories','categories.id','=','subcategories.categories_id')

        $id = Auth::id();
        $subcategory = Subcategory::join('categories', 'categories.id', '=', 'subcategories.categories_id')
            ->where('subcategories.user_id', $id)
            ->select('subcategories.id', 'subcategories.created_at', 'subcategories.name', 'categories.name as categoryname')
            ->get();
        // dd($unit);

        return Datatables::of($subcategory)
            ->editColumn('created_at', function ($subcategory) {
                return $this->getParsedDatetime($subcategory->created_at);
            })
            ->addColumn('action', function ($subcategory) {
                $action = '<div class="btn-group " role="group" >';
                // <a href=" '.route('subcategory.index',$subcategory->id).' " class="btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';
                $action .= '<a href=" ' . route('subcategory.edit', $subcategory->id) . ' " class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';



                // $action .= '<a href=" '.route('subcategory.remove',$subcategory->id).' " class="btn btn-danger btn-round btn-mini waves-effect waves-light" ><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';

                '</div>';
                return ($action);
            })
            ->rawColumns(['created_at', 'action'])
            ->make(true);
    }
    // public function remove($id)
    // {
    //     $subcategories= Subcategory::find($id);

    //     if($subcategories->delete()){
    //          Session::flash('success', 'SubCategory Deleted Successfully');   
    //     return redirect()->route('subcategory.index');
    //     }  
    // }

    public function getAllMainCategory()
    {

        $id = Auth::id();
        $maincategory = MainCategory::select('maincategories.id', 'maincategories.name', 'maincategories.image', 'maincategories.created_at')
            ->join('users', 'maincategories.user_id', '=', 'users.id')
            ->where('user_id', $id);
        // ->get();
        // dd($unit);

        return Datatables::of($maincategory)
            ->editColumn('created_at', function ($maincategory) {
                return $this->getParsedDatetime($maincategory->created_at);
            })
            ->addColumn('image', function ($row) {
                $url = asset('img/' . $row->image);
                return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($maincategory) {
                $action = '<div class="btn-group " role="group" >';
                // <a href=" '.route('maincategory.show',$maincategory->id).' " class="btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-eye"></i> <span class="btn-label hidden-sm">View</span></a>';
                // if($unit->isSuspend) {
                $action .= '<a href=" ' . route('maincategory.edit', $maincategory->id) . ' " class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm">Edit</span></a>';



                // $action .= '<a href="'.route('maincategory.deleting',$maincategory->id).' " class="btn btn-danger btn-round btn-mini waves-effect waves-light" ><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm">Delete</span></a>';
                // }
                '</div>';
                return ($action);
            })
            ->rawColumns(['created_at', 'image', 'action'])
            ->make(true);
    }
    // public function deleting($id)
    // {
    //     $maincategories = MainCategory::find($id);

    //     if($maincategories->delete()){
    //          Session::flash('success', ',Main Category Deleted Successfully');   
    //     return redirect()->route('maincategory.index');
    //     }

    // }

    public function mainIndex()
    {
        return view('user.product.mainindex');
    }



    public function allProducts()
    {
        $id = Auth::id();
        $product = Product::select('products.id', 'products.Product_Id', 'products.name', 'products.size', 'products.color', 'products.image', 'products.purchased_quantity', 'products.purchase_price', 'products.unit', 'products.vat', 'products.purchased_price', 'products.sell_quantity', 'products.margin', 'products.delivery_charge', 'products.discount', 'products.selling_price', 'products.description', 'products.created_at', 'users.name as username')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->groupBy('product_id')
            ->get();

        return Datatables::of($product)
            ->rawColumns(['created_at', 'image','action'])
            ->editColumn('created_at', function ($product) {
                return $this->getParsedDatetime($product->created_at);
            })
            ->addColumn('image', function ($row) {
                $url = asset('img/' . $row->image);
                return '<img src="' . $url . '" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($product) {
                $urlPath = route('product.print', $product->id);

                return '
                    <div class="btn-group c" role="group" >
                        <a href='. $urlPath .' target="_blank" title="Print Details" class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" >
                            <i class="fa fa-print" aria-hidden="true"></i> 
                            <span class="btn-label hidden-sm"></span>
                        </a>
                    </div>
                ';
            })
            ->make(true);
    }

    public function getAllProduct(Request $req)
    {


        $id = Auth::id();
        $product = Product::join('bills', 'bills.id', '=', 'products.bills_id')
            ->where('products.bills_id', $req->id)
            ->join('users', 'products.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->select('products.id', 'products.Product_Id', 'products.name', 'products.size', 'products.color', 'products.image', 'products.purchased_quantity', 'products.purchase_price', 'products.unit', 'products.vat', 'products.purchased_price', 'products.sell_quantity', 'products.margin', 'products.delivery_charge', 'products.discount', 'products.selling_price', 'products.description', 'products.created_at', 'users.name as username')
            ->get();

        return Datatables::of($product)
            ->rawColumns(['action', 'created_at'])
            ->editColumn('created_at', function ($product) {
                return $this->getParsedDatetime($product->created_at);
            })
            ->addColumn('image', function ($row) {
                $url = asset('img/' . $row->image);
                return '<img src="' . $url . '" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($product) {
                $action = '<div class="btn-group " role="group" >
                    <a href=" ' . route('product.edit', $product->id) . ' " title="Edit Product" class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true"></i> <span class="btn-label hidden-sm"></span></a>';
                // $action .= '<a href=" ' . route('product.print', $product->id) . ' " title="Print Details" class="btn btn-danger btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-print" aria-hidden="true"></i> <span class="btn-label hidden-sm"></span></a>';
                // '.route('product.edit',$product->id).'
                // $action .= '<a href=" '.route('product.deletion',$product->id).' " class="btn btn-danger btn-round btn-mini waves-effect waves-light" ><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-label hidden-sm"></span></a>';
                // '.route('product.removeProduct',$product->id).'
                '</div>';
                return ($action);
            })


            ->rawColumns(['created_at', 'image', 'action'])

            ->make(true);
    }

    public function printProduct($id)
    {
        $product = Product::find($id);
        return view('user.product.print', compact('product'));
    }

    // public function deletion($id)
    // {
    //     $products = Product::find($id);

    //     if($products->delete()){
    //          Session::flash('success', 'Product Deleted Successfully');   
    //     return redirect()->route('product.index');
    //     } 
    // }

    public function createImage()
    {
        return view('user.product.addMultipleImage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
        $this->validate($request, [
            'filenames' => 'required',
            'filenames.*' => 'image'
        ]);

        $files = [];
        if ($request->hasfile('filenames')) {
            foreach ($request->file('filenames') as $file) {
                $name = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('files'), $name);
                $files[] = $name;
            }
        }

        $file = new Product();
        $file->filenames = $files;
        $file->save();

        return back()->with('success', 'Your files has been successfully added');
    }

    public function getAllSupplier()
    {
        $supplier = Supplier::where('user_id', "=", $this->getUserId())
            ->select('suppliers.id', 'suppliers.name', 'suppliers.business_id', 'suppliers.phone', 'suppliers.address', 'suppliers.pan', 'suppliers.date', 'suppliers.created_at')
            ->get();

        return Datatables::of($supplier)
            ->editColumn('created_at', function ($supplier) {
                return $this->getParsedDateTime($supplier->created_at);
            })

            ->addColumn('total', function ($supplier) {
                // return $supplier->id;
                // dd($supplier->id);
                $bill = Bill::where('suppliers_id', '=', $supplier->id)
                    ->with('getProduct')
                    ->get()
                    ->sum('purchased_price');

                // $bill = Bill::with('getProduct', function (Builder $query) {
                //     $query->where('suppliers_id','=',$supplier->id);
                // })->get();

                return $bill;
                // dd($bill->getProduct);
                $amount = 0;
                foreach ($bill as $b) {
                    $amount += $b->purchased_price;
                }
                return $amount;
            })


            ->addColumn('action', function ($supplier) {
                $action = '<div class="btn-group " role="group" >
            <a href=" ' . route('navigate.bill', $supplier->id) . ' " data-sup_id="' . $supplier->id . '" id="supp" class="btnSupId btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-plus" style="font-size:12px;color:red" data-toggle="tooltip" data-placement="top" title="Add Bill"></i></a>';
                $action .= '<a href=" ' . route('supplier.edit', $supplier->id) . ' " class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $action .= '<a class="btn btn-info btn-round btn-mini waves-effect waves-light mr-1" title="Add Payment"><strong data-id="' . $supplier->id . '"class="btn-label hidden-sm" data-toggle="modal" data-target="#addPaymentModal" >Make Payment</strong> </a>';
                return ($action);
            })
            ->rawColumns(['created_at', 'action'])
            ->make(true);
    }

    //      public function deletesupplier(Request $request)
    // {
    //     $suppliers= Supplier::find($request->data_id);

    //     $data_delete = $suppliers->delete();
    //     $notices = array(
    //         'message' =>$suppliers->name.' deleted Successfully',
    //         'type' =>'success',
    //         'alerted' => 'Done!'

    //     );
    //     return response()->json($notices);

    // }
    public function getAllBill(Request $req)
    {
        $bill = Bill::join('suppliers', 'suppliers.id', '=', 'bills.suppliers_id')
            ->where('bills.suppliers_id', $req->id)
            ->select('bills.id', 'bills.created_at', 'bills.bill', 'bills.purchase', 'bills.suppliers_id')
            ->get();


        return Datatables::of($bill)
            ->editColumn('created_at', function ($bill) {
                return $this->getParsedDateTime($bill->created_at);
            })

            ->addColumn('total', function ($bill) {
                // dd($bill->id);
                return Product::where('bills_id', '=', $bill->id)
                    ->get()
                    ->sum('purchased_price');
            })

            ->addColumn('action', function ($bill) {

                $action = '<div class="btn-group " role="group" >
        <a href=" ' . route('navigate.product', $bill->id) . '  " class="btn btn-secondary btn-round btn-mini waves-effect waves-light mr-1"><i class="fa fa-plus " style="font-size:12px;color:red" data-toggle="tooltip" data-placement="top" title="Add Product" ></i></a>';

                $action .= '<a href=" " data-toggle="modal" data-target="#editModal" data-pdate="' . $bill->purchase . '" data-bill_id="' . $bill->id . '" data-bill="' . $bill->bill . '" data-suppliers_id="' . $bill->suppliers_id . '" class="btn btn-success btn-round btn-mini waves-effect waves-light mr-1" ><i class="fa fa-edit" aria-hidden="true" ></i> </a>';

                '</div>';
                return ($action);
            })
            ->rawColumns(['created_at', 'action'])
            ->make(true);
    }

    public function goToBillPage($id)
    {
        return view('user.bill.index', compact('id'));
    }

    public function goToProductPage($id)
    {
        return view('user.product.index', compact('id'));
    }

    // public function deleteBill(Request $request)
    // {
    //     $bills= Bill::find($request->data_id);

    //     $data_delete = $bills->delete();
    //     $notices = array(
    //         'message' =>$bills->bill.' deleted Successfully',
    //         'type' =>'success',
    //         'alerted' => 'Done!'

    //     );
    //     return response()->json($notices);

    // }  
}
