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
                        <h4>List of Categories</h4>
                        <span>Listing all categories</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Categories</a> </li>
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
                        <h5>Showing List of Categories</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addCatModal">Add</button></li>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data" novalidate="">
                                        @csrf
                                        @method('post')
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Name:</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="image" class="col-form-label">Image:</label>
                                            <input type="file" class="form-control" name="image">
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



                </div>
            </div>
            <div class="dt-responsive table-responsive">
                <table id="list-category-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Created Date</th>
                            <th>Action</th>
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
        var dataTable = $('#list-category-table').DataTable({
            "searching":true,
            "ordering":true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "{!! route('category.data') !!}",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              
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
            { data: 'image' , name: 'name', title: 'Image', orderable: true,searchable: true},
            { data: 'created_at', name: 'created_at', title: 'Created Date',orderable: true,searchable:true},
            { data: 'action', name: 'action',title:'Action',orderable: false, searchable: false}
            ],
            lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
            ],
        });
    });
</script>
<!-- <script>

    $(document).on('click','.btnDelete', function (event) {
        event.preventDefault();

        var btn=$(this);
        var category_id= btn.data('category_id');
        var url= btn.data('href');
        console.log(url);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'data_id' : category_id
                    },
                    success: function(response){

                        Swal.fire({
                            title: response.alerted,
                            text: response.message,
                            icon: response.type,
                            showCancelButton: true,
                            cancelButtonColor: '#d33',
                        }).then((result) => {
                            $('#list-category-table').DataTable().ajax.reload();
                        });
                    }
                });

            }
        })

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