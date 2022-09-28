@extends('admin.layouts.master')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Create Slide</h4>
                        {{-- <span>Provide valid details to create a new admin or organization</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ ('admin.dashboard') }}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Create Slide
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
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <form id="main" method="POST" action="{{route('slide.store')}}" enctype="multipart/form-data" novalidate="">
                            @csrf
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Title <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('title') input-danger @enderror" name="title" value="{{ old('title') }}" id="title" placeholder="Enter Slide title">

                                    @error('title')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control @error('image') input-danger @enderror" name="image" value="{{ old('image') }}" id="image" placeholder="">
                                    @error('image')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary m-b-0">Add</button>
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
