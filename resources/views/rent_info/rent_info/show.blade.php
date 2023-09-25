@extends('layouts.main')
@section('title', 'Rent Deatils')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    dl{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    dt{
        width: 120px;
    text-align: right;
    margin-right: 7px;
    }
</style>

@endpush
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Rent Details</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-title-actions float-right">
                    <a title="Print Button" href="{{ route('print', $data->id) }}" type="button" class="btn btn-sm btn-danger">
                        <i class="fas fa-file mr-1"></i>
                        Print
                    </a>
                    <a title="Back Button" href="{{ route('rent-info.index') }}" type="button" class="btn btn-sm btn-dark">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back
                    </a>
                    <a title="Create Button" href="{{ route('rent-info.create') }}" type="button" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i>
                        Create
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <p class="text-center">Owner</p>
                    <div class="text-center">
                        <img src="{{ asset('img/'.$data->owners->owner_photo)}}" class="rounded-circle" width="150" />
                        <h4 class="card-title mt-10">{{ Auth::user()->name }}</h4>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="text-center">Tenant</p>
                    <div class="text-center">
                        <img src="{{ asset('img/'.$data->tenants->tenant_photo)}}" class="rounded-circle" width="150" />
                        <h4 class="card-title mt-10">{{ $data->tenants->tenant_name }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Payment History</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Present Owner Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Owner Name</td>
                                                <td width="60%">{{ $data->owners->owner_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Owner Email</td>
                                                <td width="60%" style="word-break: break-word;">{{ $data->owners->email ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Owner Mobile</td>
                                                <td width="60%">{{ $data->owners->contact_no ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Gender</td>
                                                <td width="60%">
                                                    @if (1 == $data->owners->gender)
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Idenity Card Name</td>
                                                @php
                                                    $cardNames = json_decode($data->owners->card_name);
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
                                                    $cardNumbers = json_decode($data->owners->card_no);
                                                @endphp
                                                <td>
                                                    @foreach($cardNumbers as $cardNumber)
                                                        <span> {{ $cardNumber }} ,  </span>
                                                    @endforeach
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Flat Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Issue Date</td>
                                                <td width="60%">{{ Carbon\Carbon::parse($data->issue_date)->format('d F, Y') ?? '--' }}</td>
                                            </tr>

                                            <tr>
                                                <td width="40%">Rent Title</td>
                                                <td width="60%">{{ $data->rent_title ?? '--' }}</td>
                                            </tr>

                                            <tr>
                                                <td width="40%">Flat Name</td>
                                                <td width="60%">{{ $data->flats->flat_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Flat Size</td>
                                                <td width="60%">{{ $data->flats->flat_size ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Bathroom</td>
                                                <td width="60%">{{ $data->flats->bathroom ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Bedroom</td>
                                                <td width="60%">{{ $data->flats->bedroom ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Flat Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Master Bedroom</td>
                                                <td width="60%">{{ $data->flats->master_bedroom ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Guest Bedroom</td>
                                                <td width="60%">{{ $data->flats->guest_bedroom ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Total Bedroom</td>
                                                <td width="60%">{{ $totalRoom ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Flat Balcony</td>
                                                <td width="60%">{{ $data->flats->balcony ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Daining Space</td>
                                                <td width="60%">
                                                    @if($data->daining_space == 1)
                                                        <span class="badge badge-success" title="Dainig Space">Yes</span>
                                                    @elseif($data->daining_space == 0)
                                                        <span class="badge badge-danger" title="Dainig Space">No</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="40%">Flat Photo</td>
                                                <td width="60%"><img height="50px" widtd="100px" src="{{ asset ('img/'.$data->flat_photo) }}" alt="flat photo"></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Tenant Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Tenant Name</td>
                                                <td width="60%">{{ $data->tenants->tenant_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Father Name</td>
                                                <td width="60%">{{ $data->father_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">District</td>
                                                <td width="60%">{{ $data->district ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Thana</td>
                                                <td width="60%">{{ $data->thana ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Holding</td>
                                                <td width="60%">{{ $data->holding ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Road</td>
                                                <td width="60%">{{ $data->road ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Post Code</td>
                                                <td width="60%">{{ $data->post_code ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Tenant Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Tenant Nid</td>
                                                <td width="60%">{{ $data->tenant_nid ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Passport</td>
                                                <td width="60%">{{ $data->passport ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Date of Birth</td>
                                                <td width="60%">{{ $data->birthdate ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Merital Status</td>
                                                <td width="60%">
                                                    @if (1 == $data->merital_status)
                                                     Married
                                                     @else
                                                     Unmarried
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Religion</td>
                                                <td width="60%">
                                                    @if (1 == $data->religion)
                                                     Islam
                                                     @elseif (2 == $data->religion)
                                                     Hindu
                                                     @elseif (3 == $data->religion)
                                                     Buddhist
                                                     @elseif (4 == $data->religion)
                                                     Christian
                                                     @elseif (5 == $data->religion)
                                                     Others
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Mobile</td>
                                                <td width="60%">{{ $data->tenants->contact_no ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Email</td>
                                                <td width="60%" style="word-break: break-word;">{{ $data->tenants->email ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Tenant Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Gender</td>
                                                <td width="60%">
                                                    @if (1 == $data->gender)
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Profession</td>
                                                <td width="60%">{{ $data->profession ?? '--' }}</td>
                                            </tr>

                                            <tr>
                                                <td width="40%">Work Place Address</td>
                                                <td width="60%">{{ $data->professional_address ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Permanent Address</td>
                                                <td width="60%">{{ $data->tenants->address ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Educational Qualification</td>
                                                <td width="60%">{{ $data->qualification ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Emergency Contact</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Name</td>
                                                <td width="60%">{{ $data->emergency_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Relation</td>
                                                <td width="60%">{{ $data->relation ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Mobile</td>
                                                <td width="60%">{{ $data->emergency_mobile ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Address</td>
                                                <td width="60%">{{ $data->emergency_address ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                 <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Maid Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Maid Name</td>
                                                <td width="60%">{{ $data->made_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Maid NID</td>
                                                <td width="60%">{{ $data->made_nid ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Maid Mobile</td>
                                                <td width="60%">{{ $data->made_mobile ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Address</td>
                                                <td width="60%">{{ $data->made_address ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                 <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Driver Details</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Driver Name</td>
                                                <td width="60%">{{ $data->driver_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Driver NID</td>
                                                <td width="60%">{{ $data->driver_nid ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Driver Mobile</td>
                                                <td width="60%">{{ $data->driver_mobile ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Address</td>
                                                <td width="60%">{{ $data->driver_address ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                 <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="2">Previous Flat Owner</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="40%">Owner Name</td>
                                                <td width="60%">{{ $data->previous_owner_name ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Owner NID</td>
                                                <td width="60%">{{ $data->previous_owner_nid ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Owner Mobile</td>
                                                <td width="60%">{{ $data->previous_owner_mobile ?? '--'}}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Address</td>
                                                <td width="60%">{{ $data->previous_owner_address ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <td width="40%">Flat Leave Reason</td>
                                                <td width="60%">{{ $data->leave_reason ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>

                                 <div class="col-sm-4">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="btn-primary">
                                                <td colspan="5">Family Member Details</td>
                                            </tr>
                                        </thead>
                                                @php
                                                    $memberName = json_decode($data->member_name);
                                                    $memberAge = json_decode($data->member_age);
                                                    $memberProfession = json_decode($data->member_profession);
                                                    $memberMobile = json_decode($data->member_mobile);
                                                @endphp

                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Name</th>
                                                        <th>Age</th>
                                                        <th>Profession</th>
                                                        <th>Mobile</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($memberName as $key => $value)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td width="60%">{{ $value ?? '--' }}</td>
                                                        <td width="60%">{{ $memberAge[$key] ?? '--' }}</td>
                                                        <td width="60%">{{ $memberProfession[$key] ?? '--'}}</td>
                                                        <td width="60%">{{ $memberMobile[$key] ?? '--' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                    </table>
                                 </div>

                                </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="card-body ml-3">
                                        <table width="100%" id="data_table" class="table table-bordered table-striped data-table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Rent Title</th>
                                                    <th>Flat Name</th>
                                                    <th>Total Rent</th>
                                                    <th>Received Rent</th>
                                                    <th>Rent Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var dTable = $('#data_table').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: false,
            serverSide: true,
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            ajax: {
                url: "{{route('rent-collect.index')}}",
                type: "get"
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'rent_title', name: 'rent_title'},
                {data: 'flat_name', name: 'flat_name'},
                {data: 'total_rent', name: 'total_rent'},
                {data: 'received_rent', name: 'received_rent'},
                {data: 'rent_status', name: 'rent_status'},
                {data: 'action', searchable: false, orderable: false}
            ],
        });
</script>
@endpush
@endsection
