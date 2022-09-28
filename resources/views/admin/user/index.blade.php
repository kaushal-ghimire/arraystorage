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
                        <h4>List of Users</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{route('user.dashboard')}}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Users</a> </li>
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
                        <h5>Showing List of User</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary float-right">Add User
                                </a></li>
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-12">
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="list-users-table" class="table table-hover table-bordered nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Created Date</th>
                                        <th style="width: 60%">Action</th>
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
            var dataTable = $('#list-users-table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "{!! route('admin.user.data') !!}",
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
                    { data: 'name', name: 'name', title: 'Name' },
                    { data: 'address', name: 'address', title: 'Address' },
                    { data: 'email', name: 'email', title: 'Email' },
                    { data: 'created_at', name: 'created_at', title: 'Created Date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false,width:"70%"}
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