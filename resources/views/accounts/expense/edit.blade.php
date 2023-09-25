@extends('layouts.main')
@section('title', 'Edit Expense')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<style>
    .ui-datepicker-calendar {
        display: none;
    }
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
                        <h5>Edit Expense</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('expense.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('expense.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Date<span class="text-red">*</span></label>
                                        <input type="date" id="date" name="date" value="{{ $data->date }}"class="form-control @error('date') is-invalid @enderror" placeholder="Enter month" required>

                                        @error('date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_info_id">Owner name<span class="text-red">*</span></label>
                                        @if ($user_role->name == 'Super Admin')
                                        <select name="owner_info_id" id="owner_info_id" class="form-control @error('owner_info_id') is-invalid @enderror" required>
                                            <option value="">Select Owner</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}" @if($owner->id == $data->owner_info_id) selected @endif >{{ $owner->owner_name }}</option>
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
                                        <label for="flat_info_id">Flat Name<span class="text-red">*</span></label>

                                        @if ($user_role->name == 'Super Admin')
                                        <select name="flat_info_id" id="flat_info_id"  class="form-control @error('flat_info_id') is-invalid @enderror" required>
                                            <option value="">Select flat</option>
                                            @foreach ($flats as $flat)
                                                <option daining_space="{{ $flat->daining_space }}" balcony="{{$flat->balcony}}" bathroom="{{  $flat->bathroom}}" guest_bedroom="{{ $flat->guest_bedroom }}" master_bedroom="{{ $flat->master_bedroom }}" bedrooom="{{ $flat->bedroom }}" flat_size="{{ $flat->flat_size }}" value="{{ $flat->id }}" @if($flat->id == $data->flat_info_id) selected @endif>{{ $flat->flat_name }}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <select name="flat_info_id" id="flat_info" class="form-control flat_info_id @error('flat_info_id') is-invalid @enderror" required>
                                                <option value="">Select flat</option>
                                            @foreach ($flats as $key => $flat)
                                                @if ($flat->owner_info_id == Auth::user()->owners->id)
                                                <option value="{{ $flat->id }}" @if($flat->id == $data->flat_info_id ) selected @endif>{{  $flat->flat_name }} </option>
                                            @endif
                                        @endforeach
                                        </select>
                                     @endif

                                         @error('flat_info_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method<span class="text-red">*</span></label>
                                        <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                            <option value="">Select Method</option>
                                            <option value="1" @if ($data->payment_method == 1) selected @endif >Cash</option>
                                            <option value="2" @if ($data->payment_method == 2) selected @endif>Bank </option>
                                            <option value="3" @if ($data->payment_method == 3) selected @endif>Mobile Banking</option>
                                        </select>
                                        @error('payment_method')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                </div>

                                @php
                                    $expenseAmount = json_decode($data->amount);
                                    $total_amount = array_sum($expenseAmount);
                                    $expenseCategories = json_decode($data->expense_category_id);
                                @endphp

                                 @foreach( $expenseCategories as $key => $value )
                                 <div class="row row_del">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <label for="expense_category_id">Expense Category<span class="text-red">*</span></label>
                                    <select name="expense_category_id[]" id="expense_category_id" class="form-control @error('expense_category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if($category->id == $value) selected @endif> {{ $category->category_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('expense_category_id')
                                    <span class="text-danger" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="amount">Expense Amount<span class="text-red">*</span><span class="text-primary" id="cashBalance" > </span></label>
                                    <div class="d-flex">
                                        <input type="number" id="amount" onkeyup="Amount(1)" name="amount[]" value="{{ $expenseAmount[$key] }}" class="form-control amount @error('amount') is-invalid @enderror" placeholder="Enter expense amount" required>
                                         @if ($key == 0)
                                                <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="add" id="add" class="btn btn-success">+</button>
                                            @else
                                                <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="row_remove" id="row_remove" class="btn btn-danger row_remove">-</button>
                                        @endif
                                    </div>

                                     @error('amount')
                                    <span class="text-danger" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            </div>
                            @endforeach

                            <div id="AddField">

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_amount">Total Amount</label>
                                        <input type="text" id="total_amount" name="total_amount" class="form-control total_amount" value="{{ $total_amount }}" readonly>
                                        <input type="hidden" name="cash_amount" class="form-control" id="cash_amount" readonly>
                                        <input type="hidden" id="bankAmount" name="bank_amount" class="form-control bank_amount" readonly>
                                        <input type="hidden" id="mobileAmount" name="mobile_amount" class="form-control mobile_amount" readonly>
                                    </div>
                                </div>

                            <div class="col-sm-6" id="transaction_id">
                                <div class="form-group">
                                    <label for="mobile_transaction_id">Transaction ID<span class="text-red">*</span></label>

                                    <input type="text" id="mobile_transaction_id" name="mobile_transaction_id" value="{{ $data->mobile_transaction_id }}"class="form-control @error('mobile_transaction_id') is-invalid @enderror" placeholder="Enter transaction id">

                                        @error('mobile_transaction_id')
                                    <span class="text-danger" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-sm-6" id="bank_account">
                                <div class="form-group">
                                    <label for="account_id">Account Name<span class="text-red">*</span> <span class="text-primary" style="display: none" id="bank_amount"></span></label>

                                    <select name="account_id" id="account_id" class="form-control ownerBankAccount @error('account_id ') is-invalid @enderror">
                                        <option value="">Select account</option>
                                           @foreach ($banks as $key => $bank)
                                                @if($bank->owner_info_id == $data->owner_info_id)
                                                    <option value="{{ $bank->id }}" @if($bank->id == $data->account_id) selected @endif> {{ $bank->banks->bank_name }} || {{ $bank->owners->owner_name }} || {{ $bank->account_no }}</option>
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

                            <div class="col-sm-6" id="mobile_account">
                                <div class="form-group">
                                    <label for="mobile_banking_id">Mobile Banking Account<span class="text-red">*</span><span class="text-primary" id="mobile_amount" style="display: none"></span></label>

                                    <select name="mobile_banking_id" id="mobile_banking_id"  class="form-control ownerMobileAccount @error('mobile_banking_id') is-invalid @enderror">
                                        <option value="">Select account</option>
                                            @foreach ($mobilebanks as $key => $mobilebank)
                                                @if($mobilebank->owner_info_id == $data->owner_info_id)
                                                    <option value="{{ $mobilebank->id }}" @if($mobilebank->id == $data->mobile_banking_id) selected @endif>{{ $mobilebank->mobileBankings->name }} || {{ $mobilebank->owners->owner_name }} || {{ $mobilebank->mobile_no }}</option>
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
                                <button type="submit" class="btn btn-success mr-2 create">Update</button>
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var payment_method = $("#payment_method").val();
        if (payment_method == 1) {
            $("#mobile_account").hide();
            $("#transaction_id").hide();
            $("#bank_account").hide();
            $("#cashBalance").show();
        }else if(payment_method == 2){
            $("#bank_account").show();
            $("#cashBalance").hide();
            $("#mobile_account").hide();
            $("#transaction_id").hide();
        }else if(payment_method == 3){
            $("#cashBalance").hide();
            $("#mobile_account").show();
            $("#transaction_id").show();
            $("#bank_account").hide();
        }

        var url = "{{route('current-balance')}}";
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'Json',
                data: {
                    payment_method: payment_method,
                },
                 success: function(data) {
                    if(payment_method == 1){
                      $("#cashBalance").append(data.CurrentCashBalance);
                      $('#cash_amount').val(data.CurrentCashBalance);
                      $("#mobile_account").hide();
                      $("#transaction_id").hide();
                      $("#bank_account").hide();
                    }
                }
            })


    $("#payment_method").on('change', function(){
        var payment_method = $("#payment_method").val();
        if ($(this).val() == 1) {
            $("#mobile_account").hide();
            $("#transaction_id").hide();
            $("#bank_account").hide();
            $("#cashBalance").show();
        }else if($(this).val() == 2){
            $("#bank_account").show();
            $("#cashBalance").hide();
            $("#mobile_account").hide();
            $("#transaction_id").hide();
        }else if($(this).val() == 3){
            $("#cashBalance").hide();
            $("#mobile_account").show();
            $("#transaction_id").show();
            $("#bank_account").hide();
        }

        var url = "{{route('current-balance')}}";
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'Json',
                data: {
                    payment_method: payment_method,
                },
                 success: function(data) {
                    if(payment_method == 1){
                      $("#cashBalance").append(data.CurrentCashBalance);
                      $('#cash_amount').val(data.CurrentCashBalance);
                      $("#mobile_account").hide();
                      $("#transaction_id").hide();
                      $("#bank_account").hide();
                    }
                }
            })
    });

    //field append
    var length = $('#expense_category_id > option').length;
    var max = length - 1;
    var i = 1;
    $("#add").click(function () {
        if( i < max ){
        ++i;
        $("#AddField").append(`<div class="row" id="removed">
        <div class="col-sm-6">
            <div class="form-group">
            <label for="expense_category_id">Expense Category<span class="text-red">*</span></label>
            <select name="expense_category_id[]" id="expense_category_id" class="form-control @error('expense_category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $category->id }}" > {{ $category->category_name }} </option>
                @endforeach
            </select>
            @error('expense_category_id')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="amount">Expense Amount<span class="text-red">*</span></label>
            <div class="d-flex">
                <input type="number" id="amount" onkeyup="Amount(${i})" name="amount[]" value="{{ old('amount') }} " class="form-control amount @error('amount') is-invalid @enderror" placeholder="Enter expense amount" required>
                <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="add" id="add" class="btn btn-danger btn_remove">-</button>
            </div>
            @error('amount')
                <span class="text-danger" role="alert">
                    <p>{{ $message }}</p>
                </span>
            @enderror
        </div>
    </div>`);

    }else{
        alert("You can not add more than your categories option");
        }
    });

    $(document).on('click', '.btn_remove', function() {
        $(this).parents('#removed').remove();
        i--;
        var sum = 0;
            $('.amount').each(function(){
                sum += parseFloat(this.value);
            })
        $('#total_amount').val(sum);
    })

    $(document).on("input", ".amount", function() {
        var sum = 0;
        $(".amount").each(function(){
            sum += parseFloat(this.value);
        });
        $("#total_amount").val(sum);
    });

