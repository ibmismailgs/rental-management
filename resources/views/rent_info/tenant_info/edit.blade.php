@extends('layouts.main')
@section('title', 'Edit Tenant')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

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
                        <h5 class="pt-10" >Edit Tenant </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('tenant-info.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('tenant-info.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_name">Owner Name<span class="text-red">*</span></label>

                                        @if ($user_role->name == 'Super Admin')
                                            <select name="owner_info_id" id="owner_info_id" class="form-control @error('owner_info_id') is-invalid @enderror" required>
                                                <option value="">Select Owner</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}" @if($owner->id ==   $data->owner_info_id) selected @endif >{{ $owner->owner_name }}</option>
                                            @endforeach
                                            </select>

                                        @else

                                            <input type="hidden" name="owner_info_id" value="{{ Auth::user()->owners->id }}">

                                            <input type="text" id="owner_info_id" value="{{ Auth::user()->name }}"class="form-control @error('owner_info_id') is-invalid @enderror" placeholder="Enter flat name" readonly>

                                        @endif

                                        @error('owner_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tenant_name">Tenant Name<span class="text-red">*</span></label>
                                        <input type="text" name="tenant_name" id="tenant_name" value="{{ $data->tenant_name }}" class="form-control @error('tenant_name') is-invalid @enderror" placeholder="Enter tenant name" required>

                                        @error('tenant_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no">Phone<span class="text-red">*</span></label>
                                        <input type="text" id="contact_no" name="contact_no" value="{{ $data->contact_no }}"class="form-control @error('contact_no') is-invalid @enderror" placeholder="Enter contact no" required>

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
                                        <input type="email" id="email" name="email" value="{{ $data->email }}"class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" required>

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
                                            <option value="1" {{ $data->gender == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $data->gender == 2 ? 'selected' : '' }}>Female</option>
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
                                        <label for="family_member">Family Members<span class="text-red">*</span></label>
                                        <input type="text" name="family_member" id="family_member" value="{{ $data->family_member }}" class="form-control @error('family_member') is-invalid @enderror" placeholder="Enter total family member" required>

                                         @error('family_member')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea name="address" class="form-control" rows="5" placeholder="Write your address">{{ $data->address }}</textarea>

                                         @error('address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tenant_photo">Tenant Photo<span class="text-red">*</span></label>
                                        <input type="file" name="tenant_photo" id="tenant_photo" data-height="105" @if ($data) data-default-file="{{ asset('img/' . $data->tenant_photo) }}" @endif class="dropify form-control @error('tenant_photo') is-invalid @enderror">

                                        @error('tenant_photo')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            @php
                                $cardName = json_decode($data->card_name);
                                $cardNumber = json_decode($data->card_no);
                                $cardPhoto = json_decode($data->card_photo);
                            @endphp

                            @foreach($cardName as $key => $value )
                            <div class="row row_del">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="card_name">Select Card Name<span class="text-red">*</span></label>
                                        <select name="card_name[]" id="card_name" class="form-control card_name @error('card_name') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            <option value="1" @if($cardName[$key] == 1 ) selected @endif>NID</option>
                                            <option value="2" @if($cardName[$key]  == 2 ) selected @endif>Passport</option>
                                            <option value="3" @if($cardName[$key]  == 3 ) selected @endif>Birth Certificate</option>
                                            <option value="4" @if($cardName[$key]  == 4 ) selected @endif>Driving License</option>
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
                                        <label for="card_no">Identiy Card No<span class="text-red">*</span></label>

                                        <input type="number" id="card_no" name="card_no[]" value="{{ $cardNumber[$key] }}" class="form-control @error('card_no') is-invalid @enderror" placeholder="Enter card number" required>

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
                                            <input type="file" name="card_photo[]" id="card_photo" value="" class="form-control @error('card_photo') is-invalid @enderror">
                                            <input type="hidden" name="old_card_photo[]" id="" value= "{{ $cardPhoto[$key] }}"/>
                                            @error('card_photo')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                            @if ($key == 0)
                                                <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="add" id="add" class="btn btn-success">+</button>
                                            @else
                                                <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="row_remove" id="row_remove" class="btn btn-danger row_remove">-</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div  id="AddField">

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
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
            $('.dropify').dropify();
        });
</script>
<script>
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
                        <label for="card_no">Identiy Card No<span class="text-red">*</span></label>
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

        $(document).on('click', '.row_remove', function(e) {
            e.preventDefault();
                swal({
                    title: `Are you sure?`,
                    text: `Want to remove this?`,
                    buttons: true,
                    dangerMode: true,
                }).then((data) => {
                    if (data == true) {
                    $(this).parents('.row_del').remove();
                }
                else {
                    return false;
                }
            });
         })

    </script>
    @endpush
@endsection
