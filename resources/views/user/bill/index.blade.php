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
                        <h4>List of Bills</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="feather icon-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Bills</a> </li>
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
                                <li><button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addCatModal">Add bill</button></li>
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-12" >

                            </div>
                        </div>
            <div class="dt-responsive table-responsive">
                <table id="list-bill-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Bill ID</th>
                            <th>Total Amount</th>
                            <th>Purchased Date</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th colspan="3" class="text-sm-right text-primary" >
                               
                            </th>

                            <th></th>

                        </tr>
                    </tfoot> -->
                    
                </table>

            </div>
            
        </div>
    </div>
</div>
</div>
</div>
</div>

  <!-- add Bill model -->
                                
                  <div class="modal fade" id="addCatModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add new Bill</h5>
                                    <button type="button" class="close" data-dismiss="modal" a ria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                           </div>
                      <div class="modal-body">
                          <form method="POST" action="{{route('bill.store')}}" enctype="multipart/form-data">

                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="bill" class="col-form-label">Bill Id:</label>
                                <input type="text" class="form-control" name="bill"  required>
                            </div>
                            <input type="hidden" class="form-control" id="supid" value="{{$id}}" name="supid">

                            <div class="form-group">
                                <label for="purchase" class="col-form-label">Purchased Date:</label>
                                <input type="date" name="purchase" id="date-picker" placeholder="Select Date" value="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger m-b-0" data-dismiss="modal">Close</button>
                                <button id="btnAdd" type="submit" class="btn btn-primary">Add</button>
                                 </form>
                            </div>
                   
                        </div>
                </div>
                </div>

                </div>

                    <!-- end -->


     <!-- edit Bill model -->
                                
     <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="example">Edit new Bill</h5>
            <button type="button" class="close" data-dismiss="modal" a ria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('update.bill')}}" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="form-group">
                <label for="bill" class="col-form-label">Bill Id:</label>
                <input type="text" class="form-control" id="bill" name="bill" required>
            </div>
            <input type="hidden" class="form-control" id="billid"  name="billid">
            <input type="hidden" class="form-control" id="sid"  name="suppliers_id">

            <div class="form-group">
                <label for="purchase" class="col-form-label">Purchased Date:</label>
                <input type="date" value="" name="purchase" class="date-picker" id="pdate" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger m-b-0" data-dismiss="modal">Close</button>
                <button id="btnAdd" type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>

                    <!-- end -->


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
        var dataTable = $('#list-bill-table').DataTable({
            "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };

                    var Total = api
                    .column(2)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $(api.column(2).footer()).html('Total : '+ Total);
                },
            "searching":true,
            "ordering":true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "{!! route('bill.data') !!}",
                type: "POST",

              data: {
                        'id' : {{
                            $id
                        }},
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')},
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
            { data: 'bill', name: 'bill', title: 'Bill Id'  , orderable: true,searchable: true},
            { data: 'total', name: 'total', title: 'Total Amount'  , orderable: true,searchable: true},
            { data: 'purchase', name: 'purchase', title: 'Purchased Date'  , orderable: true,searchable: true},
            { data: 'created_at', name: 'created_at', title: 'Created Date',orderable: true },
            { data: 'action', name: 'action', title: 'Action', orderable: false, searchable: false}
            ],
            lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'All']
            ],
        });
        // dataTable.on( 'xhr', function () {
        //         var json = dataTable.ajax.json();
        //         document.getElementById('total_balance').innerHTML=("Total : " + json.total_balance);
        //     });
    });
</script>

<script>

    $(document).on('click','.btnDelete', function (event) {
        event.preventDefault();

        var btn=$(this);
        var bill_id= btn.data('bill_id');
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
                        'data_id' : bill_id
                    },
                    success: function(response){

                        Swal.fire({
                            title: response.alerted,
                            text: response.message,
                            icon: response.type,
                            showCancelButton: true,
                            cancelButtonColor: '#d33',
                        }).then((result) => {
                            $('#list-bill-table').DataTable().ajax.reload();
                        });
                    }
                });

            }
        })

    });
</script>
<script>
$('#editModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id= button.data('bill_id');
        var billid = button.data('bill');
        var pdate = button.data('pdate');
        var suppid = button.data('suppliers_id');
        // console.log(suppliers_id);

  var modal = $(this);

                modal.find('.modal-body #sid').val(suppid);
                modal.find('.modal-body #bill').val(billid);
                modal.find('.modal-body #billid').val(id);
                modal.find('.modal-body #pdate').val(pdate);

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