$("#owner_info_id").on('change', function(e){
        e.preventDefault();
    var owner_id= $('#owner_info_id').val();
    $.ajax({
        url: "{{ route('ownerwise-flat-tenant') }}",
        type: "GET",
        data: {
            'owner_id':owner_id,
        },
        success: function(data){
            $('#flat_info_id').empty();
            $('.ownerBankAccount').empty();
            $('.ownerMobileAccount').empty();
            $('#flat_info_id').append("<option value=''>Select flat</option>");
            $('.ownerBankAccount').append("<option value=''>Select Account</option>");
            $('.ownerMobileAccount').append("<option value=''>Select Account</option>");

            $.each(data.Expenseflats, function(key, flat){
                $('#flat_info_id').append(`<option value="${flat.id}">${flat.flat_name}</option>`);
            });

            $.each(data.bankAccounts, function(key, bankAccount){
                    $('.ownerBankAccount').append(`<option value="${bankAccount.id}">${bankAccount.banks.bank_name + '&nbsp;||&nbsp;' + bankAccount.owners.owner_name + '&nbsp;||&nbsp;' + bankAccount.account_no}</option>`);
                });

                $.each(data.mobileAccounts, function(key, mobileAccount) {
                    $('.ownerMobileAccount').append(`<option value="${mobileAccount.id}">${mobileAccount.mobile_bankings.name + '&nbsp;||&nbsp;' + mobileAccount.owners.owner_name + '&nbsp;||&nbsp;' + mobileAccount.mobile_no}</option>`);
                });
        },
    });
});

