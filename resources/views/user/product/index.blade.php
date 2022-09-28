@extends('user.layouts.master')

@section('styles')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/responsive.bootstrap4.min.css') }}">
@endsection

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>List of products</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Products</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li> <a href="{{ route('product.create1', ['id' => $id]) }}" class="btn btn-sm btn-primary float-right">Add Product</a></li>
                                
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-12" >
                                
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="list-product-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%"> 

                                <tfoot>
                                    <tr>
                                        <th colspan="10" class="text-sm-right text-primary" >
                                            <!-- value -->
                                        </th>

                                        <th></th><th></th>

                                    </tr>
                                </tfoot>
                         
                            </table>

                        </div>
                    </div>
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
            
            var dataTable = $('#list-product-table').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };

                    var Total = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $(api.column(9).footer()).html('Total : '+ Total);
                },
                "searching":true,
                "ordering":true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('product.data') !!}",
                    type: "POST",
                    data: {
                        'id' : {{$id}},
                        '_token': '{{ csrf_token() }}',
                       
                    }
                },
                columns: [
                    {
                        title: "SN",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name', title: 'Name'  , orderable: true,searchable: true},
                    { data: 'Product_Id', title: 'Product_Id'  , orderable: true,searchable: true},
                    { data: 'size',  title: 'Size'  , orderable: true,searchable: true},
                    // { data: 'mcat',  title: 'Main Cat'  , orderable: true,searchable: true},
                    { data: 'color', title: 'Color'  , orderable: true,searchable: true},
                    { data: 'purchased_quantity',  title: 'Purchase Qty'  , orderable: true,searchable: true},
                    { data: 'unit',  title: 'Unit'  , orderable: true,searchable: true},
                    {data: 'vat', title: 'VAT', oderable: true,searchable: true},
                    { data: 'purchase_price', title: 'Purchase Price'  , orderable: true,searchable: true},
                    {data: 'purchased_price', title: 'Total Purchased Price', oderable: true,searchable: true},
                    {data: 'sell_quantity', title: 'Sell Qty', oderable: true,searchable: true},
                    { data: 'margin', title: 'Margin(%)'  , orderable: true,searchable: true},
                    { data: 'delivery_charge', title: 'Delivery'  , orderable: true,searchable: true},
                    { data: 'discount', title: 'Dis(%)'  , orderable: true,searchable: true},
                    { data: 'selling_price', title: 'Selling Price'  , orderable: true,searchable: true},
                    { data: 'image', title: 'Image'  , orderable: true,searchable: true},
                    { data: 'description', title: 'Desc'  , orderable: true,searchable: true},
                    { data: 'username', title: 'Entered By'  , orderable: true,searchable: true},
                    { data: 'created_at', title: 'Created',orderable: true },
                    { data: 'action', title: 'Action',orderable: true },
                ],

                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
            });
            // dataTable.on( 'xhr', function () {
            //     var json = dataTable.ajax.json();
            //     document.getElementById('total_balance').innerHTML=("Total : " + json.total_balance);
            // });
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