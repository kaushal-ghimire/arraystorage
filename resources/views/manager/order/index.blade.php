@extends('manager.layouts.master')

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
                        <h4>List of Orders</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{route('manager.dashboard')}}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Orders</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
                        <div class="table-responsive">
                            <table id="list-order-table" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Bill_Id</th>
                                        <th>Total</th>
                                        <th>Dis</th>
                                        <th>Grand_Total</th>
                                        <th>Ordered</th>
                                        <th>Received</th>
                                        <th>Del.Location</th>
                                        <th>Active</th>
                                        <th class="text-primary">Confirmation</th>
                                        <th>Created</th>
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
            var dataTable = $('#list-order-table').DataTable({
                "searching" : true,
                "processing": true,
                 // "stateSave": true,
                dom: 'Bfrtip',
                
                "language": {
                    processing: 'Please Wait...',
                    searchPlaceholder: "Search"
                },
                "serverSide": true,
                "keys": true,
                "pagingType": "full_numbers",
                "ajax":{
                    "url": "{{route('order.data')}}",
                    "dataType": "json",
                    "type": "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                    }
                },
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'bill_id',title: 'Bill_Id' },
                    { data: 'total', title: 'Total' },
                    { data: 'discount', title: 'Dis.' },
                    { data: 'grand_total', title: 'Grand_Total' },
                    { data: 'date', title: 'Ordered Date' },
                    { data: 'received', title: 'Received' },
                    {data: 'delivery_location', title:'Del.Location'},
                    { data: 'is_active', title: 'Status' },
                    { 
                      data: 'is_confirmed',title: 'Confirmation',className:'sold', orderable: true,searchable: true,
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
                    { data: 'created_by', title: 'Created By' },
                    // { data: 'created_at', title: 'Date' },
                    { data: 'action', title: 'Action'}
                ],
                
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
            });
        });
    </script>
    <!-- <script>
$(function(){
    $('#status').editable({
        value: 2,    
        source: [
              {value: 0, text: 'Pending'},
              {value: 1, text: 'Approved'},
           ]
    });
});
</script> -->

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