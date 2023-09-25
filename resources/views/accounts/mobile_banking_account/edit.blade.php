@extends('layouts.main')
@section('title', 'Edit Mobile Banking Account')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Edit Mobile Banking Account </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('mobile-banking-account.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('mobile-banking-account.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_banking_id">Mobile Banking<span class="text-red">*</span></label>
                                        <select name="mobile_banking_id" id="mobile_banking_id" class="form-control @error('mobile_banking_id') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            @foreach ($mobileBankings as $key => $mobileBanking)
                                                <option value="{{ $mobileBanking->id }}" @if($mobileBanking->id == $data->mobile_banking_id) selected @endif> {{ $mobileBanking->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('mobile_banking_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="holder_name">Account Holer Name<span class="text-red">*</span></label>

                                        @if ($user_role->name == 'Super Admin')
                                        <select name="owner_info_id" id="owner_info_id" class="form-control @error('owner_info_id') is-invalid @enderror" required>
                                            <option value="">Select Owner</option>
                                            @foreach ($owners as $key => $owner)
                                                <option value="{{ $owner->id }}" @if($owner->id == $data->owner_info_id) selected @endif> {{ $owner->owner_name }} </option>
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
                                        <label for="mobile_no">Mobile No<span class="text-red">*</span></label>
                                        <input type="text" id="mobile_no" name="mobile_no" value="{{  $data->mobile_no }}"class="form-control @error('mobile_no') is-invalid @enderror" placeholder="Enter mobile no" required>

                                         @error('mobile_no')
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
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
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
