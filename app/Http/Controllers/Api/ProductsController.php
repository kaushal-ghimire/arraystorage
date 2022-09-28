<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
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
        $product = Product::all();
        return response()->json(['products' => $product], 200);
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
        return view('user.product.create', compact('categories','subcategories','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->category);
        // dd($request->tot_price);
        // dd($request->margin1);
        // dd($request->has('checkbox'));
        // $randomNumber = random_int(100000, 999999);
        // dd($randomNumber);

        $rules = [
            'name' => 'required|string',
            'size' => 'required|string',
            'color' => 'required|string',
            'image.*' =>  'image','mimes:jpg,png,jpeg,gif,svg,JPG,PNG,JPEG,GIF,SVG','max:200',
        ];
    
        $customMessages = [
            'max' => 'The max size should be less than 200kb.'
        ];

        $this->validate($request, $rules,$customMessages);

        $product = new Product();
        $product->id = $request->id;
        $product->categories_id = $request->category;
        $product->subcategories_id = $request->subcategory;
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

        if ($product->save()) {
            Session::flash('success', "Product Added Successfully");
            return redirect()->route('product.index');
        }
}


// public function check_margin(Request $request){
    
//     if($request->has('checkbox')){
        
//     }
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
        $products = Product::findOrFail($id);
        return $products;
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

    public function search($id)
    {
            return Product::where('id','like','%'.$id.'%')->get();
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

