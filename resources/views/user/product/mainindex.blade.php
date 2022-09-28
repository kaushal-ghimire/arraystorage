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
                            <table id="list-product-table1" class="table table-hover table-bordered table-responsive-sm" style="width: 100%"> 
                         
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
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}"></script>
    <!-- Custom js -->
    <script src="{{ asset('js/datatables/data-table-custom.js') }}"></script>


<script>
        $(document).ready(function() {
            var dataTable = $('#list-product-table1').DataTable({
                "searching":true,
                "ordering":true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('products.data') !!}",
                    type: "POST",
                    data: {
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
                    { data: 'Product_Id', title: 'Product_Id'  , orderable: true,searchable: true},
                    { data: 'name', title: 'Name'  , orderable: true,searchable: true},
                    { data: 'size',  title: 'Size'  , orderable: true,searchable: true},
                    // { data: 'mcat',  title: 'Main Cat'  , orderable: true,searchable: true},
                    { data: 'color', title: 'Color'  , orderable: true,searchable: true},
                    { data: 'purchased_quantity',  title: 'Purchase Qty'  , orderable: true,searchable: true},
                    // { data: 'unit',  title: 'Unit'  , orderable: true,searchable: true},
                    {data: 'vat', title: 'VAT', oderable: true,searchable: true},
                    { data: 'purchase_price', title: 'Purchase Price'  , orderable: true,searchable: true},
                    {data: 'purchased_price', title: 'Total Amount', oderable: true,searchable: true},
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