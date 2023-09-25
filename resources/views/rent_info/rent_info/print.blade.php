<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Registration Form</title>
    <style>
        .dotborder{
            border-bottom: 1px dotted #000;
           float: right;
            display: inline-block;
        }
        .flatd{
            background: #fff;
            display: flex;
        }
        .bodyp{
            background: #fff;
            display: flex;
        }
        .flatd span{
            width: 115px;
        }
        .dotp{
            border-bottom: 1px solid #000;
            width: 100px;
        }
        .bodyp span{
            width: 180px;
        }
        table{
            width: 100%;
        }
        .member td{
            padding-left: 4px;
            border: 1px solid black;
        }
        p{
            margin: 0px;
        }
    </style>
</head>
<body>
    <div style="float:right">
        <button onclick="printableDiv('printableArea')" title="Print Button" style="color:white;background-color:#007bff;height:32px;width:65px;margin-left:4px" >
            Print
        </button>
    </div>

<div id="printableArea" style="padding: 10px;padding-left:25px;" class="container" >

    <header >
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="rent-img">
                        <img src="{{ asset('img/'.$data->tenant_photo)}}" class="rounded-circle" width="150" />
                        <p style="margin-left:20px">Tenant Photo</p>
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div class="divMiddle">
                        <h2 style="text-align: center; "><u>Tenant Registration Form</u></h2>
                    </div>
                </td>
                <td>
                    <div class="flatdetails">
                        <p class="flatd"><span>Flat Name</span> <label class="dotborder">: {{ $data->flats->flat_name ?? '--' }}</label></p>
                        <p class="flatd"><span>Flat Size</span> <label class="dotborder">: {{ $data->flats->flat_size ?? '--' }} Square Feet</label></p>
                        <p class="flatd"><span>Flat Rent</span> <label class="dotborder">: {{ $data->flat_rent ?? '--' }} tk</label></p>
                        <p class="flatd"><span>Rent Title</span> <label class="dotborder">: {{ $data->rent_title ?? '--' }}</label></p>
                        <p class="flatd"><span>Holding</span> <label class="dotborder">: {{ $data->holding }}</label></p>
                        <p class="flatd"><span>Road</span> <label class="dotborder">: {{ $data->road }}</label></p>
                        <p class="flatd"><span>Post Code</span> <label class="dotborder">: {{ $data->post_code }}</label></p>
                    </div>
                </td>
            </tr>
        </table>
    </header>
    <div class="form-body" >
        <table>
            <tr>
                <td>1.</td>
                <td colspan="2"><p class="bodyp"><span>Tenant Name</span> <label class="dotborder">: {{ $data->tenants->tenant_name }}</label></p></td>
            </tr>
            <tr>
                <td>2.</td>
                <td  colspan="2"><p class="bodyp"><span>Father Name</span> <label class="dotborder">: {{ $data->father_name }}</label></p></td>
            </tr>
            <tr>
                <td>3.</td>
                <td><p class="bodyp"><span>Date of Birth</span> <label  class="dotborder">: {{ $data->birthdate }}</label></p></td>
                <td><p class="bodyp"><span>Marital Status</span> <label class="dotborder">:    @if (1 == $data->merital_status)
                    Married
                    @else
                    Unmarried
                   @endif
                </label></p></td>
            </tr>
            <tr>
                <td>4.</td>
                <td  colspan="2"><p class="bodyp"><span>Permanent Address</span> <label class="dotborder">: {{ $data->tenants->address ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td>5.</td>
                <td   colspan="2"><p class="bodyp"><span>Work Place Address</span> <label class="dotborder">: {{ $data->professional_address ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td>6.</td>
                <td><p class="bodyp"><span>Religion</span> <label class="dotborder">: @if (1 == $data->religion)
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
                </label></p></td>
                <td><p class="bodyp"><span>Educational Qualification</span> <label class="dotborder">: {{ $data->qualification ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td>7.</td>
                <td><p class="bodyp"><span>Mobile</span> <label class="dotborder">: {{ $data->tenants->contact_no ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>Email</span> <label class="dotborder">: {{ $data->tenants->email ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td>8.</td>
                <td colspan="2"><p class="bodyp"><span>NID</span> <label class="dotborder">: {{ $data->tenant_nid ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td>9.</td>
                <td colspan="2"><p class="bodyp"><span>Passport</span> <label class="dotborder">: {{ $data->passport ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td rowspan="3" style="vertical-align:top">10.</td>
                <td colspan="2"><p class="bodyp"><span>Emergency Contact : </span></p></td>
            </tr>
            <tr>
                <td><p class="bodyp"><span>(a). Name</span> <label class="dotborder">: {{ $data->emergency_name ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>(b). Relation</span> <label class="dotborder">: {{ $data->relation ?? '--'}}</label></p></td>
            </tr>
            <tr>
                <td><p class="bodyp"><span>(c). Address</span> <label class="dotborder">: {{ $data->emergency_address ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>(d). Mobile</span> <label class="dotborder">: {{ $data->emergency_mobile ?? '--'}}</label></p></td>
            </tr>
            <tr>
                <td>11.</td>
                <td colspan="2"><p>Family Member Details :</p></td>
            </tr>
        </table>
        <table class="member"  style="border-collapse: collapse;margin-left: 30px;width:96%;" border="1">
            @php
                $memberName = json_decode($data->member_name);
                $memberAge = json_decode($data->member_age);
                $memberProfession = json_decode($data->member_profession);
                $memberMobile = json_decode($data->member_mobile);
            @endphp
            <tr>
                <td>Sl</td>
                <td>Name</td>
                <td>Age</td>
                <td>Profession</td>
                <td>Mobile Number</td>
            </tr>
            <tbody>
                @foreach($memberName as $key => $value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value ?? '--' }}</td>
                    <td>{{ $memberAge[$key] ?? '--' }}</td>
                    <td >{{ $memberProfession[$key] ?? '--'}}</td>
                    <td >{{ $memberMobile[$key] ?? '--' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table>
            <tr>
                <td rowspan="2" style="vertical-align:top">12.</td>
                <td><p class="bodyp"><span>Maid Name</span> <label class="dotborder">: {{ $data->made_name ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>NID</span> <label class="dotborder">: {{ $data->made_nid ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td><p class="bodyp"><span>Mobile</span> <label class="dotborder">: {{ $data->made_mobile ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>Permanent Address</span> <label class="dotborder">: {{ $data->made_address ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align:top">13.</td>
                <td><p class="bodyp"><span>Driver Name</span> <label class="dotborder">:{{ $data->driver_name ?? '--' }} </label></p></td>
                <td><p class="bodyp"><span>NID</span> <label class="dotborder">: {{ $data->driver_nid ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td><p class="bodyp"><span>Mobile</span> <label class="dotborder">: {{ $data->driver_mobile ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>Permanent Address</span> <label class="dotborder">:{{ $data->driver_address ?? '--' }} </label></p></td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align:top">14.</td>
                <td><p class="bodyp"><span>Previous Owner Name</span> <label class="dotborder">: {{ $data->previous_owner_name ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>Mobile</span> <label class="dotborder">: {{ $data->previous_owner_mobile ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td colspan="2"><p class="bodyp"><span>Address</span> <label class="dotborder">: {{ $data->previous_owner_address ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td style="vertical-align:top">15.</td>
                <td colspan="2"><p class="bodyp"><span>Previous Flat Leave Reason</span> <label class="dotborder">: {{ $data->leave_reason ?? '--' }} </label></p></td>
            </tr>
            <tr>
                <td style="vertical-align:top">16.</td>
                <td><p class="bodyp"><span>Present Owner Name</span> <label class="dotborder">: {{ $data->owners->owner_name ?? '--' }}</label></p></td>
                <td><p class="bodyp"><span>Mobile</span> <label class="dotborder">: {{ $data->owners->contact_no ?? '--' }}</label></p></td>
            </tr>
            <tr>
                <td style="vertical-align:top">17.</td>
                <td colspan="2"><p class="bodyp"><span>Rent Starting Date</span> <label class="dotborder">: {{ $data->issue_date ?? '--' }}</label></p> </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 100px;"><span style="border-top:1px solid #000;margin-left:25px;">Date</span></td>
                <td  style="text-align: center;padding-top: 100px;"><span style="border-top:1px solid #000">Tenant Signature</span></td>
            </tr>
        </table>

    </div>
</div>
<script>
    function printableDiv(printableAreaDivId) {
     var printContents = document.getElementById(printableAreaDivId).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
</body>
</html>
