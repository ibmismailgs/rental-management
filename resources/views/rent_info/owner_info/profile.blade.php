@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >{{ $data->owner_name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('img/'. $data->owner_photo) ?? '' }}" class="rounded-circle" width="150" />
                            <h4 class="card-title mt-10">{{ $data->owner_name }}</h4>
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class="card-body">
                        <small class="text-muted d-block">{{ __('Email address')}} </small>
                        <h6>{{ $data->email }}</h6>
                        <small class="text-muted d-block pt-10">{{ __('Phone')}}</small>
                        <h6>{{ $data->contact_no }}</h6>
                        <small class="text-muted d-block pt-10">{{ __('Address')}}</small>
                        <h6>{{ $data->address ?? ' ' }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Profile')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Setting')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-6"> <strong>{{ __('Full Name')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $data->owner_name ?? '--' }}</p>
                                    </div>
                                    <div class="col-md-3 col-6"> <strong>{{ __('Mobile')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $data->contact_no ?? '--'}}</p>
                                    </div>
                                    <div class="col-md-3 col-6"> <strong>{{ __('Email')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $data->email ?? '--'}}</p>
                                    </div>
                                    <div class="col-md-3 col-6"> <strong>{{ __('Address')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $data->address ?? '--'}}</p>
                                    </div>
                                </div>
                                <hr>
                                <p class="mt-30">
                                    --
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                            <div class="card-body">
                                <form action="{{ route('profile.update', $data->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="owner_name">{{ __('Full Name')}}</label>
                                        <input type="text" value="{{ $data->owner_name ?? '--' }}" class="form-control" name="owner_name" id="owner_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ __('Email')}}</label>
                                        <input type="email" value="{{ $data->email ?? '--'}}" class="form-control" name="email" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no">{{ __('Phone')}}</label>
                                        <input type="text" value="{{ $data->contact_no ?? '--' }}" id="contact_no" name="contact_no" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">{{ __('Address')}}</label>
                                        <textarea name="address" class="form-control" rows="5" placeholder="Write your address">{{ $data->address }}</textarea>
                                    </div>
                                    <button class="btn btn-success" type="submit">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
