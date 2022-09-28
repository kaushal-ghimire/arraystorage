@extends('admin.layouts.master')

@section('styles')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/flatpicker.min.css') }}">
@endsection

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5>Daybook Report <span class="font-weight-bold text-success">( {{date('l, d F')}} )</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
    <div class="page-body ">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="page-block col-sm-12 bg-secondary">
                        <div class="col-xs-6">
                            <input type="text" name="datetime" id="datetime" placeholder="Choose a Date"/>
                            <div class="btn-group py-2" role="group">
                                <button type="button" name="refresh" id="refresh" class="btn btn-sm btn-primary btn-round">Refresh</button>
                            </div>
                        </div>
                     <div class = "row">

                        <div class="col-md-4">
                            <div class="card statustic-card">
                                <div class="card-header">
                                    <h5>Purchase</h5>
                                </div>
                                <div class="card-block text-center tp">
                                    <strong class="d-block text-c-blue f-36">{{$total_pur}}</strong>
                                    <p class="m-b-0">Total Purchase</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-blue" style="width:50%"></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-blue">
                                    <h6 class="text-white m-b-0">Quantity : {{$product->sum('purchased_quantity')}} </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card statustic-card">
                                <div class="card-header">
                                    <h5>Sales</h5>
                                </div>
                                <div class="card-block text-center">
                                    <strong class="d-block text-c-pink f-36">{{$total_sale}}</strong>
                                    <p class="m-b-0">Total Sales</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-pink" style="width:50%"></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-pink">
                                    <h6 class="text-white m-b-0">Quantity : {{$order->sum('quantity')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card statustic-card">
                                <div class="card-header">
                                    <h5>Margin</h5>
                                </div>
                                <div class="card-block text-center">
                                    <strong class="d-block text-c-green f-36">{{$total_mar}}</strong>
                                    <p class="m-b-0">Total Margin</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-c-green"style="width:50%"></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-c-green">
                                    <h6 class="text-white m-b-0">Sum: {{$product->sum('margin')}}%</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="dt-responsive table-responsive">
                            <table id="list-daybook-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">

                                <thead>

                                  
                               </thead>

                            </table>

                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')
        <!-- data-table js -->
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}"></script>
    <!-- Custom js -->
    <script src="{{ asset('js/datatables/data-table-custom.js') }}"></script>
    <script src="{{asset ('js/flatpicker.min.js') }}"></script>


<script>

        $(document).ready(function() {
            $('#datetime').on( 'change', function () {
                var date_select = $('#datetime').val();
                console.log(date_select);
                var token='{{ csrf_token() }}';
                $.ajax({
                    url : '{!! route('daybook.data') !!}',
                    type: 'POST',
                    data:{
                        "_token":token,
                        "date_select":date_select
                    },

                    success: function(data){
                        // console.log(data);
document.getElementsByClassName('d-block text-c-blue f-36')[0].innerText=data.tp;
document.getElementsByClassName('d-block text-c-pink f-36')[0].innerText=data.ts;
document.getElementsByClassName('d-block text-c-green f-36')[0].innerText=data.tm;

                        // $('#tp').append("lol");
                    }
                });

            });
            $('#refresh').click(function(){
            $('#datetime').val('');
            // load_data(date_select);
        });
            // var dataTable = $('#list-daybook-table').DataTable({

            //     "processing": true,
            //     "serverSide": true,
            //     "ajax": {
            //         url: "{!! route('daybook.data') !!}",
            //         type: "POST",
            //         headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //         data: {
            //             '_token': '{{ csrf_token() }}',
            //         }
            //     },
            //     columns: [
            //         { data: 'name', title: 'Product', orderable: true,searchable: false},

            //         { data: 'purchased_price', title: 'Total Purchase', orderable: true,searchable: false},
            //         { data: 'sold_price', name: 'sold_price', title: 'Total Sales', oderable: true,searchable: false},
            //         { data: 'margin_amt', title: 'Total Margin'  , orderable: true,searchable: false},

            //     ],

            // });
        });
</script>

<script>
flatpickr("#datetime", {

    dateFormat: "Y-m-d",
    maxDate: "today",

});

</script>


    @if (Session::has('success'))
        <script>
            toastr.options.timeOut = 1200;
            toastr.success("{!! Session::get('success') !!}");
        </script>
    @elseif(Session::has('error'))
        <script>
            toastr.options.timeOut = 1200;
            toastr.error("{!! Session::get('error') !!}");
        </script>
    @endif
@endsection