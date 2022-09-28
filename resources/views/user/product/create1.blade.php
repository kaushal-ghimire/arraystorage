@extends('user.layouts.master')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Create Product</h4>
                        {{-- <span>Provide valid details to create a new admin or organization</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ ('user.dashboard') }}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">User</a> </li>
                        <li class="breadcrumb-item"><a href="#!">Product
                        </a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->

    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Inputs Validation start -->
                <div class="card">
                    <div class="card-header">
                        <h5>Fill the form to create new product</h5>
                        <span>The fields with * are mandatory</span>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <form id="main" method="POST" action="{{route('product.store')}}" enctype="multipart/form-data" novalidate="">
                            @csrf
                            @method('post')
                            <div class="form-group row has-error">
                                <input type="hidden" value="{{$bill_id}}" name="billid">
                            <label class="col-sm-2 col-form-label">Select Category <span class="text-danger">*</span></label>
                                <div class="col-sm-2">   
                                        <select name="category" type="text" class="form-control">
                                           <option value="">-- Select a category --</option>
                                            @foreach($categories as $category)
                                              <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div><a href="{{ route('category.create') }}" class="btn btn-sm btn-primary float-right">Add Cat</a></div>

                                <label class="col-sm-2 col-form-label">Select Sub-Category <span class="text-danger">*</span></label>
                                <div class="col-sm-2">   
                                        <select name="subcategory" type="text" class="form-control">
                                           <option value="">-- Select a sub-category --</option>
                                            @foreach($subcategories as $subcategory)
                                              <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div><a href="{{ route('subcategory.create') }}" class="btn btn-sm btn-primary float-right">Add Sub</a></div>

                            </div>

                            <div class="form-group row has-error">

                                
                            <label class="col-sm-2 col-form-label">Select Gender</label>
                                <div class="col-sm-2">   
                                        <select name="maincategory" type="text" class="form-control">
                                           <option value="">-- Select a gender--</option>
                                            @foreach($maincategories as $maincategory)
                                              <option value="{{$maincategory->id}}">{{$maincategory->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div><a href="{{ route('maincategory.create') }}" class="btn btn-sm btn-primary float-right">Add Gen</a></div>

                            <label class="col-sm-2 col-form-label">Product Name <span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control @error('name') input-danger @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="Enter product name">

                                    @error('name')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div> 
                            </div>
                            
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Product Size <span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control @error('size') input-danger @enderror" name="size" value="{{ old('size') }}" id="size" placeholder="Enter product size">

                                            @error('size')
                                                <span class="messages">
                                                    <p class="text-danger error">{{ $message }}</p>
                                                </span>
                                            @enderror
                                    </div>

                                <label class="col-sm-2 col-form-label">Product Color <span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control @error('color') input-danger @enderror" name="color" value="{{ old('color') }}" id="color" placeholder="Enter product color">

                                        @error('color')
                                            <span class="messages">
                                                <p class="text-danger error">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>  
                            </div>

                        <div class="form-group row has-error">
                            <label class="col-sm-2 col-form-label">Purchase Quantity<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control quantity @error('quantity') input-danger @enderror" name="quantity" value="{{ old('quantity') }}" id="quantity" onKeyUp="calculation()" placeholder="Enter product quantity">
                                </div> 

                            <label class="col-sm-2 col-form-label">Purchase Unit <span class="text-danger">*</span></label>
                                <div class="col-sm-2">   
                                        <select name="unit" type="text" class="form-control">
                                           <option value="">-- Select an unit --</option>
                                            @foreach($units as $unit)
                                              <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div><a href="{{ route('unit.create') }}" class="btn btn-sm btn-primary float-right">Add Unit</a></div>
                        </div>

                        <div class="form-group row has-error">

                                <label class="col-sm-2 col-form-label">Purchase Rate<span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control p_price @error('p_price') input-danger @enderror" name="p_price" value="{{ old('p_price') }}" id="p_price" onKeyUp="calculation()" placeholder="Enter Product price">
                                    </div>

                                <label class="col-sm-2 col-form-label">Selling Quantity<span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" 
                                                class="form-control quan @error('sell_quan') input-danger @enderror" 
                                                name="sell_quan" 
                                                value="{{ old('sell_quan') }}" 
                                                id="sell_quan"
                                                placeholder="Product Selling Quantity">
                                    </div>
                                     

                            </div>

                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Total Purchase Amount<span class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" 
                                               class="form-control purchase @error('tot_price') input-danger @enderror" 
                                               readonly 
                                               name="tot_price" 
                                               value="{{ old('tot_price') }}" 
                                               id="tot_price" 
                                               placeholder="Total product price">
                                    </div>
                                
                                <label class="col-sm-2 col-form-label">Selling Unit <span class="text-danger">*</span></label>
                                        <div class="col-sm-3">   
                                                <select name="unit" type="text" class="form-control">
                                                <option value="">-- Select an unit --</option>
                                                    @foreach($units as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                    @endforeach
                                                </select>
                                        </div>

                            </div>

                        
                    <div class="form-group row has-error"> 
                        
                    <!-- <label class="col-sm-2 col-form-label">VAT(13% included.)<span class="text-danger">*</span></label> -->
                                    <div class="col-sm-5">
                                        <input type="checkbox" name="vat" class="vat-amount" id="myVatCheck" onclick="myVatFunction(),myVatFunction1()">
                                            <label for="myVatCheck" style="margin-right: 100px;">VAT(%)</label>
                                         <p id="text3" style="display:none" disabled>
                                            <input type="text3"
                                                    class="form-control vat-amt @error('vat') input-danger @enderror"
                                                    readOnly 
                                                    name="vat1" 
                                                    value="{{ old('vat') }}" 
                                                    id="vat"
                                                    placeholder="">
                                        </p>
                                    </div>
                                                                    <!-- <label class="col-sm-2 col-form-label">Margin<span class="text-danger">*</span></label> -->
                                    <div class="col-sm-6">
                                        <input type="checkbox" name="margin" class="checker" id="myMarginCheck" onclick="myMarginFunction()">
                                            <label for="myCheck" style="margin-right: 100px;">Margin(%)</label>
                                         <p id="text" style="display:none" disabled>
                                                <input type="text" 
                                                        class="form-control margin-percent @error('margin1') input-danger @enderror"    
                                                        name="margin1" 
                                                        value="{{ old('margin1') }}" 
                                                        id="margin1"
                                                        placeholder="Enter product margin">
                                        </p>
                                    </div>

                    </div>



                            <div class="form-group row has-error">

                                <!-- <label class="col-sm-2 col-form-label">Delivery Charge<span class="text-danger">*</span></label> -->
                                <div class="col-sm-5">
                                        <input type="checkbox" name="delivery" class="delivering" id="myDeliveryCheck" onclick="myDeliveryFunction()">
                                            <label for="mydeliveryCheck" style="margin-right: 20px;">Delivery Charge(Rs.)</label>
                                                <p id="text1" style="display:none" disabled>
                                                    <input type="text"  
                                                    class="form-control delivered @error('delivery') input-danger @enderror" 
                                                    name="delivery" 
                                                    value="0" 
                                                    id="deliver"
                                                    placeholder="Enter product delivery">
                                                </p>
                                </div>
                            

                                        <!-- <label class="col-sm-2 col-form-label">Discount<span class="text-danger">*</span></label> -->
                                <div class="col-sm-6">
                                        <input type="checkbox" name="discount" class="discounting" id="mydiscountCheck" onclick="myDiscountFunction()">
                                            <label for="mydiscountCheck" style="margin-right: 90px;">Discount(%)</label>
                                                <p id="text2" style="display:none" disabled>
                                                        <input type="text" 
                                                            class="form-control discounted @error('discount') input-danger @enderror" 
                                                            name="discount" 
                                                            value="{{ old('discount') }}" 
                                                            id="discount" 
                                                            placeholder="Enter product discount">
                                                </p>
                                </div>
                            </div>

                               
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Selling Price(/unit)<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="number" 
                                            class="form-control sell @error('selling_price') input-danger @enderror" 
                                            name="selling_price"
                                            readonly 
                                            id="selling_price" 
                                            placeholder="Selling Price">
                                        
                                </div>
                            </div>

                            <div class="form-group row has-error">
                                    <label class="col-sm-2 col-form-label">Product Image <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                @includeIf('user.product.addMultipleImage')
                                </div>
                            </div>

                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label" for="text-area" name="description">Product Description</label>
                                <div class="col-md-6">
                                <textarea class="form-control" name="description" id="FormControlTextarea" rows="4"></textarea>
                                </div>      
                            </div>
                                                    
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary m-b-0">Add</button>
                                    <!-- @error('size')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Form components Validation card end -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- <script src="product.main.js"></script> -->
<script>
    var dis_check="off";
    $('#sell_quan').on('keyup', function(e){
        var tot_price = $('#tot_price').val();
        var sell_quan = $(this).val();
        sellQuan(tot_price,sell_quan);
    });

    function sellQuan(tot_price,sell_quan){
        if(sell_quan){
            var selling_price = tot_price / sell_quan;
            $('#selling_price').val('0');
            $('#selling_price').val(selling_price);
        }else{
            $('#selling_price').val('0');
        }
    }
    $('#myVatCheck').on('click', function(e){
        var vat_satus = $(this).val();
        
        if(vat_satus == "on"){
            vatCal()
        }
    });
    $('#vat').on('keyup', function(e){
        vatCal()
    });
    function vatCal(){
        var quantity = $('#quantity').val();
        var p_price = $('#p_price').val();
        var sell_quan = $('#sell_quan').val();
        var tot_price = $('#tot_price').val();
        var selling_price = $('#selling_price').val();
        var vat = $('#vat').val();
        var vat_status = $('#myVatCheck').val();
        console.log(vat_status);
        // debugger;
        
        
        if(quantity != "" && p_price != "" && sell_quan != "" && vat){
            var tot_price = (quantity * p_price) + ((quantity * p_price) * vat) / 100;
            var selling_price = tot_price / sell_quan;
            $('#tot_price').val('0');
            $('#selling_price').val('0');
            
            $('#tot_price').val(tot_price);
            $('#selling_price').val(selling_price);
        }else{
            sellQuan(tot_price,sell_quan);
        }
    }


    $('#myMarginCheck').on('click', function(e){
        var margin_status = $(this).val();
        
        if(margin_status == "on"){
            marginCal()
        }
    });
    $('#margin1').on('keyup', function(e){
        marginCal()
    });
    function marginCal(){
        var quan = $('#quantity').val();
        var pur_price = $('#p_price').val();
        var tot_price = parseFloat($('#tot_price').val());
        var sells_quan = $('#sell_quan').val();
        var vat = $('#vat').val();
        var sellings_price = $('#selling_price').val();
        var margin =parseFloat($('#margin1').val());
        var margin_status = $('#myMarginCheck').val();
        console.log(margin_status);
        // debugger;
        

        
        if(quan != "" && pur_price != "" && sells_quan != "" && margin){
            var purchase_amt = quan * pur_price;
            var amt_vat = purchase_amt + (((purchase_amt) * vat) / 100);
            var single_pc_price = ( amt_vat / sells_quan);
            var margin_price = single_pc_price +  ((single_pc_price * margin) / 100);
            
         
            $('#selling_price').val('0');
            
            $('#selling_price').val(margin_price);
        }else{
            if(vat != ""){
                vatCal();
            }else{
                sellQuan(tot_price,sell_quan);
            }
        }
    }

    $('#mydiscountCheck').on('change', function(e){
        var discount_status = $(this).val();
        if( $(this).is(":checked")){
            dis_check="on";
            discountCal()

        }
        else{
            dis_check="off";
            discountCal()

        }
        console.log("dis sts "+dis_check);
        // if(discount_status == "on"){
        //     discountCal()
        //     dis_check="on";
        // }
        // else{
        //     dis_check="off";

        // }
    });
    $('#discount').on('keyup', function(e){
        discountCal()
    });
    function discountCal(){
        var quan_dis = parseFloat($('#quantity').val());
        var pur_price_dis = parseFloat($('#p_price').val());
        var tot_price_dis = parseFloat($('#tot_price').val());
        var sells_quan_dis = parseFloat($('#sell_quan').val());
        var vat_dis = parseFloat($('#vat').val());
        var sellings_price_dis = parseFloat($('#selling_price').val());
        var margin_dis =parseFloat($('#margin1').val());
        var discount =parseFloat($('#discount').val());
        var discount_status = $('#mydiscountCheck').val();
        var delivery = parseFloat($('#deliver').val());
        var discount_price_dis;
        console.log(discount_status);
        // debugger;
        
        if(dis_check == "off"){
            deliveryCal()
        }
        
        if(quan_dis != "" && pur_price_dis != "" && sells_quan_dis != ""){
            var pur_amt = quan_dis * pur_price_dis;
            var vat_amount = pur_amt + (((pur_amt) * vat_dis) / 100);
            var margin_price = vat_amount + (((vat_amount) * margin_dis) / 100);
            var sell_price = ( margin_price / sells_quan_dis) + delivery;
            
            if(dis_check == "on"){
                discount =parseFloat($('#discount').val());
                var dis_price = ((sell_price * discount) / 100);
                console.log(dis_price);
                 discount_price_dis = sell_price - dis_price;
            }else{
                discount_price_dis = sell_price;
            }
          
            
            
         
            $('#selling_price').val('0');
            
            $('#selling_price').val(discount_price_dis);
        }else{
            if(vat != "" && margin_dis != ""){
                vatCal();
                marginCal();
            }else{
                sellQuan(tot_price,sell_quan);
            }
        }
    }

    $('#myDeliveryCheck').on('click',function(e){
        var delivery_status = $(this).val;

        if(delivery_status == "on"){
            deliveryCal()
        }else{
            marginCal()
        }
    });

    $('#deliver').on('keyup',function(e){
        // console.log("test");
        deliveryCal()
    });

    function deliveryCal(){
        var quan_delivery = parseFloat($('#quantity').val());
        var pur_price_del = parseFloat($('#p_price').val());
        // var tot_price_del = parseFloat($('#tot_price').val());
        var vat_del = parseFloat($('#vat').val());
        var margin_del =parseFloat($('#margin1').val());
        var sells_quan_del = parseFloat($('#sell_quan').val());
        var discount_del;
        var delivery_charge = parseFloat($('#deliver').val());
        var delivery_status = $('#myDeliveryCheck').val();
        
       
        // debugger;
       

        if(quan_delivery != "" && pur_price_del != "" && vat_del != "" && margin_del != ""){

            
  
            
            // var discount_price_del;
            var total_pur = quan_delivery * pur_price_del;
            
            
            var vat_amt_del = total_pur +  (((total_pur) * vat_del) / 100);
            console.log(vat_amt_del);
            var margin = (((vat_amt_del) * margin_del) / 100);
            var margin_price_del = vat_amt_del + margin;
            console.log(margin_price_del);
            var single_pc_price_del = ( margin_price_del / sells_quan_del);
            var sells_price = single_pc_price_del + delivery_charge;
            console.log(single_pc_price_del);
            var discount_price_del;
            var price_with_delivery;
           
            if(dis_check=="on"){
                // discount_del=1; 
              
              discount_del=parseFloat($('#discount').val());
              price_with_delivery = sells_price - ((sells_price * discount_del)/ 100);
        }
        else{
            price_with_delivery = sells_price;
        }
      
    
            $('#selling_price').val(0);

            $('#selling_price').val(price_with_delivery);
        }
    }

</script>
@endpush