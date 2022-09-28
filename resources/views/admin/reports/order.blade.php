@extends('admin.layouts.master')

@section('styles')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/flatpicker.min.css') }}">
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        <h5>Ordered cart</h5>
    </div>
    <div class="card-block">
        <div class="row">

            <div class="col-md-12">
                <div id="wizard">
                    <section>
                            <!-- Shopping cart field et start -->
                            <h3> Order details </h3>
                            <div class="col-xs-6">
                            <input type="text" name="datetime" id="datetime" placeholder="Choose a Date"/>
                            <div class="btn-group py-2" role="group">
                                <button type="button" name="refresh" id="refresh" class="btn btn-sm btn-primary btn-round">Refresh</button>
                            </div>
                        </div>
                            <fieldset>

                             <div class="dt-responsive table-responsive">

                                <table id="show-order-table" class="table table-hover table-bordered dt-responsive nowrap" style="width: 100%">
                                   <!--  <thead>
                                        <tr>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80px;">Cart_Id</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 125px;">Category</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Subcategory</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 125px;">P-Name</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 20px;">Qty</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Rate</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Amount</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Created Date</th>
                                        </tr>
                                    </thead> -->
                                </table>
                              </div>
                            </fieldset>
                            <!-- Delivery Details fieldset start -->

                            <!-- Confirmation fieldset start -->
                    </section>
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
    <script src="{{asset ('js/flatpicker.min.js') }}"></script>
    <!-- Custom js -->
    <script src="{{ asset('js/datatables/data-table-custom.js') }}"></script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#show-order-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{!! route('confirmorder.data') !!}",
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
                    },
                    { data: 'id', title: 'Order_Id' },
                    { data: 'bill_id',title: 'Bill' },
                    { data: 'total', title: 'Total' },
                    { data: 'discount', title: 'Dis.' },
                    { data: 'grand_total', title: 'Grand_Total' },
                    { data: 'date', title: 'Ordered Date' },
                    { data: 'received', title: 'Received' },
                    { data: 'is_active', title: 'Status' },
                    { 
                      data: 'is_confirmed',title: 'Confirmation', orderable: true,searchable: true,
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
                    { data: 'created_at', title: 'Date' },
                ],
            });
            $('#refresh').click(function(){
            $('#datetime').val('');
            // load_data(date_select);
        });
            // var dataTable = $('#list-daybook-table').DataTable({

            //     "processing": true,
            //     "serverSide": true,
            //     "ajax": {
            //         url: "{!! route('daybook.data') !!}",
            //         type: "POST",
            //         headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //         data: {
            //             '_token': '{{ csrf_token() }}',
            //         }
            //     },
            //     columns: [
            //         { data: 'name', title: 'Product', orderable: true,searchable: false},

            //         { data: 'purchased_price', title: 'Total Purchase', orderable: true,searchable: false},
            //         { data: 'sold_price', name: 'sold_price', title: 'Total Sales', oderable: true,searchable: false},
            //         { data: 'margin_amt', title: 'Total Margin'  , orderable: true,searchable: false},

            //     ],

            // });
        });    
    </script>
    <script>
flatpickr("#datetime", {

   dateFormat: "Y-m-d",
    maxDate: "today",

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

