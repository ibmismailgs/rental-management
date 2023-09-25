@extends('layouts.main')
@section('title', 'Flat Transaction Report')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Flat Transaction Report</h5>
                    </div>
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
                                <th>Date</th>
                                <th>Month</th>
                                <th>Purpose</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
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
        var url = $(this).attr('href');
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
            url: url,
            type: "get",
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'date', name: 'date'},
            {data: 'month', name: 'month'},
            {data: 'purpose', name: 'purpose'},
            {data: 'debit_amount', name: 'debit_amount'},
            {data: 'credit_amount', name: 'credit_amount'},
            {data: 'current_balance', name: 'current_balance'},
        ],
        dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                buttons: [
                        {
                            extend: 'copy',
                            className: 'btn-sm btn-info',
                            title: 'Flat Transactions',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ['0,1,2,3,4,5,6'],
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'btn-sm btn-success',
                            title: 'Flat Transactions',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ['0,1,2,3,4,5,6'],
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-dark',
                            title: 'Flat Transactions',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ['0,1,2,3,4,5,6'],
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'btn-sm btn-primary',
                            title: 'Flat Transactions',
                            pageSize: 'A2',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ['0,1,2,3,4,5,6'],
                            }
                        },
                        {
                            extend: 'print',
                            className: 'btn-sm btn-danger',
                            title: 'Flat Transactions',
                            pageSize: 'A2',
                            header: true,
                            footer: true,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ['0,1,2,3,4,5,6'],
                                stripHtml: false
                            }
                        }
                    ],
        });
    });

</script>
@endpush
@endsection
