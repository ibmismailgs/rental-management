<?php

namespace App\Http\Controllers\RentInfo;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RentInfo\OwnerInfo;
use Illuminate\Support\Facades\DB;
use App\Models\RentInfo\TenantInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TenantInfoController extends Controller
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
                  $data = DB::table('tenant_infos')
                        ->where('deleted_at', null)
                        ->orderBy('id', 'desc')
                        ->get();

                        $data = DB::table('owner_infos')
                            ->rightJoin('tenant_infos', 'owner_infos.id', '=', 'tenant_infos.owner_info_id')
                            ->whereNull('tenant_infos.deleted_at')
                            ->whereNull('owner_infos.deleted_at')
                            ->select('owner_infos.owner_name', 'tenant_infos.*')
                            ->orderByDesc('tenant_infos.id')
                            ->get();
                }else{
                    $data = DB::table('owner_infos')
                        ->rightJoin('tenant_infos', 'owner_infos.id', '=', 'tenant_infos.owner_info_id')
                        ->whereNull('tenant_infos.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->where('owner_infos.user_id', (Auth::user()->id))
                        ->select('owner_infos.owner_name', 'tenant_infos.*')
                        ->orderByDesc('tenant_infos.id')
                        ->get();
             }

            return Datatables::of($data)

                ->addColumn('gender', function ($data) {
                     if( $data->gender == 1 ){
                        $gender = 'Male';
                    }else{
                        $gender = 'Female';
                    }
                    return $gender;
                })

                    ->addColumn('action', function ($data) {
                        if(Auth::user()->can('manage_flat')){
                        $action = '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">
                                <li><a class="dropdown-item" href="' . route('tenant-report', $data->id) . ' " ><i class="fa fa-file" ></i> Report</a></li>
                                <li><a class="dropdown-item" href="' . route('tenant-info.show', $data->id) . ' " ><i class="fa fa-eye" ></i> Details</a></li>
                                <li><a class="dropdown-item" href="' . route('tenant-info.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('tenant-info.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>';
                        }
                        return $action;
                    })

                ->addIndexColumn()
                ->rawColumns(['gender','action'])
                ->toJson();
        }
        return view('rent_info.tenant_info.index');
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
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('rent_info.tenant_info.create', compact('owners','user_role'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'tenant_name.required'   => 'Enter tenant name',
            'owner_info_id.required' => 'Select owner name',
            'family_member.required' => 'Enter total family member',
            'contact_no.required' => 'Enter contact number',
            'email.required' => 'Enter email address',
            'gender.required' => 'Select your gender',
            'address.required' => 'Wrirte address',
        );

        $this->validate($request, array(
            'tenant_name' => 'required|',
            'gender' => 'required|',
            'address' => 'required|',
            'contact_no' => 'required||min:11|max:11|regex:/(01)[0-9]{9}/|unique:tenant_infos,contact_no,NULL,id,deleted_at,NULL',
            'email' => 'required|string|unique:tenant_infos,email,NULL,id,deleted_at,NULL',
            'tenant_photo.*' => 'required|max:2048|mimes:jpeg,png,jpg,gif',
        ), $messages);

        try {
            $data = new TenantInfo();
            if ($request->file('tenant_photo')) {
                $file = $request->file('tenant_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->tenant_photo = $filename;
            }

            foreach($request->file('card_photo') as $image) {
                $filename = time() . $image->getClientOriginalName();
                $image->move(public_path('/img/'), $filename);
                $photo[] = $filename;
            }

            $data->tenant_name = $request->tenant_name;
            $data->email = $request->email;
            $data->card_name  = json_encode($request->card_name);
            $data->card_no    = json_encode($request->card_no);
            $data->card_photo = json_encode($photo);
            $data->contact_no = $request->contact_no;
            $data->gender = $request->gender;
            $data->owner_info_id = $request->owner_info_id;
            $data->family_member = $request->family_member;
            $data->address = $request->address;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('tenant-info.index')
                ->with('success', 'Tenant created successfully');
        } catch (\Exception $exception) {
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
        $data = TenantInfo::with('owners')->findOrFail($id);
        return view('rent_info.tenant_info.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $data = TenantInfo::with('owners')->findOrFail($id);
        $owners = OwnerInfo::all();
        return view('rent_info.tenant_info.edit', compact('data', 'owners','user_role'));
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
            'tenant_name.required'   => 'Enter tenant name',
            'owner_info_id.required' => 'Select owner name',
            'family_member.required' => 'Enter total family member',
            'contact_no.required'    => 'Enter contact number',
            'email.required'         => 'Enter email address',
            'gender.required'        => 'Select your gender',
            'address.required'       => 'Wrirte address',
        );

        $this->validate($request, array(
            'tenant_name' => 'required',
            'gender'     => 'required',
            'address'    => 'required',
            'contact_no' => 'required||min:11|max:11|regex:/(01)[0-9]{9}/|unique:tenant_infos,contact_no,' . $id . ',id,deleted_at,NULL',
            'email'      => 'required|unique:tenant_infos,email,' . $id . ',id,deleted_at,NULL',
            'tenant_photo.*' => 'required|max:2048|mimes:jpeg,png,jpg',
        ), $messages);

        try {
            $data = TenantInfo::findOrFail($id);
            if ($request->file('tenant_photo')) {
                $file = $request->file('tenant_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->tenant_photo = $filename;
            }

            $photo = [];
            if($request->hasFile('card_photo')){
                foreach ($request->file('card_photo') as $image) {
                    $filename = time() . $image->getClientOriginalName();
                    $image->move(public_path('/img/'), $filename);
                    $photo[] = $filename;
                   }
            }

            if($request->old_card_photo){
                foreach ($request->old_card_photo as $image) {
                    $photo[] = $image;
                }

            }

            $data->tenant_name = $request->tenant_name;
            $data->email = $request->email;
            $data->card_name  = json_encode($request->card_name);
            $data->card_no    = json_encode($request->card_no);
            $data->card_photo = json_encode($photo);
            $data->contact_no = $request->contact_no;
            $data->gender = $request->gender;
            $data->owner_info_id = $request->owner_info_id;
            $data->family_member = $request->family_member;
            $data->address = $request->address;
            $data->updated_by = Auth::user()->id;
            $data->update();

            return redirect()->route('tenant-info.index')
                ->with('success', 'Tenant updated successfully');
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
        try {
            $data = TenantInfo::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Tenant deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant delete failed',
            ]);
        }
    }
    public function Transaction(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('transactions')->where('tenant_info_id', $id)->where('deleted_at', null)->get();

                return Datatables::of($data)

                    ->addColumn('date', function ($data) {
                        $date = Carbon::parse($data->date)->format('d F, Y');
                        return $date;
                    })

                    ->addColumn('month', function ($data) {
                        $date = Carbon::parse($data->rental_month)->format('F, Y');
                        return $date;
                    })

                    ->addColumn('purpose', function ($data) {
                        if ($data->transaction_purpose == 1) {
                            $purpose = 'Rent Pay';
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
                    ->rawColumns(['date','month', 'purpose', 'credit_amount', 'current_balance'])
                    ->toJson();
            }
            return view('rent_info.tenant_info.transaction');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