//category option validation check
$(document).on('click', 'select#expense_category_id', function () {
    $('select[name*="expense_category_id[]"] option').attr('disabled',false);
    $('select[name*="expense_category_id[]"]').each(function(){
        var $this = $(this);
        $('select[name*="expense_category_id[]"]').not($this).find('option').each(function(){
            if($(this).attr('value') == $this.val())
            $(this).attr('disabled',true);
        });
    });
    });

    var account_id = $("#account_id").val();
    var mobile_banking_id = $("#mobile_banking_id").val();

    $("#cashBalance").empty();
    $("#cash_amount").val(0);
    $("#bank_amount").empty();
    $("#bankAmount").val(0);
    $("#mobile_amount").empty();
    $("#mobileAmount").val(0);

    var url = "{{route('current-balance')}}";
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'Json',
            data: {
                account_id: account_id,
                mobile_banking_id: mobile_banking_id,
            },
                success: function(data) {
                if(payment_method == 2){
                    $("#bank_account").show();
                    $("#bank_amount").show();
                    $("#cashBalance").hide();
                    $("#bankAmount").val(data.CurrentBankAmount);
                    $("#bank_amount").append(data.CurrentBankAmount);
                }else if (payment_method == 3){
                    $("#cashBalance").hide();
                    $("#mobile_account").show();
                    $("#mobile_amount").show();
                    $("#transaction_id").show();
                    $("#mobileAmount").val(data.CurrentMobileBalance);
                    $("#mobile_amount").append(data.CurrentMobileBalance);
                }
        }
    })

