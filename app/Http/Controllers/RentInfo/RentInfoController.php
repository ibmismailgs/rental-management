<?php

namespace App\Http\Controllers\RentInfo;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RentInfo\FlatInfo;
use App\Models\RentInfo\RentInfo;
use App\Models\RentInfo\OwnerInfo;
use Illuminate\Support\Facades\DB;
use App\Models\RentInfo\TenantInfo;
use App\Http\Controllers\Controller;
use App\Models\Accounts\BankAccount;
use App\Models\Accounts\Installment;
use App\Models\Accounts\Transaction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Accounts\MobileBankingAccount;


class RentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

         if ($request->ajax()) {

            $auth = Auth::user();
            $user_role = $auth->roles->first();

            if ($user_role->name == 'Super Admin') {
                $data = DB::table('rent_infos')
                    ->Join('flat_infos', 'flat_infos.id', '=', 'rent_infos.flat_info_id')
                    ->Join('owner_infos', 'owner_infos.id', '=', 'flat_infos.owner_info_id')
                    ->Join('tenant_infos', 'tenant_infos.id', '=', 'rent_infos.tenant_info_id')
                    ->select('rent_infos.*', 'flat_infos.flat_name','tenant_infos.tenant_name','owner_infos.owner_name')
                    ->whereNull('rent_infos.deleted_at')
                    ->whereNull('owner_infos.deleted_at')
                    ->whereNull('tenant_infos.deleted_at')
                    ->whereNull('flat_infos.deleted_at')
                    ->get();
              }else{
                $data = DB::table('rent_infos')
                    ->Join('flat_infos', 'flat_infos.id', '=', 'rent_infos.flat_info_id')
                    ->Join('owner_infos', 'owner_infos.id', '=', 'flat_infos.owner_info_id')
                    ->Join('tenant_infos', 'tenant_infos.id', '=', 'rent_infos.tenant_info_id')
                    ->select('rent_infos.*', 'flat_infos.flat_name','tenant_infos.tenant_name','owner_infos.owner_name')
                    ->where('rent_infos.owner_info_id', (Auth::user()->owners->id))
                    ->whereNull('rent_infos.deleted_at')
                    ->whereNull('owner_infos.deleted_at')
                    ->whereNull('tenant_infos.deleted_at')
                    ->whereNull('flat_infos.deleted_at')
                    ->get();
            }

        return Datatables::of($data)

            ->addColumn('issueDate', function ($data) {
                $date = Carbon::parse($data->issue_date)->format('d F, Y');
                return $date;
            })

            ->addColumn('rentalMonth', function ($data) {
                $month = Carbon::parse($data->issue_date)->format('F, Y');
                return $month;
            })

            ->addColumn('action', function ($data) {
                if(Auth::user()->can('manage_flat')){
                $action = '<div class="btn-group open">
                    <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                    <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">
                        <li><a class="dropdown-item" href="' . route('print', $data->id) . ' " ><i class="fa fa-print" ></i> Print</a></li>

                        <li><a class="dropdown-item" href="' . route('rent-report', $data->id) . ' " ><i class="fa fa-file" ></i> Report</a></li>

                        <li><a class="dropdown-item deed" href="' . route('deed-close', $data->flat_info_id) . ' " getId="' . $data->flat_info_id . '" ><i class="fa fa-window-close" aria-hidden="true"></i> Deed Close</a></li>

                        <li><a class="dropdown-item" href="' . route('rent-collection', $data->id) . ' " ><i class="fa fa-solid fa-dollar-sign"></i> Rent Collect</a></li>
                        <li><a class="dropdown-item" href="' . route('rent-info.show', $data->id) . ' " ><i class="fa fa-eye" ></i> Details</a></li>
                        <li><a class="dropdown-item" href="' . route('rent-info.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>
                        <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('rent-info.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>';
                }
                return $action;
            })

        ->addIndexColumn()
        ->rawColumns(['issueDate','rentalMonth','action'])
        ->toJson();
     }
     return view('rent_info.rent_info.index');
    } catch (\Exception $exception) {
        return redirect()->back()->with('error', $exception->getMessage());
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owners = OwnerInfo::all();
        $tenants = TenantInfo::all();
        $flats = FlatInfo::where('status', 1)->where('rent_status', 0)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('rent_info.rent_info.create', compact('owners','tenants','flats','user_role'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function OwnerWiseFlatTenant(Request $request){

        $flats = FlatInfo::where('owner_info_id', $request->owner_id)->where('status', 1)->where('rent_status', 0)->get();
        $tenants = TenantInfo::where('owner_info_id', $request->owner_id)->get(['tenant_name','id']);
        $Expenseflats = FlatInfo::where('owner_info_id', $request->owner_id)->where('status', 1)->get();

        $flatData = FlatInfo::where('id', $request->flat_id)->first();

        $mobileAccounts = MobileBankingAccount::with('mobileBankings','owners')->where('owner_info_id', $request->owner_id)->where('status', 1)->get();

        $bankAccounts = BankAccount::with('banks','owners')->where('owner_info_id', $request->owner_id)->where('status', 1)->get();

        $owners = OwnerInfo::where('id', $request->owner_id)->first();
        $tenantData = TenantInfo::where('id', $request->tenant_id)->first();

        return response()->json([
            'flats' => $flats,
            'tenants' => $tenants,
            'Expenseflats' => $Expenseflats,
            'flatData' => $flatData,
            'mobileAccounts' => $mobileAccounts,
            'bankAccounts' => $bankAccounts,
            'owners' => $owners,
            'tenantData' => $tenantData,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'owner_info_id.required' => 'Select owner name',
            'flat_info_id.required' => 'Select flat name',
            'tenant_info_id.required' => 'Select tenant name',
            'issue_date.required' => 'Enter date',
            'flat_rent.required' => 'Enter flat rent',
            'gas_bill.required' => 'Enter gas bill',
            'water_bill.required' => 'Enter water bill',
            'service_charge.required' => 'Enter service charge',
            'district.required' => 'Enter district name',
            'thana.required' => 'Enter thana',
            'holding.required' => 'Enter holding',
            'post_code.required' => 'Enter post code',
            'father_name.required' => 'Enter father name',
            'birthdate.required' => 'Enter birth date',
            'merital_status.required' => 'Select merital status',
            'profession.required' => 'Enter profession',
            'religion.required' => 'Select religion',
            'qualification.required' => 'Enter qualification',
            'tenant_nid.required' => 'Enter nid',
            'emergency_name.required' => 'Enter emergency contact name',
            'relation.required' => 'Enter relation',
            'emergency_mobile.required' => 'Enter emergency mobile',
            'emergency_address.required' => 'Write emergency address',
            'issue_date.required' => 'Enter date',
        );

        $this->validate($request, array(
            'flat_rent' => 'required|numeric|min:0|not_in:0',
            'gas_bill' => 'required|numeric|min:0|not_in:0',
            'water_bill' => 'required|numeric|min:0|not_in:0',
            'service_charge' => 'required|numeric|min:0|not_in:0',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new RentInfo();
            $data->owner_info_id = $request->owner_info_id;
            $data->flat_info_id = $request->flat_info_id;
            $data->tenant_info_id = $request->tenant_info_id;
            $data->issue_date = $request->issue_date;
            $data->flat_rent = $request->flat_rent;
            $data->rent_title = $request->rent_title;
            $data->gas_bill = $request->gas_bill;
            $data->water_bill = $request->water_bill;
            $data->service_charge = $request->service_charge;
            $data->total_rent = $request->total_rent;

            if ($request->file('tenant_photo')) {
                $file = $request->file('tenant_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->tenant_photo = $filename;
            }

            $data->district = $request->district;
            $data->thana = $request->thana;
            $data->holding = $request->holding;
            $data->road = $request->road;
            $data->post_code = $request->post_code;
            $data->father_name = $request->father_name;
            $data->birthdate = $request->birthdate;
            $data->merital_status = $request->merital_status;
            $data->religion = $request->religion;
            $data->profession = $request->profession;
            $data->professional_address = $request->professional_address;
            $data->qualification = $request->qualification;
            $data->tenant_nid = $request->tenant_nid;
            $data->passport = $request->passport;
            $data->emergency_name = $request->emergency_name;
            $data->relation = $request->relation;
            $data->emergency_mobile = $request->emergency_mobile;
            $data->emergency_address = $request->emergency_address;
            $data->member_name = json_encode($request->member_name);
            $data->member_age = json_encode($request->member_age);
            $data->member_profession = json_encode($request->member_profession);
            $data->member_mobile = json_encode($request->member_mobile);
            $data->made_name = $request->made_name;
            $data->made_nid = $request->made_nid;
            $data->made_mobile = $request->made_mobile;
            $data->made_address = $request->made_address;
            $data->driver_name = $request->driver_name;
            $data->driver_nid = $request->driver_nid;
            $data->driver_mobile = $request->driver_mobile;
            $data->driver_address = $request->driver_address;
            $data->previous_owner_name = $request->previous_owner_name;
            $data->previous_owner_nid = $request->previous_owner_nid;
            $data->previous_owner_mobile = $request->previous_owner_mobile;
            $data->previous_owner_address = $request->previous_owner_address;
            $data->leave_reason = $request->leave_reason;
            $data->present_owner_nid = $request->present_owner_nid;
            $data->issue_date = $request->issue_date;
            $data->created_by = Auth::user()->id;
            $data->save();

            $flat = FlatInfo::findOrFail($data->flat_info_id);
            $flat->rent_status = 1 ;
            $flat->update();

            DB::commit();

            return redirect()->route('rent-info.index')
                ->with('success', 'Rent created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = RentInfo::with('owners','flats','tenants')->findOrFail($id);
        $totalRoom = ($data->flats->bedroom) + ($data->flats->master_bedroom) + ($data->flats->guest_bedroom);
        return view('rent_info.rent_info.show', compact('data','totalRoom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = RentInfo::with('owners','flats','tenants')->findOrFail($id);
        $owners = OwnerInfo::all();
        $tenants = TenantInfo::where('owner_info_id', $data->owner_info_id)->get();
        $flats = FlatInfo::where('status', 1)->get();
        $totalRoom = ($data->flats->bedroom) + ($data->flats->master_bedroom) +   ($data->flats->guest_bedroom);
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('rent_info.rent_info.edit', compact('data', 'owners','flats','tenants','totalRoom','user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $messages = array(
            'owner_info_id.required' => 'Select owner name',
            'flat_info_id.required' => 'Select flat name',
            'tenant_info_id.required' => 'Select tenant name',
            'issue_date.required' => 'Enter date',
            'flat_rent.required' => 'Enter flat rent',
            'gas_bill.required' => 'Enter gas bill',
            'water_bill.required' => 'Enter water bill',
            'service_charge.required' => 'Enter service charge',
            'district.required' => 'Enter district name',
            'thana.required' => 'Enter thana',
            'holding.required' => 'Enter holding',
            'post_code.required' => 'Enter post code',
            'father_name.required' => 'Enter father name',
            'birthdate.required' => 'Enter birth date',
            'merital_status.required' => 'Select merital status',
            'profession.required' => 'Enter profession',
            'religion.required' => 'Select religion',
            'qualification.required' => 'Enter qualification',
            'tenant_nid.required' => 'Enter nid',
            'emergency_name.required' => 'Enter emergency contact name',
            'relation.required' => 'Enter relation',
            'emergency_mobile.required' => 'Enter emergency mobile',
            'emergency_address.required' => 'Write emergency address',
            'issue_date.required' => 'Enter date',
        );

        $this->validate($request, array(
            'flat_rent' => 'required|numeric|min:0|not_in:0',
            'gas_bill' => 'required|numeric|min:0|not_in:0',
            'water_bill' => 'required|numeric|min:0|not_in:0',
            'service_charge' => 'required|numeric|min:0|not_in:0',
        ), $messages);

        try {
            $data = RentInfo::findOrFail($id);
            $data->owner_info_id = $request->owner_info_id;
            $data->flat_info_id = $request->flat_info_id;
            $data->tenant_info_id = $request->tenant_info_id;
            $data->issue_date = $request->issue_date;
            $data->flat_rent = $request->flat_rent;
            $data->rent_title = $request->rent_title;
            $data->gas_bill = $request->gas_bill;
            $data->water_bill = $request->water_bill;
            $data->service_charge = $request->service_charge;
            $data->total_rent = $request->total_rent;

            if ($request->file('tenant_photo')) {
                $file = $request->file('tenant_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->tenant_photo = $filename;
            }

            $data->district = $request->district;
            $data->thana = $request->thana;
            $data->holding = $request->holding;
            $data->road = $request->road;
            $data->post_code = $request->post_code;
            $data->father_name = $request->father_name;
            $data->birthdate = $request->birthdate;
            $data->merital_status = $request->merital_status;
            $data->religion = $request->religion;
            $data->profession = $request->profession;
            $data->professional_address = $request->professional_address;
            $data->qualification = $request->qualification;
            $data->tenant_nid = $request->tenant_nid;
            $data->passport = $request->passport;
            $data->emergency_name = $request->emergency_name;
            $data->relation = $request->relation;
            $data->emergency_mobile = $request->emergency_mobile;
            $data->emergency_address = $request->emergency_address;
            $data->member_name = json_encode($request->member_name);
            $data->member_age = json_encode($request->member_age);
            $data->member_profession = json_encode($request->member_profession);
            $data->member_mobile = json_encode($request->member_mobile);
            $data->made_name = $request->made_name;
            $data->made_nid = $request->made_nid;
            $data->made_mobile = $request->made_mobile;
            $data->made_address = $request->made_address;
            $data->driver_name = $request->driver_name;
            $data->driver_nid = $request->driver_nid;
            $data->driver_mobile = $request->driver_mobile;
            $data->driver_address = $request->driver_address;
            $data->previous_owner_name = $request->previous_owner_name;
            $data->previous_owner_nid = $request->previous_owner_nid;
            $data->previous_owner_mobile = $request->previous_owner_mobile;
            $data->previous_owner_address = $request->previous_owner_address;
            $data->leave_reason = $request->leave_reason;
            $data->present_owner_nid = $request->present_owner_nid;
            $data->issue_date = $request->issue_date;
            $data->created_by = Auth::user()->id;
            $data->update();

            return redirect()->route('rent-info.index')
                ->with('success', 'Rent updated successfully');
        } catch (\Exception $exception) {

            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = RentInfo::findOrFail($id);

            $flat = FlatInfo::findOrFail($data->flat_info_id);
            $flat->rent_status = 0 ;
            $flat->update();

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rent info deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Rent info delete failed',
            ]);
        }
    }


    public function Transaction(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('transactions')->where('rent_info_id', $id)->whereNull('deleted_at')->get();
                return Datatables::of($data)

                    ->addColumn('date', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        return $date;
                    })

                    ->addColumn('rentalMonth', function ($data) {
                        $date = Carbon::parse($data->rental_month)->format('F, Y');
                        return $date;
                    })

                    ->addColumn('purpose', function ($data) {
                        if ($data->transaction_purpose == 1) {
                            $purpose = 'Rent Collect';
                        } elseif ($data->transaction_purpose == 2) {
                            $purpose = 'Due Collect';
                        } elseif ($data->transaction_purpose == 3) {
                            $purpose = 'Expense';
                        }
                        return $purpose;
                    })

                    ->addColumn('credit_amount', function ($data) {
                        if ($data->transaction_purpose == 1 || $data->transaction_purpose == 2) {
                            $total_amount = json_decode($data->amount);
                            return $total_amount;
                        } else {
                            return '--';
                        }
                    })

                    ->addColumn('current_balance', function ($data) use (&$current_balance) {
                        if ($data->transaction_purpose == 1 || $data->transaction_purpose == 2) {
                            $credit = json_decode($data->amount);
                            $current_balance = $current_balance + $credit;
                            return (number_format($current_balance));
                        }
                    })

                    ->addIndexColumn()
                    ->rawColumns(['date', 'rentalMonth','purpose', 'credit_amount', 'current_balance'])
                    ->toJson();
            }
            return view('rent_info.rent_info.transaction');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    //rent collect index page
    public function RentCollect($id)
    {
        $data = RentInfo::with('owners','flats','tenants')->findOrFail($id);
        $banks = BankAccount::with('banks','owners')->where('status', 1)->get();
        $mobilebanks = MobileBankingAccount::with('mobileBankings','owners')->where('status', 1)->get();
        return view('rent_info.rent_collect.create', compact('data','banks','mobilebanks'));
    }

    public function DueCollect($id)
    {
        $data = Installment::with('rents')->findOrFail($id);
        $banks = BankAccount::with('banks','owners')->where('status', 1)->get();
        $mobilebanks = MobileBankingAccount::with('mobileBankings','owners')->where('status', 1)->get();
        $rentAmount = Installment::where('rent_info_id', $data->rent_info_id)->where('rental_month', $data->rental_month)->sum('amount');

        $due = $data->rents->total_rent - $rentAmount;
        return view('rent_info.rent_collect.due', compact('data','banks','mobilebanks','due'));
    }

    public function DeedClose(Request $request)
    {
        try{

            $flat = FlatInfo::findOrFail($request->id);
            $flat->rent_status = 0 ;
            $flat->update();

            return response()->json([
                'success' => true,
                'message' => 'Deed closed successfully',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Deed closed failed',
            ]);
        }
    }

    public function print($id){
        $data = RentInfo::with('owners','flats','tenants')->findOrFail($id);
        return view('rent_info.rent_info.print', compact('data'));
    }
}
