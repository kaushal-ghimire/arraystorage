@extends('manager.layouts.master')

@section('styles')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Ordered cart</h5>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12">
                <div id="wizard">
                    <section>
                        <!-- <form class="wizard-form" id="basic-forms" action="#"> -->
                            <!-- Shopping cart field et start -->
                            <h3> Order Details </h3>
                            <fieldset>
                             <div class="table-responsive">

                                <table id="show-order-table" class="table table-hover table-bordered ">
                                    <!-- <thead>
                                        <tr>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80px;">Cart_Id</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 125px;">Image</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 125px;">Product</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 20px;">Qty</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Rate</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Delivery</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Amount</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Created Date</th>
                                        </tr>
                                    </thead> -->
                                </table>
                              </div>
                            </fieldset>
                            <h3> Delivery Details </h3>

                            @foreach($shipping as $ship)
                            <fieldset class="bank-detail p-t-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="card-number" class="form-label">Customer's Name : <u class="text-success"><span class="text-danger">{{$ship->name}}</span></u></label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">Address : <span class="text-danger text-uppercase">{{$ship->address}}</span> </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">City : <span class="text-danger">{{$ship->city}}</span> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="location" class="form-label">Delivery Location : <span class="text-danger">{{$ship->map_address}}</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="phone-2" class="form-label">Phone : <span class="text-danger">{{$ship->phone_no}}</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="location" class="form-label">Status : <span class="text-danger">{{$ship->status}}</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                            @endforeach
                            
                            <!-- Delivery Details fieldset end -->
                            <!-- Payment Details fieldset start -->

                            <!-- <h3> Payment Details </h3>
                            <fieldset class="bank-detail">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    Payment Method: Esewa
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset> -->

                            <!-- Payment Details fieldset end -->


                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
        <!-- data-table js -->
    <script src="{{url('/')}}/plugins/datatables/jquery.dataTables.js"></script>
    <script src="{{url('/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#show-order-table').DataTable({
                "searching" : true,
                "processing": true,
                dom: 'Bfrtip',
                
                "language": {
                    processing: 'Please Wait...',
                    searchPlaceholder: "Search"
                },

                "serverSide": true,
                "keys": true,
                "pagingType": "full_numbers",
                "ajax":{
                    "url": "{{route('order.show.data')}}",
                    "dataType": "json",
                    "type": "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'orderid': {{$orderid}}
                    }
                },
                columns: [
                    
                    { data: 'id', title: 'Id', orderable: true,searchable: true },
                    { data: 'bill_id', title: 'Bill Id', orderable: true,searchable: true },
                    { data: 'product_id', title: 'Product', orderable: true,searchable: true },
                    { data: 'quantity', title: 'Qty', orderable: true,searchable: true },
                    { data: 'rate', title: 'Rate', orderable: true,searchable: true },
                    { data: 'discount', title: 'Dis.', orderable: true,searchable: true },
                    { data: 'total', title: 'Total', orderable: true,searchable: true },
                    { data: 'date', title: 'Ordered Date' , orderable: true,searchable: true},
                    { data: 'is_confirmed', title: 'Confirmation', orderable: true,searchable: true ,
                    render: function ( data, type, row ) {
                        if (data == "0") {
                            color = '#ff9900';
                            return '<span style="color:' + color + '">' + "Pending" +'</span>';
                        }
                        else if (data == "1") {
                            color = '#00cc00';
                            return '<span style="color:' + color + '">' + "Approved" +'</span>';
                        }
                        else if (data == "2") {
                            color = 'red';
                            return '<span style="color:' + color + '">' + "Cancelled" +'</span>';
                        }
                        // return '<span style="color:' + color + '">' + data +'</span>';
                        }

                    },
                    // { data: 'confirmed_date', title: 'Confirmed Date', orderable: true,searchable: true },
                    { data: 'deliver_date', title: 'Deliver Date', orderable: true,searchable: true },
                    { data: 'confirmed_by', title: 'Confirmed By', orderable: true,searchable: true },
                    // { data: 'created_at', title: 'Created Date',orderable: true,searchable: true  }
                    
                ],
                "row": [],


                "order": [
                [ 0 ,"desc" ]
                ]
            });
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

