<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Subcategory;
use App\Models\Unit;
use Faker\Provider\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all(); 
        $units = Unit::all();
        $maincategories = MainCategory::all();
        return view('user.product.create1', compact('categories','subcategories','maincategories','units'));
    }

    public function createProduct($id)
    {
        // dd($id);
        $bill_id=$id;
        $categories = Category::all();
        $subcategories = Subcategory::all(); 
        $units = Unit::all();
        $maincategories = MainCategory::all();
        return view('user.product.create1', compact('bill_id','categories','subcategories','maincategories','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->tot_price);
        // dd($request->margin1);
        // dd($request->has('checkbox'));
        // $randomNumber = random_int(100000, 999999);
        // dd($randomNumber);

        $rules = [
            'name' => 'required|string',
            'size' => 'string',
            'color' => 'string',
            'image.*' => 'image','mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG','max:200',

        ];
    
        $customMessages = [
            'max' => 'The max size should be less than 200kb.'
        ];

        $this->validate($request, $rules,$customMessages);

        $product = new Product();
        $product->id = $request->id;
        $product->categories_id = $request->category;
        $product->subcategories_id = $request->subcategory;
        $product->maincategories_id = $request->maincategory;
        $product->bills_id = $request->billid;
        // $product->product_id = $this->IdGenerator(new Product,'Product_Id',5,'PRD');
        $product->product_id = $this->uniqueIdGenerator($request);
        $product->name = $request->name;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->image = $this->save_image($request);
        $product->purchased_quantity = $request->quantity;
        $product->unit = $request->unit;
        $product->purchase_price = $request->p_price;
        $product->vat = $request->vat1;
        $product->purchased_price = $request->tot_price;
        $product->sell_quantity = $request->sell_quan;
        $product->margin = $request-> margin1;
        $product->delivery_charge = $request->delivery;
        $product->discount = $request->discount;
        $product->selling_price = $request->selling_price;
        $product->description = $request->description;
        $product->units_id = $request->unit;
        $product->user_id = Auth::id();
        $id= $request->billid;
        if ($product->save()) {
            Session::flash('success', "Product Added Successfully");
            return view('user.product.index',compact('id'));
        }
}


// public function check_margin(Request $request){
    
//     if($request->has('checkbox')){
        
//     }
// }

public function uniqueIdGenerator(Request $request){
    $product = new Product;
    $result = (substr($request->name, 0, 3));
    // $prefix = Str::Random(6,'digits');
    $prefix = mt_rand(100000,999999);
    $final = $result.$prefix;

    if(!$prefix){
        $product = Product::where('product_id','column');
    return $this->uniqueIdGenerator($request);}
    else{
    return $final;
}
}

// public function IdGenerator($model, $trow, $length=4, $prefix){
//     $data = $model::orderBy('id', 'desc')-> first();
//     if(!$data){
//             $og_length =$length;
//             $last_number = '';
//     }else{
//         $code = substr($data-> $trow,strlen($prefix) + 1);
//         $actual_last_number = ($code/1) + 1;
//         $increment_last_number = $actual_last_number + 1;
//         $last_number_length = strlen($increment_last_number);
//         $og_length = $length - $last_number_length;
//         $last_number = $increment_last_number;
//     }
//     $zeros = "";
//     for($i = 0;$i < $og_length;$i++){
//         $zeros.= "0";
//     }
//     return $prefix.'-'.$zeros.$last_number;
// }




public function save_image(Request $request){
    $arr=[];
    $allImages = null;
    if($request->hasFile('image')) {
        foreach($request->file('image') as $image) {
        // $destinationPath = public_path('/img');
        // $filename = $image->getClientOriginalName();
        // $image->move($destinationPath, $filename);
        // // return $this->filename;
        // array_push($arr,$filename);
        
        // dd(json_encode($arr));
        $destinationPath = public_path('/img');
        $filename =time(). $image->getClientOriginalName();
        $image->move($destinationPath, $filename);
        $fullPath = $filename;
        $allImages .= $allImages == null ? $fullPath : ',' . $fullPath;
        }
        return $allImages;
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
        $products = Product::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $products = Product::find($id);

        return view('user.product.edit', compact('categories','subcategories','products'));
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

        Product::whereId($id)->update([
            'name' => $request['name'],
            'size' => $request['size'],
            'color' => $request['color'],
            'image' => $this->save_image($request),
            'purchased_quantity' => $request['quantity'],
            'purchased_price' => $request['p_price'],
            'vat' => $request['vat1'],
            'purchased_price' => $request['tot_price'],
            'sell_quantity' => $request['sell_quan'],
            'margin' => $request['margin1'],
            'delivery_charge' => $request['delivery'],
            'discount' => $request['discount'],
            'selling_price' => $request['selling_price'],
            'description' => $request['description'],

        ]);
        return redirect()->route('product.index');
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
        $products = Product::find($id);

        if ($products->delete()) {
            Session::flash('success', 'Product Deleted Successfully');
        }
        return redirect()->route('product.index');
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
          
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
          
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updatePurchase(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removePurchase(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}
