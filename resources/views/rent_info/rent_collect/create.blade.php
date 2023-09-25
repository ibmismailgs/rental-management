@extends('layouts.main')
@section('title', 'Create Rent Collect')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .dropify-wrapper .dropify-message p {
        font-size: initial;
    }
    .checkmark {
        /* position: absolute; */
        height: 30px;
        width: 30px;
        background-color: #eee;
    }

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
        font-size: 13px;
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

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-user bg-blue"></i>
                    <div class="d-inline">
                        <h5>Create Rent Collect</h5>
                    </div>
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
                        <form enctype="multipart/form-data" action="{{ route('rent-collect.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="owner_info_id">Owner name</label>
                                        <input type="hidden" name="rent_info_id" id="id" value="{{ $data->id }}">
                                        <input type="hidden" name="owner_info_id" id="id" value="{{ $data->owners->id }}">

                                        <input type="hidden" name="transaction_purpose" value="1">
                                        <input type="text" id="owner_info_id" value="{{ $data->owners->owner_name ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tenant_info_id">Tenant Name</label>
                                        <input type="hidden" name="tenant_info_id" id="id" value="{{ $data->tenants->id }}">
                                        <input type="text" id="tenant_info_id" value="{{ $data->tenants->tenant_name ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="flat_info_id">Flat Name</label>
                                        <input type="hidden" name="flat_info_id" id="id" value="{{ $data->flats->id }}">
                                        <input type="text" id="flat_info_id" value="{{ $data->flats->flat_name ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="rent_title">Rent Title</label>
                                        <input type="text" id="rent_title" value="{{ $data->rent_title ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="flat_rent">Flat Rent</label>
                                        <input type="text" id="flat_rent" name="flat_rent" value="{{ $data->flat_rent ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="gas_bill">Gas Bill</label>
                                        <input type="text" id="gas_bill" name="gas_bill" value="{{ $data->gas_bill ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="water_bill">Water Bill</label>
                                        <input type="text" id="water_bill" name="water_bill" value="{{ $data->water_bill ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="service_charge">Service Charge</label>
                                        <input type="text" id="service_charge" name="service_charge" value="{{ $data->service_charge ?? '--' }}" class="form-control rent" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="total_rent">Total Rent</label>
                                        <input type="text" id="total_rent" name="total_rent" value="{{ $data->total_rent ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="rental_month">Rental Month<span class="text-red">*</span></label>

                                        <input type="month" id="rental_month" name="rental_month" value="{{ old('rental_month') }}"class="form-control datepicker @error('rental_month') is-invalid @enderror" placeholder="Enter month" required>
                                        <input type="hidden" id="CurrentMonth" value="{{ date('Y-m') }}">
                                         @error('rental_month')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="receive_amount">Receive Amount<span class="text-red">*</span></label>

                                        <input type="text" id="receive_amount" name="receive_amount" value="{{ old('receive_amount') }}"class="form-control @error('address') is-invalid @enderror" placeholder="Enter receive amount" required>

                                         @error('receive_amount')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="due_amount">Due Amount</label>
                                        <input type="text" id="due_amount" name="due_amount" value="{{ $data->total_rent ?? '--' }}" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method<span class="text-red">*</span></label>
                                        <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                            <option value="">Select Method</option>
                                            <option value="1">Cash</option>
                                            <option value="2">Bank </option>
                                            <option value="3">Mobile Banking</option>
                                        </select>
                                        @error('payment_method')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4" id="transaction_id">
                                    <div class="form-group">
                                        <label for="mobile_transaction_id">Transaction ID<span class="text-red">*</span></label>

                                        <input type="text" id="mobile_transaction_id" name="mobile_transaction_id" value="{{ old('mobile_transaction_id') }}"class="form-control @error('mobile_transaction_id') is-invalid @enderror" placeholder="Enter transaction id">

                                         @error('mobile_transaction_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4" id="bank_account">
                                    <div class="form-group">
                                        <label for="account_id ">Account Name<span class="text-red">*</span></label>

                                        <select name="account_id" id="account_id"  class="form-control @error('account_id ') is-invalid @enderror">
                                            <option value="">Select account</option>
                                            @foreach ($banks as $key => $bank)
                                                @if($bank->owner_info_id == $data->owner_info_id)
                                                    <option value="{{ $bank->id }}" > {{ $bank->banks->bank_name }} || {{ $bank->owners->owner_name ?? '--'}} || {{ $bank->account_no }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                         @error('account_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4" id="mobile_account">
                                    <div class="form-group">
                                        <label for="mobile_banking_id">Mobile Banking Account<span class="text-red">*</span></label>

                                        <select name="mobile_banking_id" id="mobile_banking_id" class="form-control @error('mobile_banking_id') is-invalid @enderror">
                                            <option value="">Select account</option>
                                                @foreach ($mobilebanks as $key => $mobilebank)
                                                    @if($mobilebank->owner_info_id == $data->owner_info_id)
                                                        <option value="{{ $mobilebank->id }}" >{{ $mobilebank->mobileBankings->name }} || {{ $mobilebank->owners->owner_name }} || {{ $mobilebank->mobile_no }} </option>
                                                    @endif
                                                @endforeach
                                        </select>
                                         @error('mobile_banking_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2 create">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("#bank_account").hide();
    $("#mobile_account").hide();
    $("#transaction_id").hide();


    $("#mobile_banking_id").on('click', function(){
        var mobile_banking_id = $("#mobile_banking_id").val();
        var m = $(this).val();
        if (m < 0 ) {
            swal({
                title: `Alert!!!`,
                text: "Please create account first",
                buttons: true,
                dangerMode: true,
            });
        }
    });


    $("#account_id").on('click', function(){
        var account_id = $("#account_id").val();
        var m = $(this).val();
        if (m < 0 ) {
            swal({
                title: `Alert!!!`,
                text: "Please create account first",
                buttons: true,
                dangerMode: true,
            });
        }
    });

    $("#payment_method").on('change', function(){
        if ($(this).val() == 2) {
            $("#bank_account").show();
            $("#mobile_account").hide();
            $("#transaction_id").hide();
        }else if($(this).val() == 3){
            $("#mobile_account").show();
            $("#transaction_id").show();
            $("#bank_account").hide();
        }else{
            $("#bank_account").hide();
            $("#mobile_account").hide();
            $("#transaction_id").hide();
        }
    });

    //dropify
    $('.dropify').dropify();
    // total rent calculate
    $("#receive_amount").on('input', function(){
    total_rent =  parseFloat($('#total_rent').val());
    due_amount =  parseFloat($('#due_amount').val());
    receive_amount =  parseFloat($('#receive_amount').val());

    let total = total_rent - receive_amount;
    $('#due_amount').val(total);

    //rent amount validation
    if(receive_amount > total_rent){
        swal({
                title: `Alert!!!`,
                text: "Receive amount is more than total rent",
                buttons: true,
                dangerMode: true,
            }).then((errorMessage) => {
                if (errorMessage) {
                    $('#receive_amount').val(0);
                    $('#due_amount').val(0);
                }
            });
      }

    })

    $('#rental_month').on('change',function(event){
        event.preventDefault();
        var rental_month = $("#rental_month").val();
        var id = $("#id").val();

        var month = $("#CurrentMonth").val();
        if(rental_month > month){
            swal({
                title: 'Error!!!',
                text: "Select current month or less than current month",
                dangerMode: true,
            });
            $('#rental_month').val('null');
        }

        $.ajax({
            url: "{{ route('rent-check') }}",
            type:"get",
            data:{
                'rental_month':rental_month,
                'id':id,
            },
            success: function(result){
                if(result.success == true){
                swal({
                    title: `Alert!!!`,
                    text: result.message,
                    buttons: true,
                    dangerMode: true,
                }).then((errorMessage) => {
                    if (errorMessage) {
                        $('#rental_month').val(null);
                    }
                });
            }
        }
        });
    })

</script>
@endpush
@endsection
