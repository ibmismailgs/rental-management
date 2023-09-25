@extends('layouts.main')
@section('title', 'Bank account Deatils')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline">
                        <h5>Bank account Deatils</h5>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <button onclick="window.print()" class="btn btn-sm btn-primary">
                        <i class="fas fa-print mr-1"></i>
                        Print
                    </button>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="row">
        @include('include.message')
        <div class="col-md-12">
            <div class="card p-3">
                <div id="printTable" class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <tbody>
                            <tr>
                                <td width="25%">Date</td>
                                <td width="75%">{{ Carbon\Carbon::parse($data->date)->format('d F, Y') ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Bank Name</td>
                                <td width="75%">{{ $data->banks->bank_name ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Account Name</td>
                                <td width="75%">{{ $data->owners->owner_name ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Account No</td>
                                <td width="75%">{{ $data->account_no ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Branch Name</td>
                                <td width="75%">{{ $data->branch_name ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td width="25%">Branch Address</td>
                                <td width="75%"><p>{{ $data->branch_address ?? '--' }}</p></td>
                            </tr>
                            <tr>
                                <td width="25%">Create By</td>
                                @php
                                    $user = DB::table('users')->where('id', $data->created_by)->first();
                                @endphp
                                <td width="75%">{{ $user->name }}</td>
                            </tr>
                            {{-- <tr>
                                <td width="25%">Created</td>
                                <td width="75%">{{ $data->created_at ?? '--' }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
