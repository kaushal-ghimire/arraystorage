@extends('user.layouts.master')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Edit Category</h4>
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
                        <h5>Update category</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{route('product.update',$products->id)}}" enctype="multipart/form-data">
                         @csrf          
                         @method("PATCH")
                        <div class="form-group row has-error">

                            <label class="col-sm-2 col-form-label">Product Name <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control @error('name') input-danger @enderror" name="name" value="{{$products->name}}" id="name" placeholder="Enter product name">

                                @error('name')
                                    <span class="messages">
                                        <p class="text-danger error">{{ $message }}</p>
                                    </span>
                                @enderror
                            </div> 

                            <label class="col-sm-2 col-form-label">Product ID<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('pid') input-danger @enderror" name="pid" value="{{ $products->id}}" id="pid" placeholder="Enter product Id">
                            </div>
                        </div>

                        <div class="form-group row has-error">
                            <label class="col-sm-2 col-form-label">Product Size <span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control @error('size') input-danger @enderror" name="size" value="{{ $products->size }}" id="size" placeholder="Enter product size">

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
                                <input type="text" class="form-control quantity @error('quantity') input-danger @enderror" name="quantity" value="{{ $products->purchased_quantity }}" id="quantity" onKeyUp="calculation()">
                            </div> 
                        </div>

                        <div class="form-group row has-error">

                            <label class="col-sm-2 col-form-label">Purchase Price(per pcs.)<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control p_price @error('p_price') input-danger @enderror" name="p_price" value="{{ $products->purchase_price }}" id="p_price" onKeyUp="calculation()">
                                </div>
                                
                                <label class="col-sm-2 col-form-label">VAT</span></label>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="vat" class="vat-amount" id="myVatCheck" onclick="myVatFunction(),myVatFunction1()">
                                    <label for="myVatCheck">Add VAT</label><br>
                                    <p id="text3" style="display:none" disabled><input type="text3" class="form-control @error('vat') input-danger @enderror" name="vat1" value="{{ $products->vat }}" id="vat" onKeyUp="calculation(),calculateSell()"></p>
                                </div>
                        </div>

                        <div class="form-group row has-error">
                            <label class="col-sm-2 col-form-label">Total Purchase Amount<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control purchase @error('tot_price') input-danger @enderror" readonly name="tot_price" value="{{ old('tot_price') }}" id="tot_price" onKeyUp="calculation()" placeholder="Total product price">
                                </div>

                            <label class="col-sm-2 col-form-label">Selling Quantity<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control quan @error('sell_quan') input-danger @enderror" name="sell_quan" value="{{ $products->sell_quantity }}" id="sell_quan" onKeyUp="calculateSell()" >
                                </div>
                        </div>



                        <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Margin<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="margin" class="checker" id="myCheck" onclick="myMarginFunction(),myMarginFunction()">
                                        <label for="myCheck">Add your margin</label><br>
                                    <p id="text" style="display:none" disabled><input type="text" class="form-control @error('margin1') input-danger @enderror" name="margin1" value="{{ $products->margin }}" id="margin1" onKeyUp="calculateSell()"></p>
                                </div>

                                <label class="col-sm-2 col-form-label">Delivery Charge<span class="text-danger">*</span></label>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="delivery" class="delivering" id="mydeliveryCheck" onclick="myDeliveryFunction()">
                                        <label for="mydeliveryCheck">Charge(To Deliver)</label><br>
                                    <p id="text1" style="display:none" disabled><input type="text"  class="form-control @error('delivery') input-danger @enderror" name="delivery" value="{{ $products->delivery_charge }}" id="delivery" onKeyUp="calculateSell()"></p>
                                </div>
                        </div>

                        <div class="form-group row has-error">
                                    <label class="col-sm-2 col-form-label">Discount<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                    <input type="checkbox" name="discount" class="discounting" id="mydiscountCheck" onclick="myDiscountFunction()">
                                        <label for="mydiscountCheck">Discount</label><br>
                                    <p id="text2" style="display:none" disabled><input type="text" class="form-control @error('discount') input-danger @enderror" name="discount" value="{{ $products->discount }}" id="discount" onKeyUp="calculateSell()"></p>
                            </div>

                                <label class="col-sm-2 col-form-label">Selling Price(per unit)<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text4" class="form-control sell @error('selling_price') input-danger @enderror" name="selling_price" value="{{ $products->selling_price }}" readonly id="selling_price" onKeyUp="calculation(),calculateSell()">
                            </div>
                        </div>

                        <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Product Image <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                            {{ $products->image }}
                            @includeIf('user.product.addMultipleImage')
                            </div>
                        </div>

                        <div class="form-group row has-error">
                            <label class="col-sm-2 col-form-label" for="text-area" name="description">Product Description</label>
                            <div class="col-md-6">
                            <textarea class="form-control" name="description" id="FormControlTextarea" rows="4" >{{ $products->description }}</textarea>
                            </div>      
                        </div>
                         

                        <div class="form-group row">
                                <label class="col-sm-2"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary m-b-0">Update</button>
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