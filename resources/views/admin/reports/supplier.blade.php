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
                        <h4>List of Suppliers</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Supplier</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
                        <div class="table-responsive">
                            <table id="list-supplier-table" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
    
</div>

@foreach($supplier as $sup)

<div class="modal fade" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <input type="text" class="form-control" value="{{$sup->total}}">
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


    
@endsection
@section('scripts')
        <!-- data-table js -->
    <script src="{{url('/')}}/plugins/datatables/jquery.dataTables.js"></script>
    <script src="{{url('/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#list-supplier-table').DataTable({
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
                    "url": "{{route('supplier1.data')}}",
                    "dataType": "json",
                    "type": "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                    }
                },
                columns: [
                    { data: 'id', title: 'S.N' },
                    { data: 'name',title: 'Name' },
                    { data: 'total', title: 'Total' },
                    { data: 'paid', title: 'Paid' },
                    { data: 'due', title: 'Due' },
                    { data: 'created_at', title: 'Created' },
                    { data: 'action', title: 'Action'}
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