@extends('admin.layouts.master')

@section('styles')
    <!-- Data Table Css -->
    <link rel="stylesheet" href="{{url('/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    
@endsection

@section('content')

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>List of Members</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a class="favicon" href="#!">Members</a> </li>
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
                            <div class="input-group col-md-3">
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
                        <div class="btn-group col-md-3" role="group">
                            <button type="button" 
                                        name="filter" 
                                        id="filter"
                                        class="btn btn-sm btn-primary btn-round">
                                    Filter
                                </button>

                            <button type="button" 
                                        name="refresh" 
                                        id="refresh" 
                                        class="btn btn-sm btn-warning btn-round">
                                    Refresh
                                </button>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="member-reports-table" class="table table-hover table-bordered ">
                                <thead class="table table-sm">
                                    <tr>
                                        <th>User_Id</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Remaining</th>
                                        <th>Reffered By</th>
                                        <th>Created Date</th>
<!--                                         <th>Action</th>
 -->                                    </tr>
                                </thead>

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
<!-- <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.html5.min.js') }}"></script>
<script src="{{url('/')}}/plugins/sum().js"></script> -->

<!-- <script>
        $(document).ready(function() {
            var dataTable = $('#member-reports-table').DataTable({
                "searching":true,
                "ordering":true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('member.reports') !!}",
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
            { data: 'address', name: 'address', title: 'Address'  , orderable: true,searchable: true},
            { data: 'phone', name: 'phone', title: 'Phone'  , orderable: true,searchable: true},
            { data: 'email', name: 'email', title: 'Email'  , orderable: true,searchable: true},
            { data: 'amount', name: 'amount', title: 'Amount'  , orderable: true,searchable: true},
            { data: 'remain', name: 'remain', title: 'Remaining'  , orderable: true,searchable: true},
            { data: 'refferal', name: 'refferal', title: 'Reffered By'  , orderable: true,searchable: true},
            {data: 'commission', title:'Commission'},
            { data: 'created_at', name: 'created_at', title: 'Date',orderable: true },
            { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
            });
        });
</script> -->

<script>
        $(document).ready(function() {
/*           var date = new Date();
*/
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
              autoclose: true
          });
              $('#filter').click(function(){
              var from_date = $('#from_date').val();
              var to_date = $('#to_date').val();

              if(from_date != '' &&  to_date != '')
              {
            $('#member-reports-table').DataTable().destroy();

                load_data(from_date, to_date);
             }
             else
             {
                 alert('Both Date is required');
             }
         });

            $('#refresh').click(function(){
             $('#from_date').val('');
              $('#to_date').val('');
         $('#member-reports-table').DataTable().destroy();

              load_data();
          });

           load_data();

           function load_data(from_date = '', to_date = '')
           {

           var dataTable = $('#member-reports-table').DataTable({
                "searching":true,
                "ordering":true,
                "processing": true,
                //  dom: 'Bfrtip',
                // buttons:[
                // "csvHtml5",
                // "excelHtml5",
                // "pdfHtml5",
                // "print",
                // 'colvis'
                // ],
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('member.reports') !!}",
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
                        orderable: false,
                        searchable: false
                    },
            { data: 'name', name: 'name', title: 'Name'  , orderable: true,searchable: true},
            { data: 'address', name: 'address', title: 'Address'  , orderable: true,searchable: true},
            { data: 'phone', name: 'phone', title: 'Phone'  , orderable: true,searchable: true},
            { data: 'email', name: 'email', title: 'Email'  , orderable: true,searchable: true},
            { data: 'deposit', name: 'deposit', title: 'Deposit'  , orderable: true,searchable: true},
            { data: 'remaining', name: 'remaining', title: 'Remaining'  , orderable: true,searchable: true},
            { data: 'ref_user_id', name: 'refferal', title: 'Reffered By'  , orderable: true,searchable: true},
            { data: 'created_at', name: 'created_at', title: 'Date',orderable: true },
            // { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                  
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
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