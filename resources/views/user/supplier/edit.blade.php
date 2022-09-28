@extends('user.layouts.master')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Edit Supplier</h4>
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
                        <li class="breadcrumb-item"><a href="#!">Supplier
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
                        <h5>Update Supplier</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{route('supplier.update',$suppliers->id)}}" enctype="multipart/form-data">
                           @csrf          
                           @method("PATCH")
                                      <div class="form-group form-control">
                                        <label class="col-form-label">Supplier's Name:</label>
                                        <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{$suppliers->name}}" id="name">
                                        @error('amount')
                                            <span class="messages">
                                                <p class="text-danger">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="form-group form-control">
                                        <label class="col-form-label">Business Id:</label>
                                        <input type="text" class="form-control @error('business') is-invalid @enderror"
                                            name="business" value="{{$suppliers->business_id}}" id="business">
                                        @error('business')
                                            <span class="messages">
                                                <p class="text-danger">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-control">
                                        <label class="col-form-label">Phone:</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{$suppliers->phone}}" id="phone">
                                        @error('phone')
                                            <span class="messages">
                                                <p class="text-danger">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-control">
                                        <label class="col-form-label">Address:</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            name="address" value="{{$suppliers->address}}" id="address">
                                        @error('address')
                                            <span class="messages">
                                                <p class="text-danger">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-control">
                                        <label class="col-form-label">PAN:</label>
                                        <input type="text" class="form-control @error('pan') is-invalid @enderror"
                                            name="pan" value="{{$suppliers->pan}}" id="pan">
                                        @error('pan')
                                            <span class="messages">
                                                <p class="text-danger">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group form-control">
                                        <label class="col-form-label">Date:</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror"
                                            name="date" value="{{$suppliers->created_at}}" id="date">
                                        @error('date')
                                            <span class="messages">
                                                <p class="text-danger">{{ $message }}</p>
                                            </span>
                                        @enderror
                                    </div>


                        <!-- <div class="form-group row form-control-lg has-error">
                            <label class="col-form-label">Phone:</label>
                            <div class="col-sm-4">
                                <input type="text"  name="phone" class="form-control" value="{{$suppliers->phone}}">
                            </div>
                        </div> -->
                            
                        

                        <div class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary">Update</button>
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