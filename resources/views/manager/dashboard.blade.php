@extends('manager.layouts.master')
@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Manager Dashboard</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
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
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$product}}</h4>
                                <h6 class="text-white m-b-0">All Products</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-1" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p class="text-white m-b-0"><i class=" text-white f-14 m-r-10"></i></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-lite-green update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$order_details->count()}}</h4>
                                <h6 class="text-white m-b-0">All Orders</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-2" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('manager.order.index')}}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More info..</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-yellow update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$order_details->where('is_confirmed', '0')->count() }}</h4>
                                <h6 class="text-white m-b-0">Pending Orders</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-3" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('order.pending')}}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More info.. </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-green update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$order_details->where('is_confirmed', '1')->count() }}</h4>
                                <h6 class="text-white m-b-0">Approved Orders</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-4" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('order.approved')}}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More info..</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-c-pink update-card">
                    <div class="card-block">
                        <div class="row align-items-end">
                            <div class="col-8">
                                <h4 class="text-white">{{$order_details->where('is_confirmed', '2')->count() }}</h4>
                                <h6 class="text-white m-b-0">Cancelled Orders</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                <canvas id="update-chart-4" height="62" width="75" style="display: block; height: 50px; width: 60px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('order.cancelled')}}" class="text-white m-b-0"><i class="feather icon-info text-white f-14 m-r-10"></i>More info..</a>
                    </div>
                </div>
            </div>
            <!-- task, page, download counter  end -->

        </div>
    </div>
</div>

@endsection
