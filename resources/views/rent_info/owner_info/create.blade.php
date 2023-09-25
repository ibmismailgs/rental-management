@extends('layouts.main')
@section('title', 'Create Owner')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .dropify-wrapper .dropify-message p {
        font-size: initial;
    }
</style>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Create Owner </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('owner-info.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('owner-info.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_name">Owner Name<span class="text-red">*</span></label>

                                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" class="form-control @error('owner_name') is-invalid @enderror" placeholder="Enter owner name" required>

                                        @error('owner_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no">Phone<span class="text-red">*</span></label>
                                        <input type="text" id="contact_no" name="contact_no" value="{{ old('contact_no') }}"class="form-control @error('contact_no') is-invalid @enderror" placeholder="Enter contact no" required>

                                         @error('contact_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email<span class="text-red">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" required>

                                         @error('email')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender">Gender<span class="text-red">*</span></label>
                                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                            <option value="">Select Gender</option>
                                            <option value="1" @if (old('gender') == "1") {{ 'selected' }} @endif>Male</option>
                                            <option value="2" @if (old('gender') == "2") {{ 'selected' }} @endif>Female</option>
                                        </select>
                                        @error('gender')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea name="address" class="form-control" rows="5" placeholder="Write your address">{{ old('address') }}</textarea>

                                         @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_photo">Owner Photo<span class="text-red">*</span></label>
                                        <input type="file" name="owner_photo" id="owner_photo" data-height="105" class="dropify form-control @error('owner_photo') is-invalid @enderror" required>

                                        @error('owner_photo')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="card_name">Select Card Name<span class="text-red">*</span></label>
                                        <select name="card_name[]" id="card_name" class="form-control card_name @error('card_name') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            <option value="1" @if (old('card_name') == "1") {{ 'selected' }} @endif>NID</option>
                                            <option value="2" @if (old('card_name') == "2") {{ 'selected' }} @endif>Passport</option>
                                            <option value="3" @if (old('card_name') == "3") {{ 'selected' }} @endif>Birth Certificate</option>
                                            <option value="4" @if (old('card_name') == "4") {{ 'selected' }} @endif>Driving License</option>
                                        </select>

                                        @error('card_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="card_no">Identity Card No<span class="text-red">*</span></label>
                                        <input type="number" id="card_no" name="card_no[]" value="{{ old('card_no') }}" class="form-control @error('card_no') is-invalid @enderror" placeholder="Enter card number" required>

                                         @error('card_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="card_photo">Upload ID Card<span class="text-red">*</span></label>
                                        <div class="d-flex">
                                            <input type="file" name="card_photo[]" id="card_photo" class="form-control @error('card_photo') is-invalid @enderror" required>
                                            <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="add" id="add" class="btn btn-success">+</button>

                                            @error('card_photo')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  id="AddField">

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
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
            $('.dropify').dropify();
        });
</script>
<script>
        //field append
        var i = 1;
        $("#add").click(function () {
            if( i < 4 ){
            ++i;
            $("#AddField").append(`<div class="row" id="removed">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="card_name">Select Card Name<span class="text-red">*</span></label>
                        <select name="card_name[]" id="card_name" class="form-control card_name @error('card_name') is-invalid @enderror">
                            <option value="">Select Card</option>
                            <option value="1">NID</option>
                            <option value="2">Passport</option>
                            <option value="3">Birth Certificate</option>
                            <option value="4">Driving License</option>
                        </select>
                        @error('card_name')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="card_no">Identity Card No<span class="text-red">*</span></label>
                        <input type="number" id="card_no" name="card_no[]"  class="form-control @error('card_no') is-invalid @enderror" placeholder="Enter card no">
                        @error('card_no')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="card_photo">Upload ID Card<span class="text-red">*</span></label>
                        <div class="d-flex">
                            <input type="file" name="card_photo[]" id="card_photo" class="form-control @error('card_photo') is-invalid @enderror">
                            <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="del" id="del" class="btn btn-danger btn_remove">-</button>

                            @error('card_photo')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>`);
        }else{
            alert("You can not add more than 3 options");
        }
    });

        $(document).on('click', '.btn_remove', function() {
            $(this).parents('#removed').remove();
            i--;
        });

        // card type duplicate validation check
        $(document).on('click', 'select.card_name', function () {
        $('select[name*="card_name[]"] option').attr('disabled',false);
        $('select[name*="card_name[]"]').each(function(){
            var $this = $(this);
            $('select[name*="card_name[]"]').not($this).find('option').each(function(){
                if($(this).attr('value') == $this.val())
                $(this).attr('disabled',true);
            });
        });
        });

    </script>
    @endpush
@endsection
