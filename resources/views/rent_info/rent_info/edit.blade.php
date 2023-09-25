@extends('layouts.main')
@section('title', 'Edit Rent')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

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
</style>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Edit Rent </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('rent-info.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('rent-info.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tenant_photo">Tenant Photo</label>

                                        <input type="file" name="tenant_photo" id="tenant_photo" data-height="100" @if ($data) data-default-file="{{ asset('img/' . $data->tenant_photo) }}" @endif class="dropify form-control @error('tenant_photo') is-invalid @enderror">

                                        @error('tenant_photo')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-4">
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

                                    <div class="form-group">
                                        <label for="flat_size">Flat Size</label>
                                        <input type="text" value="{{ $data->flats->flat_size }}" id="flat_size" name="flat_size" class="form-control" readonly>
                                    </div>

                                </div>

                                <div class="col-sm-4">
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

                                    <div class="form-group">
                                        <label for="rent_title">Rent Title<span class="text-red">*</span></label>
                                        <input type="text" id="rent_title" name="rent_title" value="{{ $data->rent_title }}"class="form-control @error('address') is-invalid @enderror" readonly>

                                         @error('rent_title')
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
                                        <label for="bedroom">Bedroom</label>
                                        <input type="number" value="{{ $data->flats->bedroom }}" id="bedroom" name="bedroom"  class="form-control bed " readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="bathroom">Bathroom</label>
                                        <input type="number" value="{{ $data->flats->bathroom }}" id="bathroom" name="bathroom" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="master_bedroom">Master Bedroom</label>
                                        <input type="number" value="{{ $data->flats->master_bedroom }}" id="master_bedroom" name="master_bedroom" class="form-control bed" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="guest_bedroom">Guest Bedroom</label>
                                        <input type="number" value="{{ $data->flats->guest_bedroom }}" id="guest_bedroom" name="guest_bedroom" class="form-control bed" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="balcony">Balcony</label>
                                        <input type="number" value="{{ $data->flats->balcony }}" id="balcony" name="balcony" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                          <p id="daining_space" ><label for="daining_space">Dining Space </label> <b>:</b> <br>
                                            @if($data->flats->daining_space == 1)
                                                <span for="yes" class="ml-10 badge badge-success" title="Dainig Space" id="yes">Yes</span>
                                                <span style="display: none" class="ml-10 badge badge-danger" title="Dainig Space" id="no">No</span>
                                            @elseif($data->flats->daining_space == 0)
                                            <span style="display: none" for="yes" class="ml-10 badge badge-success" title="Dainig Space" id="yes">Yes</span>
                                              <span class="ml-10 badge badge-danger" title="Dainig Space" id="no">No</span>
                                            @endif
                                          </p>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="total_room">Total Room</label>
                                        <input type="text" id="total_room" value="{{ $totalRoom ?? '--' }}" class="form-control "  readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="flat_rent">Flat Rent<span class="text-red">*</span></label>
                                        <input type="number" id="flat_rent" name="flat_rent" value="{{ $data->flat_rent }}"class="form-control rent @error('rent') is-invalid @enderror" placeholder="Enter flat rent" required>

                                         @error('flat_rent')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="gas_bill">Gas Bill<span class="text-red">*</span></label>
                                        <input type="number" id="gas_bill" name="gas_bill" value="{{ $data->gas_bill }}"class="form-control rent @error('gas_bill') is-invalid @enderror" placeholder="Enter gas bill" required>

                                         @error('gas_bill')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="water_bill">Water Bill<span class="text-red">*</span></label>
                                        <input type="number" id="water_bill" name="water_bill" value="{{ $data->water_bill }}"class="form-control rent @error('water_bill') is-invalid @enderror" placeholder="Enter water bill" required>

                                         @error('water_bill')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="service_charge">Service Charge<span class="text-red">*</span></label>
                                        <input type="number" id="service_charge" name="service_charge" value="{{ $data->service_charge  }}"class="form-control rent @error('service_charge') is-invalid @enderror" placeholder="Enter service charge" required>

                                         @error('service_charge')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="total_rent">Total Rent<span class="text-red">*</span></label>
                                        <input type="text" id="total_rent" name="total_rent" value="{{ $data->total_rent }}"class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tenant_info_id">Tenant Name<span class="text-red">*</span></label>

                                        @if ($user_role->name == 'Super Admin')

                                        <select name="tenant_info_id" id="tenant_info_id"  class="form-control @error('tenant_info_id') is-invalid @enderror" required>
                                            <option value="">Select tenant</option>
                                            @foreach ($tenants as $tenant)
                                                <option value="{{ $tenant->id }}" @if($tenant->id ==   $data->tenant_info_id) selected @endif >{{ $tenant->tenant_name }}</option>
                                            @endforeach
                                        </select>

                                            @else
                                            <select name="tenant_info_id" id="tenant_info_id" class="form-control @error('tenant_info_id') is-invalid @enderror" required>
                                                <option value="">Select tenant</option>
                                                @foreach ($tenants as $key => $tenant)
                                                @if ($tenant->owner_info_id == Auth::user()->owners->id)
                                                <option value="{{ $tenant->id }}" @if($tenant->id ==   $data->tenant_info_id) selected @endif >{{ $tenant->tenant_name }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        @endif

                                         @error('tenant_info_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="father_name">Father Name<span class="text-red">*</span></label>
                                        <input type="text" name="father_name" value="{{ $data->father_name }}" id="father_name" placeholder="Enter father name" class="form-control @error('father_name') is-invalid @enderror" >

                                        @error('father_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    <label for="district">District<span class="text-red">*</span></label>
                                    <input type="text" name="district" class="form-control" value="{{ $data->district }}" id="district" placeholder="Enter district" required>
                                  </div>
                                  </div>

                                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <label for="thana">Thana<span class="text-red">*</span></label>
                                    <input type="text" name="thana"  value="{{ $data->thana }}" class="form-control" id="thana" placeholder="Enter thana" required>
                                  </div>
                                  </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="holding">Holding<span class="text-red">*</span></label>
                                            <input type="text" name="holding" class="form-control" value="{{ $data->holding }}" id="holding" placeholder="Enter holding" required>
                                          </div>
                                         @error('holding')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="road" col-form-label">Road</label>
                                        <input type="text" name="road" value="{{ $data->road }}" class="form-control" id="road" placeholder="Enter road">
                                         @error('road')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="post_code">Post Code<span class="text-red">*</span></label>
                                        <input type="text" value="{{ $data->post_code }}" name="post_code" class="form-control" id="post_code" placeholder="Enter post code">
                                         @error('post_code')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tenant_info_id">Date Of Birth<span class="text-red">*</span></label>

                                        <input type="date" name="birthdate" value="{{ $data->birthdate }}" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" >


                                         @error('birthdate')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="merital_status">Merital Status<span class="text-red">*</span></label>
                                        <select name="merital_status" id="merital_status"  class="form-control @error('merital_status') is-invalid @enderror" required>
                                            <option value="">Select </option>
                                            <option value="1" {{ $data->merital_status == 1 ? 'selected' : '' }}>Married</option>
                                            <option value="2" {{ $data->merital_status == 2 ? 'selected' : '' }}>Unmarried</option>
                                            </select>

                                         @error('merital_status')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="religion">Religion<span class="text-red">*</span></label>
                                        <select name="religion" id="religion"  class="form-control @error('religion') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            <option value="1" {{ $data->religion == 1 ? 'selected' : '' }}>Islam</option>
                                            <option value="2" {{ $data->religion == 2 ? 'selected' : '' }}>Hindu</option>
                                            <option value="3" {{ $data->religion == 3 ? 'selected' : '' }}>Buddhist</option>
                                            <option value="4" {{ $data->religion == 4 ? 'selected' : '' }}>Christian</option>
                                            <option value="5" {{ $data->religion == 5 ? 'selected' : '' }}>Others</option>
                                        </select>

                                         @error('religion')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="gender">Gender<span class="text-red">*</span></label>
                                        <input type="hidden" name="gender" >
                                        <input type="text" id="genderName" class="form-control @error('gender') is-invalid @enderror" readonly>
                                        @error('gender')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tenant_mobile">Mobile<span class="text-red">*</span></label>
                                        <input type="text" id="tenantMobile" name="tenant_mobile" value="{{ $data->tenants->contact_no }}"class="form-control @error('mobile') is-invalid @enderror" readonly>

                                         @error('tenant_mobile')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email<span class="text-red">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ $data->tenants->email }}" class="form-control @error('email') is-invalid @enderror" readonly>

                                         @error('email')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tenant_nid">Tenant NID<span class="text-red">*</span></label>
                                        <input type="number" id="tenantNid" value="{{ $data->tenant_nid }}" name="tenant_nid"  class="form-control" placeholder="Enter nid no">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="passport">Passport</label>
                                        <input type="text" id="passport" value="{{ $data->passport }}" name="passport"  class="form-control" placeholder="Enter passport">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="qualification">Educational Qualification<span class="text-red">*</span></label>
                                        <input type="text" value="{{ $data->qualification }}" id="qualification" name="qualification" class="form-control" placeholder="Enter eduactional qualification">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="profession">Profession<span class="text-red">*</span></label>
                                        <input type="text" id="profession" name="profession" value="{{ $data->profession }}" placeholder="Enter profession" class="form-control @error('address') is-invalid @enderror" >

                                         @error('profession')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="professional_address">Work Place Address</label>
                                        <textarea name="professional_address" class="form-control" rows="3" placeholder="Write professional address">{{ $data->professional_address }}</textarea>

                                         @error('professional_address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="permanent_address">Permanent Address<span class="text-red">*</span></label>
                                        <textarea name="permanent_address" id="permanent_address" class="form-control" rows="3" readonly>{{ $data->tenants->address }}</textarea>

                                         @error('permanent_address')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-sm-12 mb-2">
                                        <b>Emergency Contact</b>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="emergency_name">Name<span class="text-red">*</span></label>
                                            <input type="text" value="{{ $data->emergency_name }}" name="emergency_name" class="form-control" id="emergency_name" placeholder="Enter name" required>
                                        </div>
                                    </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="relation">Relation<span class="text-red">*</span></label>
                                        <input type="text" value="{{ $data->relation }}" id="relation" name="relation" class="form-control" placeholder="Enter relation" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="emergency_mobile">Mobile<span class="text-red">*</span></label>
                                        <input type="text" id="emergency_mobile" name="emergency_mobile" value="{{ $data->emergency_mobile }}" class="form-control" placeholder="Enter mobile no" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="emergency_address">Address<span class="text-red">*</span></label>
                                        <textarea name="emergency_address" class="form-control" rows="1" placeholder="Write your address">{{ $data->emergency_address }}</textarea>
                                    </div>
                                </div>
                            </div>

                            @php
                                $memberName = json_decode($data->member_name);
                                $memberAge = json_decode($data->member_age);
                                $memberProfession = json_decode($data->member_profession);
                                $memberMobile = json_decode($data->member_mobile);
                            @endphp

                            <span>
                                <div class="row col-sm-12 mb-2">
                                    <b>Family Member Details</b>
                                </div>
                                @foreach($memberName as $key => $name)
                                <div class="row row_del">

                                    <div class="col-sm-1 ">
                                        <div class="form-group">
                                            <label for="sn">SN</label>
                                            <input type="text" id="sn{{ $key }}" name="sn[]" value="{{ $key+1 }}" class="form-control sn @error('sn') is-invalid @enderror" readonly>

                                            @error('sn')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="member_name">Name</label>
                                            <input type="text" id="member_name" name="member_name[]" value="{{ $name ?? '--' }}" class="form-control @error('member_name') is-invalid @enderror" placeholder="Enter name" >

                                            @error('member_name')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="member_age">Age</label>
                                            <input type="text" id="member_age" name="member_age[]" value="{{ $memberAge[$key] ?? '--' }}" class="form-control @error('member_age') is-invalid @enderror" placeholder="Enter age" >

                                            @error('member_age')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="member_profession">Profession</label>
                                            <input type="text" id="member_profession" name="member_profession[]" value="{{ $memberProfession[$key] ?? '--' }}" class="form-control @error('member_profession') is-invalid @enderror" placeholder="Enter profession">

                                            @error('member_profession')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="member_mobile">Mobile</label>
                                            <div class="d-flex">
                                                <input type="text" name="member_mobile[]" id="member_mobile" value="{{ $memberMobile[$key] ?? '--' }}" class="form-control @error('member_mobile') is-invalid @enderror" placeholder="Enter mobile no">

                                                @if ($key == 0)
                                                    <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="add" id="add" class="btn btn-success">+</button>
                                                @else
                                                    <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="row_remove" id="row_remove" class="btn btn-danger row_remove">-</button>
                                                @endif

                                                @error('member_mobile')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </span>

                            <div id="AddField">

                            </div>

                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <b>Maid Details</b>
                                </div>
                                <div class="col-sm-4">
                                     <label for="made_name">Maid Name</label>
                                     <input type="text" value="{{ $data->made_name }}" name="made_name" class="form-control" id="made_name" placeholder="Enter maid name">
                                   </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="made_nid">Made NID</label>
                                     <input type="number"  value="{{ $data->made_nid }}"  id="made_nid" name="made_nid" class="form-control" placeholder="Enter maid nid">
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="made_mobile">Made Mobile</label>
                                     <input type="text" value="{{ $data->made_mobile }}"  id="made_mobile" name="made_mobile" class="form-control" placeholder="Enter maid mobile no">
                                 </div>
                             </div>

                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label for="made_address">Permanent Address</label>
                                     <textarea name="made_address" class="form-control" rows="1" placeholder="Write address">{{ $data->made_address }}</textarea>
                                 </div>
                             </div>
                         </div>

                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <b>Driver Details</b>
                                </div>
                                <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="driver_name">Driver Name</label>
                                     <input type="text" value="{{ $data->driver_name }}" name="driver_name" class="form-control" id="driver_name" placeholder="Enter driver name">
                                </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="driver_nid">Driver NID</label>
                                     <input type="number" value="{{ $data->driver_nid }}" id="driver_nid" name="driver_nid" class="form-control" placeholder="Enter driver nid">
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="driver_mobile">Driver Mobile</label>
                                     <input type="text" value="{{ $data->driver_name }}" id="driver_mobile" name="driver_mobile" class="form-control" placeholder="Enter driver mobile no">
                                 </div>
                             </div>

                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label for="driver_address">Permanent Address</label>
                                     <textarea name="driver_address" class="form-control" rows="1" placeholder="Write address">{{ $data->driver_address }}</textarea>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                            <div class="col-sm-12 mb-2">
                                <b>Previous Flat Owner</b>
                            </div>
                            <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="previous_owner_name">Owner Name</label>
                                     <input type="text" value="{{ $data->previous_owner_name }}" name="previous_owner_name" class="form-control" id="previous_owner_name" placeholder="Enter previous owner name">
                                     </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="previous_owner_nid">Owner NID</label>
                                     <input type="number" id="previous_owner_nid" name="previous_owner_nid" value="{{ $data->previous_owner_nid }}" class="form-control" placeholder="Enter nid">
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="previous_owner_mobile">Owner Mobile</label>
                                     <input type="text" id="previous_owner_mobile" name="previous_owner_mobile" value="{{ $data->previous_owner_mobile }}" class="form-control" placeholder="Ente mobile no">
                                 </div>
                             </div>

                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="previous_owner_address">Permanent Address</label>
                                     <textarea name="previous_owner_address" class="form-control" rows="2" name="previous_owner_address" placeholder="Write address">{{ $data->previous_owner_address }}</textarea>
                                 </div>
                             </div>

                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="leave_reason">Previous Flat Leave Reason</label>
                                     <textarea name="leave_reason" class="form-control" rows="2" placeholder="Write reason">{{ $data->leave_reason }}</textarea>
                                 </div>
                             </div>
                         </div>

                            <div class="row">
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="present_owner_nid">Present Owner Email<span class="text-red">*</span></label>
                                     <input type="email" value="{{ $data->owners->email }}" id="present_owner_email" name="present_owner_nid" class="form-control" readonly>
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="present_owner_mobile">Present Owner Mobile<span class="text-red">*</span></label>

                                     @if ($user_role->name == 'Super Admin')
                                        <input type="text" value="{{ $data->owners->contact_no }}" id="present_owner_mobile" name="present_owner_mobile" class="form-control" readonly>
                                        @else
                                        <input type="text" id="present_owner_mobile" name="present_owner_mobile" value="{{ Auth::user()->owners->contact_no }}" class="form-control" readonly>
                                     @endif
                                 </div>
                             </div>

                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <label for="issue_date">Issue Date<span class="text-red">*</span></label>
                                     <input type="date" id="issue_date" name="issue_date" value="{{ $data->issue_date }}" class="form-control @error('address') is-invalid @enderror" placeholder="Enter date" required>
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

        //calculation
        $(".rent").on('input', function(){
            var sum = 0;
            $('.rent').each(function(){
                sum += parseFloat(this.value);
            });
            $('#total_rent').val(sum);
        })

        var gender = $('#gender').val();

        if(gender = 1){
            $('#genderName').val('Male');
        }else {
            $('#genderName').val('Female');
        }

        //field append
        var i = 1;
        var total = $('.sn').length;

        $("#add").click(function () {
            if(total < 4 ){
            ++i;

            $("#AddField").append(`<div class="row" id="removed">
                <div class="col-sm-1">
                    <div class="form-group">
                        <label for="card_name">SN</label>
                        <input type="text" id="sn${i}" name="sn[]" value="${ ++total }" class="form-control @error('sn') is-invalid @enderror" readonly>

                        @error('sn')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="member_name">Name</label>
                        <input type="text" id="member_name" name="member_name[]" value="{{ old('member_name') }}" class="form-control @error('member_name') is-invalid @enderror" placeholder="Enter name" required>

                            @error('member_name')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="member_age">Age</label>
                        <input type="text" id="member_age" name="member_age[]" value="{{ old('member_age') }}" class="form-control @error('member_age') is-invalid @enderror" placeholder="Enter age" required>

                            @error('member_age')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="member_profession">Profession</label>
                        <input type="text" id="member_profession" name="member_profession[]" value="{{ old('member_profession') }}" class="form-control @error('member_profession') is-invalid @enderror" placeholder="Enter profession" required>

                            @error('member_profession')
                        <span class="text-danger" role="alert">
                            <p>{{ $message }}</p>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="member_mobile">Mobile</label>
                        <div class="d-flex">
                            <input type="text" name="member_mobile[]" id="member_mobile" class="form-control @error('member_mobile') is-invalid @enderror">
                            <button style="margin-left: 5px; height:35px; font-size:14px; text-align:center" type="button" name="del" id="del" class="btn btn-danger btn_remove">-</button>

                            @error('member_mobile')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>`);
        }else{
            alert("Your are not allowed to create new field");
        }
    });

    $(document).on('click', '.btn_remove', function() {
            $(this).parents('#removed').remove();
            i--;
            total--;
        });


        //get owner wise flat
        $("#owner_info_id").on('change', function(){
            var owner_id= $('#owner_info_id').val();
            var date = {{ date("Ymd")}};
            $.ajax({
                url: "{{ route('ownerwise-flat-tenant') }}",
                type: "GET",
                data: {
                    'owner_id':owner_id,
                },
                success: function(data){
                    $('#flat_info_id').empty();
                    $('#flat_info_id').append("<option value=''>Select flat</option>");
                    $('#tenant_info_id').empty();
                    $('#tenant_info_id').append("<option value=''>Select tenant</option>");

                    $('#present_owner_mobile').val(data.owners.contact_no);
                    $('#present_owner_email').val(data.owners.email);

                    $.each(data.flats, function(key, flat){
                        $('#flat_info_id').append(`<option rent_title="${flat.flat_name}-${date}" daining_space="${flat.daining_space}" balcony="${flat.balcony}" bathroom="${flat.bathroom}" guest_bedroom="${flat.guest_bedroom}" master_bedroom="${flat.master_bedroom}" bedrooom="${flat.bedroom}" flat_size="${flat.flat_size}" value="${flat.id}">${flat.flat_name}</option>`);

                    });

                    $.each(data.tenants, function(key, tenant){
                        $('#tenant_info_id').append("<option value="+tenant.id+">"+tenant.tenant_name+"</option>");
                    });

                },
            });
        });



        $('#flat_info_id').on('change',function(){
            var element = $(this).find('option:selected');
            $('#flat_size').val(element.attr("flat_size"));
            $('#bedroom').val(element.attr("bedrooom"));
            $('#master_bedroom').val(element.attr("master_bedroom"));
            $('#guest_bedroom').val(element.attr("guest_bedroom"));
            $('#bathroom').val(element.attr("bathroom"));
            $('#balcony').val(element.attr("balcony"));
            $('#daining_space').val(element.attr("daining_space"));
            $('#rent_title').val(element.attr("rent_title"));

            var dainingSpace = $('#daining_space').val();

            if(dainingSpace == 1){
              $('#yes').show();
              $('#no').hide();
            }else if(dainingSpace == 0){
             $('#yes').hide();
             $('#no').show();
           }

            // total room calculate
            let bedroom = 0;
            let master_bedroom = 0;
            let guest_bedroom = 0;
            if($('#bedroom').val()){
                bedroom =  parseFloat($('#bedroom').val());
            }
            if($('#master_bedroom').val()){
                master_bedroom =  parseFloat($('#bedroom').val());
            }
            if($('#guest_bedroom').val()){
                guest_bedroom =  parseFloat($('#bedroom').val());
            }

            let total = bedroom + master_bedroom + guest_bedroom;

            $('#total_room').val(total);
        })

        $("#tenant_info_id").on('change', function(){
            var tenant_id = $('#tenant_info_id').val();

            $('#tenantMobile').val(null);
            $('#tenantNid').val(null);
            $('#email').val(null);
            $('#gender').val(null);
            $('#permanent_address').val(null);

            $.ajax({
                url: "{{ route('ownerwise-flat-tenant') }}",
                type: "GET",
                data: {
                    'tenant_id':tenant_id,
                },
                success: function(result){

                    $('#tenantMobile').val(result.tenantData.contact_no);
                    $('#email').val(result.tenantData.email);
                    $('#permanent_address').val(result.tenantData.address);

                    let gender = $('#gender').val(result.tenantData.gender);

                    if(gender = 1){
                        $('#genderName').val('Male');
                    }else {
                        $('#genderName').val('Female');
                    }
                },
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
                    i--;
                    total--;
                }
                else {
                    return false;
                }
            });
         })

    </script>
    @endpush
@endsection
