<?php

namespace App\Http\Controllers\Accounts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Accounts\Bank;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Accounts\BankAccount;
use App\Models\RentInfo\OwnerInfo;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BankAccountController extends Controller
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
                    $data = DB::table('bank_accounts')
                        ->join('banks', 'bank_accounts.bank_id', '=', 'banks.id')
                        ->join('owner_infos', 'bank_accounts.owner_info_id', '=', 'owner_infos.id')
                        ->select('bank_accounts.*', 'banks.bank_name','owner_infos.owner_name')
                        ->whereNull('bank_accounts.deleted_at')
                        ->whereNull('banks.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->orderByDesc('bank_accounts.id')
                        ->get();
                }else{
                    $data = DB::table('bank_accounts')
                        ->join('banks', 'bank_accounts.bank_id', '=', 'banks.id')
                        ->join('owner_infos', 'bank_accounts.owner_info_id', '=', 'owner_infos.id')
                        ->select('bank_accounts.*', 'banks.bank_name','owner_infos.owner_name')
                        ->whereNull('bank_accounts.deleted_at')
                        ->whereNull('banks.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->where('owner_infos.user_id', (Auth::user()->id))
                        ->orderByDesc('bank_accounts.id')
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
                        $action = '<div class="btn-group open">
                        <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                        <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">
                            <li><a class="dropdown-item" id="('.$data->id.')" href="' . route('bank-account.report', $data->id) . ' " ><i class="fa fa-file" ></i> Report</a></li>
                            <li><a class="dropdown-item" href="' . route('bank-account.show', $data->id) . ' "><i class="fa fa-eye"></i> Details</a></li>
                            <li><a class="dropdown-item" href="' . route('bank-account.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>

                            <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('bank-account.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>

                        </ul>
                       </div>';
                        return $action ;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['owner_name','status', 'action'])
                    ->toJson();
            }
            return view('accounts.bank_account.index');
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
        $banks = Bank::where('status', 1)->get();
        $owners = DB::table('owner_infos')->where('deleted_at', null)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('accounts.bank_account.create', compact('banks','owners','user_role'));
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
            'date.required'   => 'Enter date name',
            'bank_id.required'   => 'Select bank name',
            'owner_info_id.required'   => 'Select owner name',
            'account_no.required'   => 'Enter account no',
            'branch_name.required'   => 'Enter branch name',
            'branch_address.required'   => 'Write branch address',
        );

        $this->validate($request, array(
            'account_no' => 'required|regex:([0-9\s\-\+\(\)]*)|min:9|max:17|unique:bank_accounts,account_no,NULL,id,deleted_at,NULL',
        ), $messages);

        try {
            $data = new BankAccount();
            $data->date = $request->date;
            $data->bank_id = $request->bank_id;
            $data->owner_info_id = $request->owner_info_id;
            $data->account_no = $request->account_no;
            $data->branch_name = $request->branch_name;
            $data->branch_address = $request->branch_address;
            $data->status = $request->status;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('bank-account.index')
                ->with('success', 'Bank account created successfully');
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
        $data = BankAccount::with('banks','owners')->findOrFail($id);
        return view('accounts.bank_account.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = BankAccount::findOrFail($id);
        $banks = Bank::where('status', 1)->get();
        $owners = OwnerInfo::all();
        $auth = Auth::user();
        $user_role = $auth->roles->first();

        return view('accounts.bank_account.edit', compact('data', 'banks','owners','user_role'));
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
            'date.required'   => 'Enter date name',
            'bank_id.required'   => 'Select bank name',
            'owner_info_id.required'   => 'Select owner name',
            'account_no.required'   => 'Enter account no',
            'branch_name.required'   => 'Enter branch name',
            'branch_address.required'   => 'Write branch address',
        );

        $this->validate($request, array(
            'account_no' => 'required|regex:([0-9\s\-\+\(\)]*)|min:9|max:17|unique:bank_accounts,account_no,'. $id .',id,deleted_at,NULL',
        ), $messages);

        try {
            $data = BankAccount::findOrFail($id);
            $data->date = $request->date;
            $data->bank_id = $request->bank_id;
            $data->owner_info_id = $request->owner_info_id;
            $data->account_no = $request->account_no;
            $data->branch_name = $request->branch_name;
            $data->branch_address = $request->branch_address;
            $data->status = $request->status;
            $data->updated_by = Auth::user()->id;
            $data->update();

            return redirect()->route('bank-account.index')
            ->with('success', 'Bank account updated successfully');
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
            $data = BankAccount::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Bank account deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Bank account delete failed',
            ]);
        }
    }
    public function StatusChange(Request $request)
    {
        $data = BankAccount::findOrFail($request->id);
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
            $data = DB::table('transactions')->where('account_id', $id)->where('deleted_at', null)->get();
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
        return view('accounts.bank_account.transaction');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
