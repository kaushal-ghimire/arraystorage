@extends('admin.layouts.master')

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
                        <h4>Member Reports</h4>
                        <span>/Member</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Member</a> </li>
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
                            <div class="form-outline col-md">
                                <input type="search" id="form1" class="form-control" placeholder="Search" aria-label="Search" />
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
                                <button type="button" 
                                        name="filter" 
                                        id="filter"
                                        class="btn btn-sm btn-primary btn-round">Filter</button>
                                <button type="button" name="refresh" id="refresh"
                                class="btn btn-sm btn-warning btn-round">Refresh</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="list-member-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Remaining</th>
                                        <th>Refferal</th>
                                        <th>Membership Date</th>
                                    </tr>
                                </thead>

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

            $('#from_date').datepicker({
                todayBtn:'linked',
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true,

            });
            $('#to_date').datepicker({
                todayBtn:'linked',
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true,
            });

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != '')
                {
                    $('#list-member-table').DataTable().destroy();

                    load_data(from_date, to_date);
                }
                else
                {
                    alert('Both Date is required');
                }
            });


            load_data();

            function load_data(from_date = '', to_date = '')
            {
                var dataTable = $('#list-member-table').DataTable({
                    "searching":true,
                    "ordering":true,
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "{!! route('member.data') !!}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'from_date': from_date,
                            'to_date': to_date
                        }
                    },
                    columns: [
                    {
                        title: "SN",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: true,
                        searchable: false,
                    },
                    { data: 'name', title: 'Name', orderable: true, searchable: true},
                    { data: 'address', title: 'Address', orderable: false, searchable: true},
                    { data: 'phone', title: 'Phone', orderable: true, searchable: true},
                    { data: 'email', title: 'Email', orderable: true,searchable: false},
                    { data: 'amount', title: 'Amount', orderable: true, searchable: false},
                    { data: 'remain', title: 'Remaining'orderable: false, searchable: false},
                    { data: 'refferal', title: 'Refferal'orderable: false, searchable: false},
                    { data: 'created_at', title: 'Membership Date', orderable: true,searchable: false },
                    ],
                    lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                    ],
                });

            }
                $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#list-member-table').DataTable().destroy();

                load_data();
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