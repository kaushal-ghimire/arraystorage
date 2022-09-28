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
                        <h4>List of Suppliers</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Suppliers</a> </li>
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
                                <li><button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addCatModal">Add Supplier</button></li>
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-12" >
                                <!-- <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary float-right" style="margin-bottom:8px">Add Category</a> -->

                                



                                <!-- add Category model -->
                                
                                <div class="modal fade" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add new supplier</h5>
                                        <button type="button" class="close" data-dismiss="modal" a ria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                        <form method="POST" action="{{route('supplier.store')}}" enctype="multipart/form-data">

                                        @csrf
                                        @method('post')
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Name:</label>
                                            <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="business_id" class="col-form-label">Business Id:</label>
                                            <input type="text" class="form-control" name="business" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-form-label">Phone:</label>
                                            <input type="text" class="form-control" name="phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-form-label">Address:</label>
                                            <input type="text" class="form-control" name="address" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pan" class="col-form-label">PAN:</label>
                                            <input type="text" class="form-control" name="pan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="date" class="col-form-label">Date:</label>
                                            <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger m-b-0" data-dismiss="modal">Close</button>
                                        <button id="btnAdd" type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end -->
                    @foreach($suppliers as $sup)

<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="POST" action="{{route('supplier.store')}}" enctype="multipart/form-data" novalidate="">
                                        @csrf
                                        @method('post')
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Name:</label>
                                            <input oninput="this.value = this.value.toUpperCase()"  type="text" class="form-control" value="{{$sup->name}}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="total" class="col-form-label">Total:</label>
                                            <input type="text" class="form-control" value="{{$sup->total1}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="paid" class="col-form-label">Paid:</label>
                                            <input type="text" class="form-control" value="{{$sup->paid}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="due" class="col-form-label">Due:</label>
                                            <input type="text" class="form-control" value="{{$sup->due}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="amount" class="col-form-label">Payable Amount:</label>
                                            <input type="text" class="form-control" placeholder="{{$sup->due}}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger m-b-0" data-dismiss="modal">Close</button>
                                        <button id="btnAdd" type="submit" class="btn btn-primary">Pay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endforeach

                    <!-- end -->



                </div>
            </div>
            <div class="dt-responsive table-responsive">
                <table id="list-supplier-table" class="table table-hover table-bordered table-responsive-sm" style="width: 100%">
                    <thead class="table-sm">
                        <tr >
                            <th >SN</th>
                            <th>Name</th>
                            <th>Business Id</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>PAN</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="8" class="text-sm-right text-primary" >
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
            var dataTable = $('#list-supplier-table').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };

                    var Total = api
                    .column(7)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $(api.column(7).footer()).html('Total : '+ Total);
                },
                "searching":true,
                "ordering":true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('supplier.data') !!}",
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
            { data: 'name', name: 'name', title: 'Name'  , orderable: true,searchable: true},
            { data: 'business_id', name: 'business_id', title: 'Business Id'  , orderable: true,searchable: true},
            { data: 'phone', name: 'phone', title: 'Phone'  , orderable: true,searchable: true},
            { data: 'address', name: 'address', title: 'Address'  , orderable: true,searchable: true},
            { data: 'pan', name: 'pan', title: 'PAN'  , orderable: true,searchable: true},
            { data: 'date', name: 'date', title: 'Date'  , orderable: true,searchable: true},
            { data: 'total', name: 'total', title: 'Total'  , orderable: true,searchable: true},
            // { data: 'paid', name: 'paid', title: 'Paid'  , orderable: true,searchable: true},
            { data: 'created_at', name: 'created_at', title: 'Created Date',orderable: true },
            { data: 'action', name: 'action', orderable: false, searchable: false}
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