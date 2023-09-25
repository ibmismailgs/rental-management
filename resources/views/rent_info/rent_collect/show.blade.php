@extends('layouts.main')
@section('title', 'Rent Collect Deatils')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Rent Collect Details</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('rent-collect.index') }}" type="button" class="btn btn-sm btn-dark">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                    <a title="Create Button" href="{{ route('rent-info.index') }}" type="button" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @include('include.message')
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body">

                    <table id="data_table" class="table table-bordered table-striped data-table table-hover">
                        <tbody>
                            <tr>
                                <td width="30%">Date</td>
                                <td>{{ Carbon\Carbon::parse($data->created_at)->format('d F, Y') ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td width="30%">Month</td>
                                <td>{{ Carbon\Carbon::parse($data->rental_month)->format('F-Y') ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Owner Name</td>
                                <td>{{ $data->owners->owner_name ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Tenant Name</td>
                                <td>{{ $data->tenants->tenant_name ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Flat Name</td>
                                <td>{{ $data->flats->flat_name ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Rent Title</td>
                                <td>{{ $data->rents->rent_title ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Gas Bill</td>
                                <td>{{ $data->rents->gas_bill ?? '--' }} Tk</td>
                            </tr>

                            <tr>
                                <td>Water Bill</td>
                                <td>{{ $data->rents->water_bill ?? '--' }} Tk</td>
                            </tr>

                            <tr>
                                <td>Service Charge</td>
                                <td>{{ $data->rents->service_charge ?? '--' }} Tk</td>
                            </tr>

                            <tr>
                                <td>Flat Rent</td>
                                <td>{{ $data->rents->flat_rent ?? '--' }} Tk</td>
                            </tr>

                            <tr>
                                <td>Total Rent</td>
                                <td>{{ $data->rents->total_rent ?? '--' }} Tk</td>
                            </tr>

                            <tr>
                                <td>Receive Rent</td>
                                <td>{{ json_decode($data->amount) ?? '--' }} Tk</td>
                            </tr>

                            <tr>
                                <td>Total Received</td>
                                <td>{{ $totalAmount ?? '--' }} Tk</td>
                            </tr>

                            @if ($due> 0)
                            <tr>
                                <td>Due Rent</td>
                                <td>{{ $due ?? '--' }} Tk</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
