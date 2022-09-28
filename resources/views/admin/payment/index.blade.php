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
                        <h4>List of Withdraw Request</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Withdraw</a> </li>
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
                    <div class="card-block">
                        <!-- <div class="row">
                            <div class="col-12" >
                                <a href="{{route('admin.manager.create')}}" class="btn btn-sm btn-primary float-right" style="margin-bottom:8px">Add Manager</a>
                            </div>
                        </div> -->
                        <div class="dt-responsive table-responsive">
                            <table id="list-payment-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                                <!-- <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Confirmed_by</th>
                                        <th>Confirmed_date</th>
                                        <th>Requested_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> -->
                         
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
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap4.min.js') }}"></script>
    <!-- Custom js -->
    <script src="{{ asset('js/datatables/data-table-custom.js') }}"></script>


<script>
        $(document).ready(function() {
            var dataTable = $('#list-payment-table').DataTable({
                "searching":true,
                "ordering":true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{!! route('payment.data') !!}",
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                    }
                },
                columns: [
                    {
                        data: 'id',title: "SN",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },

                    // { data: 'id', title: 'Id' },
                    { data: 'user_id', title: 'Name' , orderable: true,searchable: true},
                    { data: 'amount', title: 'Amount' , orderable: true,searchable: true},
                    { 
                        data: 'status', title: 'Status' , orderable: true,searchable: true,
                        render: function ( data, type, row ) {
                        if (data == "0") {
                            color = '#ff9900';
                            return '<span style="color:' + color + '">' + "Pending" +'</span>';
                        }
                        else if (data == "1") {
                            color = '#00cc00';
                            return '<span style="color:' + color + '">' + "Accepted" +'</span>';
                        }
                        else if (data == "2") {
                            color = 'red';
                            return '<span style="color:' + color + '">' + "Cancelled" +'</span>';
                        }
                        // return '<span style="color:' + color + '">' + data +'</span>';
                        }
                    },
                    { data: 'confirmed_by', title: 'Confirmed By' , orderable: true,searchable: true},
                    { data: 'confirmed_date', title: 'Confirmed Date' , orderable: true,searchable: true},
                    { data: 'created_at', title: 'Request At',orderable: true },
                    { data: 'action',title: 'Action' , orderable: false, searchable: false}
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