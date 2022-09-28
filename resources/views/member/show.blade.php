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
                        
                       <h4>Members </h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Members</a> </li>
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
                               <!--  <input type="search" id="form2" class="form-control" placeholder="Search by Member" aria-label="Search" /> -->
                               <h5 > Members of : <strong class="text-success" >{{$member}}</strong></h5>

                            </div>
                            
                            <!-- <div class="input-group col-md">
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
                                
                                <button type="button" name="refresh" id="refresh" class="btn btn-sm btn-primary btn-round">Refresh</button>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="list-showmember-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>User_Id</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Remaining</th>
                                        <th>Created Date</th>
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
 


</div>
    

@endsection

@section('scripts')
<script src="{{url('/')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{url('/')}}/plugins/sum().js"></script> -->

<script>
        $(document).ready(function() {
            var dataTable = $('#list-showmember-table').DataTable({
                "searching":true,
                "ordering":true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('member.show.data') !!}",
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'memberid': {{ $memberid }}
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
            { data: 'user_id', name: 'name', title: 'Name'  , orderable: true,searchable: true},
            { data: 'address', name: 'address', title: 'Address'  , orderable: true,searchable: true},
            { data: 'phone', name: 'phone', title: 'Phone'  , orderable: true,searchable: true},
            { data: 'email', name: 'email', title: 'Email'  , orderable: true,searchable: true},
            { data: 'deposit', name: 'deposit', title: 'Amount'  , orderable: true,searchable: true},
            { data: 'remaining', name: 'remaining', title: 'Remaining'  , orderable: true,searchable: true},
            { data: 'created_at', name: 'created_at', title: 'Date',orderable: true },
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