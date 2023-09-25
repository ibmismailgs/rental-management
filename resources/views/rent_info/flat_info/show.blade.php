@extends('layouts.main')
@section('title', 'Flat Deatils')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Flat Details</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Back Button" href="{{ route('flat-info.index') }}" type="button" class="btn btn-sm btn-dark">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                    <a title="Create Button" href="{{ route('flat-info.create') }}" type="button" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
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
                                <td width="30%">Flat Owner Name</td>
                                <td>{{ $data->owners->owner_name }}</td>
                            </tr>
                            <tr>
                                <td>Flat Name</td>
                                <td>{{ $data->flat_name }}</td>
                            </tr>
                            <tr>
                                <td>Flat Size</td>
                                <td>{{ $data->flat_size }} (Square-feet)</td>
                            </tr>
                            <tr>
                                <td>Bedroom</td>
                                <td>{{ $data->bedroom }}</td>
                            </tr>
                            <tr>
                                <td>Bathroom</td>
                                <td>{{ $data->bathroom }}</td>
                            </tr>
                            <tr>
                                <td>Master Bedroom</td>
                                <td>{{ $data->master_bedroom }}</td>
                            </tr>
                            <tr>
                                <td>Guest Bedroom</td>
                                <td>{{ $data->guest_bedroom }}</td>
                            </tr>
                            <tr>
                                <td>Total Bedroom</td>
                                <td>{{ $toalRoom ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td>Flat Balcony</td>
                                <td>{{ $data->balcony }}</td>
                            </tr>
                            <tr>
                                <td>Daining Space</td>
                                <td>
                                    @if($data->daining_space == 1)
                                      <span class="badge badge-success" title="Dainig Space">Yes</span>
                                    @elseif($data->daining_space == 0)
                                      <span class="badge badge-danger" title="Dainig Space">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if($data->status == 1)
                                    <span class="badge badge-success" title="Dainig Space">On</span>
                                    @elseif($data->status == 2)
                                    <span class="badge badge-danger" title="Dainig Space">Off</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Flat Photo</td>
                                <td><img height="50px" widtd="100px" src="{{ asset ('img/'.$data->flat_photo) }}" alt="flat photo">
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
