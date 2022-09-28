@extends('admin.layouts.master')

@section('styles')
    <!-- Data Table Css -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <style type="text/css">
    .sold {
        font-weight: bold;
        text-align: center;
        font-size: 14px;

          }
          </style>
@endsection

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Purchase Reports</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Purchase</a> </li>
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
                        <div class="row">
                            <!-- <div class="form-outline col-md">
                                <input type="search" id="form1" class="form-control" placeholder="Search by Product" aria-label="Search" />
                            </div> -->
                            <div class="form-outline col-md">
                                <input type="search" id="form2" class="form-control" placeholder="Search by Product_Id" aria-label="Search" />
                            </div>
                            <div class="form-outline col-md">
                                <input type="search" id="form3" class="form-control" placeholder="Search by Category" aria-label="Search" />
                            </div>
                            <div class="input-group col-md">
                                <!-- input-daterange -->
                                <input type="text" 
                                        name="from_date" 
                                        id="from_date" 
                                        class="form-control " 
                                        type="date" 
                                        placeholder="From" 
                                        autocomplete="off"/>
                                <div class="input-group-addon py-1">-</div>
                                <input type="text" 
                                        name="to_date" 
                                        id="to_date" 
                                        class="form-control" 
                                        placeholder="To"
                                        autocomplete="off"/>
                            </div>
                            <div class="btn-group col-md-2" role="group">
                                <!-- <button type="button" 
                                        name="filter" 
                                        id="filter"
                                        class="btn btn-sm btn-primary btn-round">
                                    Filter
                                </button> -->
                                <button type="button" name="refresh" id="refresh" class="btn btn-sm btn-primary btn-round">Refresh</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="list-purchase-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Product_Id</th>
                                        <th>Category</th>
                                        <th>Purchased Qty</th>
                                        <th>Rate</th>
                                        <th>Total Purchase</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right text-primary" >
                                            <!-- value -->
                                            <span id="total_balance"></span>
                                        </th>

                                        <th></th>

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
 


</div>
    

@endsection

@section('scripts')
<script src="{{url('/')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.html5.min.js') }}"></script>
<script src="{{url('/')}}/plugins/sum().js"></script>


<script type="text/javascript">
    $(document).ready(function(){
        fill_datatable();

        $('#from_date').datepicker({
            todayBtn:'linked',
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,

        });
        $('#to_date').datepicker({
            todayBtn:'linked',
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
        });

        $('#form1,#form2,#form3').on('keyup',function() {
            var form1 = $('#form1').val();
            var form2 = $('#form2').val();
            var form3 = $('#form3').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            $('#list-purchase-table').DataTable().destroy();
            fill_datatable(form1,form2,form3,from_date,to_date);
        });
        $('#from_date,#to_date').on('change',function(){
            var form1 = $('#form1').val();
            var form2 = $('#form2').val();
            var form3 = $('#form3').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
                $('#list-purchase-table').DataTable().destroy();
                fill_datatable(form1,form2,form3,from_date,to_date);
        });

        $('#refresh').click(function(){
            $('#form1').val('');
            $('#form2').val('');
            $('#form3').val(''); 
            $('#from_date').val('');
            $('#to_date').val('');
            load_data(form1,form2,form3,from_date,to_date);
        });


        function fill_datatable(form1 = '', form2 = '',form3 = '',from_date = '',to_date = '')
        {
            var dataTable = $('#list-purchase-table').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };

                    var Total = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $(api.column(5).footer()).html('Total : '+ Total);
                },
                "searching" : true,
                "processing": true,
                dom: 'Bfrtip',
                buttons:[
                "excelHtml5",
                "pdfHtml5",
                "print",
                ],
                "language": {
                    processing: 'Please Wait...',
                    searchPlaceholder: "Search product"
                },

                "serverSide": true,
                "keys": true,
                "pagingType": "full_numbers",
                "ajax":{
                    "url": "{{route('purchase.data')}}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ 
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        data:{
                            'product' : form1,
                            'product_id' : form2,
                            'category' : form3,
                            'from_date' : from_date,
                            'to_date' : to_date,
                        }
                    }
                },
                "columns": [
                    { data: 'name',title: 'Product'  , orderable: true,searchable: true},
                    { data: 'id',title: 'Product_Id'  , orderable: true,searchable: true},
                    { data: 'category',title: 'Category'  , orderable: true,searchable: true},
                    { data: 'purchased_quantity',title: 'Purchased Qty', oderable: true},
                    { data: 'purchase_price',title: 'Rate'  , orderable: true,searchable: true},
                    { data: 'purchased_price',title: 'Total Purchase'  ,className:'sold', orderable: true,searchable: true},
                    { data: 'created_at',title: 'Created Date',orderable: true },
                ],
                "row": [],


                "order": [
                [ 0 ,"desc" ]
                ]
            });

            // dataTable.on( 'xhr', function () {
            //     var json = dataTable.ajax.json();
            //     document.getElementById('total_balance').innerHTML=("Total : " + json.total_balance);
            // });
            $('#list-purchase-table').on('draw.dt', function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('#tableData_paginate ul').addClass("pagination-sm");
                $('#tableData_info').addClass("p-0 my-auto");
            });


        }
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