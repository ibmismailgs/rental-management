@extends('layouts.main')
@section('title', 'Owner Deatils')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Owner Details</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('owner-info.index') }}" type="button" class="btn btn-sm btn-dark">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                    @can('manage_user')
                        <a title="Create Button" href="{{ route('owner-info.create') }}" type="button" class="btn btn-sm btn-success">
                            <i class="fas fa-plus mr-1"></i>
                            Create
                        </a>
                    @endcan
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
                                <td width="30%">Owner Name</td>
                                <td>{{ $data->owner_name ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Phone</td>
                                <td>{{ $data->contact_no ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td>{{ $data->email ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Idenity Card Name</td>
                                @php
                                    $cardNames = json_decode($data->card_name);
                                @endphp
                                <td>
                                @foreach($cardNames as $cardName)
                                    <span>
                                        @if($cardName == 1) NID,
                                        @elseif($cardName == 2) Passport,
                                        @elseif($cardName == 3) Birth Certificate,
                                        @elseif($cardName == 4) Driving License
                                        @endif
                                     </span>
                                  @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td>Idenity Card No</td>
                                @php
                                    $cardNumbers = json_decode($data->card_no);
                                @endphp
                                <td>
                                    @foreach($cardNumbers as $cardNumber)
                                        <span> {{ $cardNumber }} ,  </span>
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td>Idenity Card Photo</td>
                                @php
                                    $cardPhotos = json_decode($data->card_photo);
                                @endphp
                                <td>
                                @foreach($cardPhotos as $cardPhoto)
                                    <span> <img height="50px" width="100px" src="{{ asset('img/'.$cardPhoto )}}" alt="ID Card Photo">,
                                    </span>
                                @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td>Gender</td>
                                <td>
                                    @if($data->gender == 1)
                                       Male
                                    @elseif($data->gender == 2)
                                       Female
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Address</td>
                                <td>{{ $data->address ?? '--' }}</td>
                            </tr>

                            <tr>
                                <td>Owner Photo</td>
                                <td><img height="50px" width="100px" src="{{ asset('img/'.$data->owner_photo)}}" alt="Owner Photo">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
