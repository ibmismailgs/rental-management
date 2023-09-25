@extends('layouts.main')
@section('title', 'Expense Deatils')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Expense Details</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('expense.index') }}" type="button" class="btn btn-sm btn-dark">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                    <a title="Create Button" href="{{ route('expense.create') }}" type="button" class="btn btn-sm btn-success">
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
                                <td>{{ Carbon\Carbon::parse($data->date)->format('d F, Y') ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Owner Name</td>
                                <td>{{ $data->owners->owner_name ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Flat Name</td>
                                <td>{{ $data->flats->flat_name ?? '--' }}</td>
                            </tr>

                            @php
                                $expenseAmount = json_decode($data->amount);
                                $total_amount = array_sum($expenseAmount);
                                $categories = json_decode($data->expense_category_id);
                            @endphp

                            <tr>
                                <td width="50%">Expense Categories / Amount</td>

                                <td width="50%" style="word-break: break-word;">

                                    @foreach ($categories as $key => $value)
                                            @foreach ($expenseCategories as $expenseCategorie)
                                                @if($expenseCategorie->id == $value)
                                                <span>{{ $expenseCategorie->category_name }} => </span>
                                                @endif
                                            @endforeach
                                            <span>{{ $expenseAmount[$key] }},<br></span>
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td>Total Amount</td>
                                <td>{{ $total_amount ?? '--' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
