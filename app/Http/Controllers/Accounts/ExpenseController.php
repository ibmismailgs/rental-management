<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use App\Models\RentInfo\FlatInfo;
use App\Models\RentInfo\OwnerInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Accounts\BankAccount;
use App\Models\Accounts\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts\ExpenseCategory;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Accounts\MobileBankingAccount;


class ExpenseController extends Controller
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
                $data = DB::table('transactions')
                    ->Join('flat_infos', 'flat_infos.id', '=', 'transactions.flat_info_id')
                    ->Join('owner_infos', 'owner_infos.id', '=', 'flat_infos.owner_info_id')
                    ->select('transactions.*', 'flat_infos.flat_name','owner_infos.owner_name')
                    ->whereNull('transactions.deleted_at')
                    ->whereNull('flat_infos.deleted_at')
                    ->whereNull('owner_infos.deleted_at')
                    ->where('transactions.transaction_purpose', 3)
                    ->get();
              }else{
                $data = DB::table('transactions')
                    ->Join('flat_infos', 'flat_infos.id', '=', 'transactions.flat_info_id')
                    ->Join('owner_infos', 'owner_infos.id', '=', 'flat_infos.owner_info_id')
                    ->select('transactions.*', 'flat_infos.flat_name','owner_infos.owner_name')
                    ->whereNull('transactions.deleted_at')
                    ->whereNull('flat_infos.deleted_at')
                    ->whereNull('owner_infos.deleted_at')
                    ->where('transactions.transaction_purpose', 3)
                    ->where('owner_infos.user_id', (Auth::user()->id))
                    ->get();
            }

            return Datatables::of($data)

                ->addColumn('category_name', function ($data) {

                    $expenseCategories = ExpenseCategory::all();
                    $categories = json_decode($data->expense_category_id);
                    $expenseAmount = json_decode($data->amount);
                    $categoriesName = [];

                        foreach ($categories as $key => $value){
                            foreach ($expenseCategories as $expenseCategorie){
                                if($expenseCategorie->id == $value){
                                    $categoriesName[] = $expenseCategorie->category_name . ' => ' . $expenseAmount[$key].',';
                                    $result = implode("</br>", $categoriesName);
                                }
                            }
                        }
                        return $result;
                })

                ->addColumn('total_amount', function ($data) {
                    $total_amount = json_decode($data->amount);
                    $result = array_sum($total_amount);
                    return $result;
                })

                ->addColumn('action', function ($data) {
                    if(Auth::user()->can('manage_flat')){
                    $action = '<div class="btn-group open">
                            <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                            <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">
                                <li><a class="dropdown-item" href="' . route('expense.show', $data->id) . ' " ><i class="fa fa-eye" ></i> Details</a></li>
                                <li><a class="dropdown-item" href="' . route('expense.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('expense.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>';
                    }
                    return $action ;
                })

                ->addIndexColumn()
                ->rawColumns(['category_name','total_amount','action'])
                ->toJson();
        }
        return view('accounts.expense.index');
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
        $categories = ExpenseCategory::where('status', 1)->get();
        $banks = BankAccount::with('banks','owners')->where('status', 1)->get();
        $mobilebanks = MobileBankingAccount::with('mobileBankings','owners')->where('status', 1)->get();
        $flats = FlatInfo::where('status', 1)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();

        return view('accounts.expense.create', compact('owners','categories','banks','mobilebanks','flats','user_role'));
    }

    //current balance
    public function currentBalance(Request $request)
    {
        try {
             $bankCredit = Transaction::where('account_id', $request->account_id)->whereIn('transaction_purpose', [1, 2])->get();

            $bankCreditAmount = [];
            foreach ($bankCredit as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $bankCreditAmount[]= $total;
            }

            $totalBankCreditAmount = array_sum($bankCreditAmount);

            $bankDebit = Transaction::where('account_id', $request->account_id)->where('transaction_purpose', 3)->get();

            $bankDebitAmount = [];
            foreach ($bankDebit as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $bankDebitAmount[]  = $total;
            }

            $totalBankDebitAmount = array_sum($bankDebitAmount);

            $CurrentBankAmount = (float)$totalBankCreditAmount - (float)$totalBankDebitAmount;

            $mobileCredit = Transaction::where('mobile_banking_id', $request->mobile_banking_id)->whereIn('transaction_purpose', [1, 2])->get();

            $mobileCreditAmount = [];
            foreach ($mobileCredit as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $mobileCreditAmount[] = $total;
            }

            $totalMobileCreditAmount = array_sum($mobileCreditAmount);

            $mobileDebit = Transaction::where('mobile_banking_id', $request->mobile_banking_id)->where('transaction_purpose', 3)->get();

            $mobileDebitAmount = [];
            foreach ($mobileDebit as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $mobileDebitAmount[] = $total;
            }

            $totalMobileDebitAmount = array_sum($mobileDebitAmount);

            $CurrentMobileAmount = (float)$totalMobileCreditAmount - (float)$totalMobileDebitAmount;

            $cashCredit = Transaction::where('payment_method', $request->payment_method)->whereIn('transaction_purpose', [1, 2])->get();

            $cashCreditAmount = [];
            foreach ($cashCredit as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $cashCreditAmount[]  = $total;
            }
            $totalCashCreditAmount = array_sum($cashCreditAmount);

            $cashDebit = Transaction::where('payment_method', $request->payment_method)->where('transaction_purpose', 3)->get();

            $CashDebitAmount = [];
            foreach ($cashDebit as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $CashDebitAmount[] = $total;
            }
            $totalCashDebitAmount =  array_sum($CashDebitAmount);

            $CurrentCashAmount = (float)$totalCashCreditAmount - (float)$totalCashDebitAmount;

            return response()->json([
                'CurrentCashBalance'   => $CurrentCashAmount,
                'CurrentBankAmount'    => $CurrentBankAmount,
                'CurrentMobileBalance' => $CurrentMobileAmount,
            ]);

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
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
            'date.required' => 'Enter date',
            'owner_info_id.required' => 'Select owner name',
            'flat_info_id.required' => 'Select flat name',
            'payment_method.required' => 'Select payment method',
            'expense_category_id.required' => 'Select expense category',
            'amount.required' => 'Enter expense amount',
        );

        $this->validate($request, array(
            'date' => 'required',
            'owner_info_id' => 'required',
            'payment_method' => 'required',
            'flat_info_id' => 'required',
        ), $messages);

        if($request->cash_amount != 0){
            if($request->cash_amount < $request->total_amount){
                return redirect()->back()->with('error', "You don't have sufficient balance");
            }
        }else if($request->bank_amount != 0){
            if($request->bank_amount < $request->total_amount){
                return redirect()->back()->with('error', "You don't have sufficient balance");
            }
        }else if($request->mobile_amount != 0){
            if($request->mobile_amount < $request->total_amount){
                return redirect()->back()->with('error', "You don't have sufficient balance");
            }
        }

        try {
            $data = new Transaction();
            $data->owner_info_id         = $request->owner_info_id;
            $data->flat_info_id          = $request->flat_info_id;
            $data->date                  = $request->date;
            $data->amount                = json_encode($request->amount);
            $data->expense_category_id   = json_encode($request->expense_category_id);
            $data->account_id            = $request->account_id;
            $data->mobile_banking_id     = $request->mobile_banking_id;
            $data->payment_method        = $request->payment_method;
            $data->mobile_transaction_id = $request->mobile_transaction_id ;
            $data->transaction_purpose   = 3;
            $data->created_by            = Auth::user()->id;
            $data->save();

            return redirect()->route('expense.index')
                ->with('success', 'Flat expense created successfully');
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
        $data = Transaction::with('owners','flats')->findOrFail($id);
        $expenseCategories = ExpenseCategory::all();
        return view('accounts.expense.show', compact('data','expenseCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaction::findOrFail($id);
        $owners = OwnerInfo::all();
        $flats = FlatInfo::all();
        $categories = ExpenseCategory::where('status', 1)->get();
        $banks = BankAccount::with('banks','owners')->where('status', 1)->get();
        $mobilebanks = MobileBankingAccount::with('mobileBankings','owners')->where('status', 1)->get();
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        return view('accounts.expense.edit', compact('data', 'owners','flats','categories', 'banks', 'mobilebanks','user_role'));
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
            'date.required' => 'Enter date',
            'owner_info_id.required' => 'Select owner name',
            'flat_info_id.required' => 'Select flat name',
            'payment_method.required' => 'Select payment method',
            'expense_category_id.required' => 'Select expense category',
            'amount.required' => 'Enter expense amount',
        );

        $this->validate($request, array(
            'date' => 'required',
            'owner_info_id' => 'required',
            'payment_method' => 'required',
            'flat_info_id' => 'required',
        ), $messages);

        if($request->cash_amount != 0){
            if($request->cash_amount < $request->total_amount){
                return redirect()->back()->with('error', "You don't have sufficient balance");
            }
        }else if($request->bank_amount != 0){
            if($request->bank_amount < $request->total_amount){
                return redirect()->back()->with('error', "You don't have sufficient balance");
            }
        }else if($request->mobile_amount != 0){
            if($request->mobile_amount < $request->total_amount){
                return redirect()->back()->with('error', "You don't have sufficient balance");
            }
        }

        try {
            $data = Transaction::findOrFail($id);
            $data->owner_info_id         = $request->owner_info_id;
            $data->flat_info_id          = $request->flat_info_id;
            $data->date                  = $request->date;
            $data->amount                = json_encode($request->amount);
            $data->expense_category_id   = json_encode($request->expense_category_id);
            $data->account_id            = $request->account_id;
            $data->mobile_banking_id     = $request->mobile_banking_id;
            $data->payment_method        = $request->payment_method;
            $data->mobile_transaction_id = $request->mobile_transaction_id;
            $data->transaction_purpose   = 3;
            $data->created_by            = Auth::user()->id;
            $data->update();

            return redirect()->route('expense.index')
            ->with('success', 'Flat expense updated successfully');
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
            $data = Transaction::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Expense deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Expense delete failed',
            ]);
        }
    }
}
