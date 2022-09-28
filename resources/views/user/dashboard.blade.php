@extends('user.layouts.master')

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>User Dashboard</h4>
                        <span>Managing All System</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->

    <div class="page-body">
        <div class="row">
            <!-- task, page, download counter  start -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-yellow update-card">
                    <div class="card-block ">
                        <div class="row align-items-end">
                            <div class="col-8">

                                <h4 class="text-white">{{$categories}}</h4>
                                <h6 class="text-white m-b-0">All Categories</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-1" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('category.index') }}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More Info..</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-green update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$subcategories}}</h4>
                                <h6 class="text-white m-b-0">All Subcategories</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-2" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('subcategory.index') }}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More Info..</a>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-pink update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$units}}</h4>
                                <h6 class="text-white m-b-0">All Units</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-3" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('unit.index') }}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More Info..</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-blue update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$maincategories}}</h4>
                                <h6 class="text-white m-b-0">All Gender</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-3" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('maincategory.index') }}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More Info..</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-yellow update-card">
                    <div class="card-block ">
                        <div class="row align-items-end">
                            <div class="col-8">

                                <h4 class="text-white">{{$supplier}}</h4>
                                <h6 class="text-white m-b-0">All Suppliers</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-1" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('supplier.index') }}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More Info..</a>
                    </div>
                </div>
            </div>
    
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-green update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$product}}</h4>
                                <h6 class="text-white m-b-0">All Products</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-3" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('product.mainindex') }}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More Info..</a>
                    </div>
                </div>
            </div>
            
            <!-- task, page, download counter  end -->

        </div>
    </div>
</div>
    
@endsection