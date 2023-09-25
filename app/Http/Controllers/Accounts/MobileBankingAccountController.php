<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts\MobileBanking;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Accounts\MobileBankingAccount;
use Carbon\Carbon;

class MobileBankingAccountController extends Controller
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
                    $data = DB::table('mobile_banking_accounts')
                        ->join('mobile_bankings', 'mobile_banking_accounts.mobile_banking_id', '=', 'mobile_bankings.id')
                        ->join('owner_infos', 'mobile_banking_accounts.owner_info_id', '=', 'owner_infos.id')
                        ->select('mobile_banking_accounts.*', 'mobile_bankings.name','owner_infos.owner_name')
                        ->whereNull('mobile_banking_accounts.deleted_at')
                        ->whereNull('mobile_bankings.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->orderByDesc('mobile_banking_accounts.id')
                        ->get();
                  }else{
                    $data = DB::table('mobile_banking_accounts')
                        ->join('mobile_bankings', 'mobile_banking_accounts.mobile_banking_id', '=', 'mobile_bankings.id')
                        ->join('owner_infos', 'mobile_banking_accounts.owner_info_id', '=', 'owner_infos.id')
                        ->select('mobile_banking_accounts.*', 'mobile_bankings.name','owner_infos.owner_name')
                        ->whereNull('mobile_banking_accounts.deleted_at')
                        ->whereNull('mobile_bankings.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->where('owner_infos.user_id', (Auth::user()->id))
                        ->orderByDesc('mobile_banking_accounts.id')
                        ->get();

                }

                return Datatables::of($data)

                ->addColumn('owner_name', function ($data) {
                    if (Auth::user()->id == $data->owner_info_id){
                        return $data->owner_name;
                    }else{
                        return $data->owner_name;
                    }
                })

                ->addColumn('status', function ($data) {
                    $button = '<label class="switch">';
                    $button .= ' <input type="checkbox" class="changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                    if ($data->status == 1) {
                        $button .= "checked";
                    }
                    $button .= ' ><span class="slider round"></span>';
                    $button .= '</label>';
                    return $button;
                })

                ->addColumn('action', function ($data) {
                    if(Auth::user()->can('manage_flat')){
                    $action = '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">
                                <li><a class="dropdown-item" id="('.$data->id.')" href="' . route('mobile-account.report', $data->id) . ' " ><i class="fa fa-file" ></i> Report</a></li>
                                <li><a class="dropdown-item" href="' . route('mobile-banking-account.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('mobile-banking-account.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>

                            </ul>
                        </div>';
                     }
                    return $action ;
                })

                ->addIndexColumn()
                ->rawColumns(['owner_name','status','action'])
                ->toJson();
            }
            return view('accounts.mobile_banking_account.index');

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
        $mobileBankings = MobileBanking::where('status', 1)->get();
        $owners = DB::table('owner_infos')->where('deleted_at', null)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('accounts.mobile_banking_account.create', compact('mobileBankings','owners','user_role'));
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
            'mobile_banking_id.required'   => 'Select mobile banking name',
            'owner_info_id.required'   => 'Select owner name',
            'mobile_no.required'   => 'Enter mobile no',
        );

        $this->validate($request, array(
            'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:17|',
        ), $messages);

        try {
            $data = new MobileBankingAccount();
            $data->mobile_banking_id = $request->mobile_banking_id;
            $data->owner_info_id = $request->owner_info_id;
            $data->mobile_no = $request->mobile_no;
            $data->status = $request->status;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('mobile-banking-account.index')
                ->with('success', 'Mobile banking created successfully');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MobileBankingAccount::findOrFail($id);
        $mobileBankings = MobileBanking::where('status', 1)->get();
        $owners = DB::table('owner_infos')->where('deleted_at', null)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('accounts.mobile_banking_account.edit', compact('data','mobileBankings','owners','user_role'));
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
            'mobile_banking_id.required'   => 'Select mobile banking name',
            'owner_info_id.required'   => 'Select owner',
            'mobile_no.required'   => 'Enter mobile no',
        );

        $this->validate($request, array(
            'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:17|',
        ), $messages);

        try {
            $data = MobileBankingAccount::findOrFail($id);
            $data->mobile_banking_id = $request->mobile_banking_id;
            $data->owner_info_id = $request->owner_info_id;
            $data->mobile_no = $request->mobile_no;
            $data->status = $request->status;
            $data->updated_by = Auth::user()->id;
            $data->update();

            return redirect()->route('mobile-banking-account.index')
                ->with('success', 'Mobile banking account updated successfully');
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
            $data = MobileBankingAccount::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Mobile banking account deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile banking account delete failed',
            ]);
        }
    }
    public function StatusChange(Request $request)
    {
        $data = MobileBankingAccount::findOrFail($request->id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->update();

        if ($data->status == 1) {
            return response()->json([
                'success' => true,
                'message' => 'This item status activated successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This item status inactivated successfully',
            ]);
        }
    }

    public function Transaction(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
            $data = DB::table('transactions')->where('mobile_banking_id', $id)->where('deleted_at', null)->get();

            return Datatables::of($data)

                ->addColumn('date', function ($data) {
                    $date = Carbon::parse($data->date)->format('d F, Y');
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

                ->addColumn('debit_amount', function ($data) {
                    if ($data->transaction_purpose == 3) {
                        $total_amount = json_decode($data->amount);
                        $result = array_sum($total_amount);
                        return $result;
                    } else {
                        return  '--';
                    }
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

                    if ($data->transaction_purpose == 3) {
                        $debit = json_decode($data->amount);
                        $debitSum = array_sum($debit);
                        $current_balance = $current_balance - $debitSum;
                        return (number_format($current_balance));
                    }
                })

                ->addIndexColumn()
                ->rawColumns(['date','debit_amount','purpose','credit_amount','current_balance'])
                ->toJson();
        }
        return view('accounts.mobile_banking_account.transaction');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
