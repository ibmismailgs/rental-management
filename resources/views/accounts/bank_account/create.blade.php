@extends('layouts.main')
@section('title', 'Create Bank Account')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Create Bank Account </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('bank-account.index') }}" type="button" class="btn btn-sm btn-dark">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form enctype="multipart/form-data" action="{{ route('bank-account.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Date<span class="text-red">*</span></label>
                                        <input type="date" id="date" name="date" value="{{ old('date') }}"class="form-control @error('date') is-invalid @enderror" placeholder="Enter date" required>

                                         @error('date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_banking_id">Bank Name<span class="text-red">*</span></label>
                                        <select name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror" required>
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $key => $bank)
                                                <option value="{{ $bank->id }}" > {{ $bank->bank_name }} </option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_info_id">Account Name<span class="text-red">*</span></label>

                                        @if ($user_role->name == 'Super Admin')
                                          <select name="owner_info_id" id="owner_info_id" class="form-control @error('owner_info_id') is-invalid @enderror" required>
                                            <option value="">Select Owner</option>
                                            @foreach ($owners as $key => $owner)
                                                <option value="{{ $owner->id }}" > {{ $owner->owner_name }} </option>
                                            @endforeach
                                            </select>
                                        @else

                                    <input type="hidden" name="owner_info_id" value="{{ Auth::user()->owners->id }}">

                                    <input type="text" id="owner_info_id" value="{{ Auth::user()->name }}"class="form-control @error('owner_info_id') is-invalid @enderror" readonly>

                                    @endif


                                    @error('owner_info_id')
                                    <span class="text-danger" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                    @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account_no">Account No<span class="text-red">*</span></label>
                                        <input type="text" id="account_no" name="account_no" value="{{ old('account_no') }}"class="form-control @error('account_no') is-invalid @enderror" placeholder="Enter account no" required>

                                         @error('account_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if (old('status') == "1") {{ 'selected' }} @endif>Active</option>
                                            <option value="0" @if (old('status') == "0") {{ 'selected' }} @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="branch_name">Branch Name<span class="text-red">*</span></label>
                                        <input type="text" id="branch_name" name="branch_name" value="{{ old('branch_name') }}"class="form-control @error('branch_name') is-invalid @enderror" placeholder="Enter branch name" required>

                                         @error('branch_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="branch_address">Address<span class="text-red">*</span></label>
                                        <textarea name="branch_address" class="form-control" rows="2" placeholder="Write branch address">{{ old('branch_address') }}</textarea>

                                         @error('branch_address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
