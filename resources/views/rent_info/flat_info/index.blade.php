@extends('layouts.main')
@section('title', 'Flat Info')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/toggle.css') }}">
<style>
    .swal-title{
        font-size: 17px;
        color: red;
        padding: 0;
    }
    .swal-text{
        margin-top: 5px !important;
        color: black;
        background-color: white;
        box-shadow: none;
    }
    .swal-modal{
        max-width: 299px ;
            /* width: auto !important; */
            padding-top: 1px;
            margin-top: 1px;
            padding: 1px 1px;
            vertical-align: top;
        }
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >List of Flats </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Create" href="{{ route('flat-info.create') }}" type="button" class="btn btn-sm btn-success">
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
                                <th>Flat Owner</th>
                                <th>Flat Name</th>
                                <th>Flat Space</th>
                                <th>Total Room</th>
                                <th>Status</th>
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
                url: "{{route('flat-info.index')}}",
                type: "get"
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'owner_name', name: 'owner_name'},
                {data: 'flat_name', name: 'flat_name'},
                {data: 'flat_size', name: 'flat_size'},
                {data: 'total_bedroom', name: 'total_bedroom'},
                {data: 'status', name: 'status'},
                {data: 'action', searchable: false, orderable: false}
            ],
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Flat List',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Flat List',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Flat List',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Flat List',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn-sm btn-danger',
                                title: 'Flat List',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ['0,1,2,3,4'],
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

        $('.card-body').on('click', '.changeStatus', function (e) {
            e.preventDefault();
            var id = $(this).attr('getId');
                swal({
                    title: `Are you sure?`,
                    text: `Want to change this status?`,
                    buttons: true,
                    dangerMode: true,
                }).then((changeStatus) => {
            if (changeStatus) {
                $.ajax({
                    'url':"{{ route('flat-status') }}",
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
