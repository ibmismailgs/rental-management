@extends('layouts.main')
@section('title', 'Edit Flat')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .dropify-wrapper .dropify-message p {
        font-size: initial;
    }

    .checkmark {
        /* position: absolute; */
        height: 20px;
        width: 20px;
        background-color: #eee;
    }
    .custom{
        padding: 5px;
        margin-left: 1px;
        border-radius: 2px;
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
                        <h5 class="pt-10" >Edit Flat </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('flat-info.index') }}" type="button" class="btn btn-sm btn-dark">
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
                        <form enctype="multipart/form-data" action="{{ route('flat-info.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_info_id">Owner name<span class="text-red">*</span></label>

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

                                        @error('owner_info_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="flat_name">Flat Name<span class="text-red">*</span></label>
                                        <input type="text" id="flat_name" name="flat_name" value="{{ $data->flat_name }}"class="form-control @error('flat_name') is-invalid @enderror" placeholder="Enter flat name" required>

                                         @error('flat_name')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="flat_size">Flat Size (Square Feet)<span class="text-red">*</span></label>
                                        <input type="number" id="flat_size" name="flat_size" value="{{ $data->flat_size }}"class="form-control @error('flat_size') is-invalid @enderror" placeholder="Enter flat size" required>

                                         @error('flat_size')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bathroom">Bathroom<span class="text-red">*</span></label>
                                        <input type="number" id="bathroom" name="bathroom" value="{{ $data->bathroom }}"class="form-control @error('bathroom') is-invalid @enderror" placeholder="Enter total bathroom" required>

                                         @error('bathroom')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bedroom">Bedroom<span class="text-red">*</span></label>
                                        <input type="number" id="bedroom" name="bedroom" value="{{ $data->bedroom }}"class="form-control bed @error('bedroom') is-invalid @enderror" placeholder="Enter total bedroom" required>

                                         @error('bedroom')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="master_bedroom">Master Bedroom<span class="text-red">*</span></label>
                                        <input type="number" id="master_bedroom" name="master_bedroom" value="{{ $data->master_bedroom }}"class="form-control bed @error('master_bedroom') is-invalid @enderror" placeholder="Enter total master bedroom" required>

                                         @error('master_bedroom')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="guest_bedroom">Guest Bedroom<span class="text-red">*</span></label>
                                        <input type="number" id="guest_bedroom" name="guest_bedroom" value="{{ $data->guest_bedroom }}"class="form-control bed @error('guest_bedroom') is-invalid @enderror" placeholder="Enter total guest bedroom" required>

                                         @error('guest_bedroom')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="balcony">Balcony<span class="text-red">*</span></label>
                                        <input type="number" id="balcony" name="balcony" value="{{ $data->balcony }}"class="form-control @error('balcony') is-invalid @enderror" placeholder="Enter total balcony" required>

                                         @error('balcony')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_room">Total Room</label>
                                        <input type="text" id="total_room" value="{{ $toalRoom ?? '--' }}" name="total_room" value="{{ old('total_room') }}"class="form-control "  readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>On</option>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Off</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                        <label for="daining_space">Dining Space : </label>&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="daining_space"  class="checkoption checkmark" value="1" {{ $data->daining_space == 1 ? 'checked'  : '' }}><span for="yes" class="badge badge-success custom" title="Dainig Space" id="yes">Yes</span>

                                        <input type="checkbox" name="daining_space"  class=" ml-10 checkoption checkmark" value="0" {{ $data->daining_space == 0 ? 'checked'  : '' }}><span class="badge badge-danger custom" title="Dainig Space" id="no">No</span>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="flat_photo">Flat Photo<span class="text-red">*</span></label>
                                        <input type="file" name="flat_photo" id="flat_photo" data-height="105" @if ($data) data-default-file="{{ asset('img/' . $data->flat_photo) }}" @endif class="dropify form-control @error('flat_photo') is-invalid @enderror">

                                        @error('flat_photo')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

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
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        $(".bed").on('input', function(){
            var sum = 0;
            $('.bed').each(function(){
                sum += parseFloat(this.value);
            });
            $('#total_room').val(sum);
        })

        $('.checkoption').click(function() {
          $('.checkoption').not(this).prop('checked', false);
        });

    </script>
    @endpush
@endsection
