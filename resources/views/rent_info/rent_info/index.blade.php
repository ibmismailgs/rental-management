@extends('layouts.main')
@section('title', 'Rent Info')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Rent Info </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Create Button" href="{{ route('rent-info.create') }}" type="button" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body">
                    <table id="data_table" class="table table-bordered table-striped data-table table-hover">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Issue Date </th>
                                <th>Rental Month</th>
                                <th>Owner Name</th>
                                <th>Tenant Name</th>
                                <th>Rent Title</th>
                                <th>Flat Name</th>
                                <th>Flat Rent</th>
                                <th>Total Rent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        $(document).ready( function () {

        var dTable = $('#data_table').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: false,
            serverSide: true,
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            ajax: {
                url: "{{route('rent-info.index')}}",
                type: "get"
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'issueDate', name: 'issueDate'},
                {data: 'rentalMonth', name: 'rentalMonth'},
                {data: 'owner_name', name: 'owner_name'},
                {data: 'tenant_name', name: 'tenant_name'},
                {data: 'rent_title', name: 'rent_title'},
                {data: 'flat_name', name: 'flat_name'},
                {data: 'flat_rent', name: 'flat_rent'},
                {data: 'total_rent', name: 'total_rent'},
                {data: 'action', searchable: false, orderable: false}
            ],
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: "Rent Info List",
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5,6,7,8'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: "Rent Info List",
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5,6,7,8'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: "Rent Info List",
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5,6,7,8'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: "Rent Info List",
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5,6,7,8'],
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn-sm btn-danger',
                                title: "Rent Info List",
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5,6,7,8'],
                                    stripHtml: false
                                }
                            }
                        ],
            });
        });

        $('#data_table').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();

                const url = $(this).data('remote');
                swal({
                        title: `Are you sure?`,
                        text: "Want to delete this record?",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
                    }).always(function (data) {
                        $('#data_table').DataTable().ajax.reload();
                        if (data.success === true) {
                            toastr.success(data.message, { positionClass: 'toast-bottom-full-width', });
                        }else{
                            toastr.error(data.message, { positionClass: 'toast-bottom-full-width', });
                        }
                    });
                }
                });
            });

    $('.card-body').on('click', '.deed', function (e) {
        e.preventDefault();
        var id = $(this).attr('getId');
            swal({
                title: `Are you sure ?`,
                text: `Want to close this deed?`,
                buttons: true,
                dangerMode: true,
            }).then((changeStatus) => {
        if (changeStatus) {
            $.ajax({
                'url':"{{ route('deed-close') }}",
                'type':'get',
                'dataType':'json',
                'data':{id:id},
                success:function(data)
                {
                    $('#data_table').DataTable().ajax.reload();
                    if (data.success == true) {
                        toastr.success(data.message, { positionClass: 'toast-bottom-full-width', });
                    }else{
                        toastr.error(data.message, { positionClass: 'toast-bottom-full-width', });
                    }
                }
            });
        }
        });
     })

    </script>
    <script>
        //  toastr.options.timeOut = 300;
        @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true,
            "timeOut" : 2000
        };

        toastr.success("{{ session('success') }}");
      @endif

     @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        };
        toastr.error("{{ session('error') }}");
     @endif
</script>
@endpush
@endsection
