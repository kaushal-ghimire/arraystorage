@extends('admin.layouts.master')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Edit Level</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ ('admin.dashboard') }}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Level</a> </li>
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
                        <h5>Update Level</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{route('level.update',$level->id)}}" enctype="multipart/form-data">
                         @csrf          
                         @method("PATCH")
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Level <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input oninput="this.value = this.value.toUpperCase()" type="text"  name="level" class="form-control" value="{{$level->level}}">
                                    
                                    @error('level')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Commission(%) <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text"  name="commission" class="form-control" value="{{$level->commission}}">
                                    
                                    @error('commission')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
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