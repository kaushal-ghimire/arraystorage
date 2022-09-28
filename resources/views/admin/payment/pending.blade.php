@extends('admin.layouts.master')

@section('styles')
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/responsive.bootstrap4.min.css') }}">
    <style type="text/css">
    .sold {
        background-color: #eeccff;
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
                        <h4>List of Pending Payments</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Payment</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
                        <div class="table-responsive">
                            <table id="pending-payment-table" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User_Id</th>
                                        <th>Amount</th>
                                        <th class="text-primary">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
    
</div>
                       <!-- Confirmation fieldset start -->
                            <!-- <h3> Confirmation </h3>
                            <div class="confirmation">
                                <div class="row">
                                    <div class="col-md-6 offset-md-1">

                                        @csrf
                                        @method('post') 
                                            <button type="submit" id="btn" onclick= "return confirm('You Want to Approve?')" class="btn btn-success">Confirm Order</button>

                                        </form>
                                    </div>
                                </div>
                                
                            </div> -->
                            <!-- Confirmation fieldset start -->

    
@endsection
@section('scripts')
        <!-- data-table js -->
    <script src="{{url('/')}}/plugins/datatables/jquery.dataTables.js"></script>
    <script src="{{url('/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#pending-payment-table').DataTable({
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
                    "url": "{{route('pending.data')}}",
                    "dataType": "json",
                    "type": "POST",
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
                    { data: 'action',title: 'Action' , orderable: false, searchable: false}
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