//bank account current balance
$("#account_id, #mobile_banking_id").on('change', function(e){
        e.preventDefault();

    var account_id = $("#account_id").val();
    var mobile_banking_id = $("#mobile_banking_id").val();
    var payment_method = $("#payment_method").val();

    $("#cashBalance").empty();
    $("#cash_amount").val(0);
    $("#bank_amount").empty();
    $("#bankAmount").val(0);
    $("#mobile_amount").empty();
    $("#mobileAmount").val(0);

    var url = "{{route('current-balance')}}";
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'Json',
        data: {
            account_id: account_id,
            mobile_banking_id: mobile_banking_id,
        },
            success: function(data) {
            if(payment_method == 2){
                $("#bank_account").show();
                $("#bank_amount").show();
                $("#cashBalance").hide();
                $("#bankAmount").val(data.CurrentBankAmount);
                $("#bank_amount").append(data.CurrentBankAmount);
            }else if (payment_method == 3){
                $("#cashBalance").hide();
                $("#mobile_account").show();
                $("#mobile_amount").show();
                $("#transaction_id").show();
                $("#mobileAmount").val(data.CurrentMobileBalance);
                $("#mobile_amount").append(data.CurrentMobileBalance);
            }
        }
    })
})

function Amount(id){
    var bankAmount= parseFloat($('#bank_amount').html());
    var mobileAmount = parseFloat($('#mobile_amount').html());
    var totalAmount= parseFloat($('#total_amount').val());
    var cashBalance = parseFloat($('#cashBalance').html());

    // amount validation
    if( cashBalance < totalAmount){
        swal({
                title: `Alert!!!`,
                text: "You don't have sufficient balance",
                buttons: true,
                dangerMode: true,
            }).then((errorMessage) => {
                if (errorMessage) {
                    $('.amount').val(0);
                    $('#total_amount').val(0);
                }
            });
        }

    if(bankAmount < totalAmount){
        swal({
                title: `Alert!!!`,
                text: "You don't have sufficient balance",
                buttons: true,
                dangerMode: true,
            }).then((errorMessage) => {
                if (errorMessage) {
                    $('.amount').val(0);
                    $('#total_amount').val(0);
                }
            });
        }

    if(mobileAmount < totalAmount){
        swal({
                title: `Alert!!!`,
                text: "You don't have sufficient balance",
                buttons: true,
                dangerMode: true,
            }).then((errorMessage) => {
                if (errorMessage) {
                    $('.amount').val(0);
                    $('#total_amount').val(0);
                }
            });
        }
    }
</script>
 @endpush
@endsection
