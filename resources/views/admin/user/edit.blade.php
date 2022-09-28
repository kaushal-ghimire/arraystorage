@extends('admin.layouts.master')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
@endpush
@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Manager</h4>
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
                        <li class="breadcrumb-item"><a href="#">Admin</a> </li>
                        <li class="breadcrumb-item"><a href="#!">Edit Manager</a> </li>
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
                        <h5>Fill the form to create new manager</h5>
                        <span>The fields with <a class="text-danger">*</a> are mandatory</span>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <form id="main" method="POST" action="{{route('user.update',$manager->id)}}" enctype="multipart/form-data" novalidate="">
                            @csrf
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control @error('name') input-danger @enderror" name="name" value="{{$manager->name}}" id="name">
                                    
                                    @error('name')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Address<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('address') input-danger @enderror" name="address" value="{{$manager->address}}" id="address">
                                    
                                    @error('address')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('email') input-danger @enderror" name="email" value="{{$manager->email}}" id="email">
                                    
                                    @error('email')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Avatar<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" class=" @error('avatar') input-danger @enderror" name="avatar" value="{{$manager->avatar }}" id="avatar">
                                    
                                    @error('avatar')
                                        <span class="messages">
                                            <p class="text-danger error">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                         
                            <div class="form-group row has-error">
                                <label class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">
                                          <input type="checkbox" id="hasPass">
                                        </div>
                                      </div>
                                      <input type="text" class="form-control @error('password') input-danger @enderror" name="password" id="password">
                                    </div>
                                      <code class="d-none" id="passNote">* Warning: Please copy password before submit.</code>
                                    {{-- <input type="text" class="form-control @error('password') input-danger @enderror" name="password" value="{{$manager->password }}" id="password"> --}}
                                    
                                    @error('password')
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

@push('js')
    <script type="text/javascript">
        $('#hasPass').on('click' ,function() {
            if(this.checked) {
                $('#password').val('{{ rand(10,10000) }}');
                $('#passNote').removeClass('d-none');
            }else {
                $('#password').val('');
                $('#passNote').addClass('d-none');

            }
        });
    </script>
@endpush