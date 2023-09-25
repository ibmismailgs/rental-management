<?php

namespace App\Http\Controllers\RentInfo;

use Carbon\Carbon;
use App\Mail\SendEmail;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Accounts\BankAccount;
use App\Models\Accounts\Installment;
use App\Models\Accounts\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Accounts\MobileBankingAccount;

class RentCollectController extends Controller
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
                        ->Join('rent_infos', 'rent_infos.id', '=', 'transactions.rent_info_id')
                        ->Join('owner_infos', 'owner_infos.id', '=', 'transactions.owner_info_id')
                        ->Join('tenant_infos', 'tenant_infos.id', '=', 'transactions.tenant_info_id')
                        ->Join('flat_infos', 'flat_infos.id', '=', 'transactions.flat_info_id')
                         ->select('transactions.*','flat_infos.flat_name','tenant_infos.tenant_name','owner_infos.owner_name','rent_infos.total_rent','rent_infos.rent_title')
                        ->whereNull('transactions.deleted_at')
                        ->whereNull('rent_infos.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->whereNull('tenant_infos.deleted_at')
                        ->whereNull('flat_infos.deleted_at')
                        ->whereIn('transactions.transaction_purpose', [1, 2])
                        ->groupBy(['transactions.rental_month', 'transactions.rent_info_id'])
                        ->get();
                  }else{
                    $data = DB::table('transactions')
                        ->Join('rent_infos', 'rent_infos.id', '=', 'transactions.rent_info_id')
                        ->Join('owner_infos', 'owner_infos.id', '=', 'transactions.owner_info_id')
                        ->Join('tenant_infos', 'tenant_infos.id', '=', 'transactions.tenant_info_id')
                        ->Join('flat_infos', 'flat_infos.id', '=', 'transactions.flat_info_id')
                        ->select('transactions.*','flat_infos.flat_name','tenant_infos.tenant_name','owner_infos.owner_name','rent_infos.total_rent','rent_infos.rent_title')
                        ->whereNull('transactions.deleted_at')
                        ->whereNull('rent_infos.deleted_at')
                        ->whereNull('owner_infos.deleted_at')
                        ->whereNull('tenant_infos.deleted_at')
                        ->whereNull('flat_infos.deleted_at')
                        ->where('owner_infos.user_id', (Auth::user()->id))
                        ->whereIn('transactions.transaction_purpose', [1, 2])
                        ->groupBy(['transactions.rental_month', 'transactions.rent_info_id'])
                        ->get();
                }

            return Datatables::of($data)

                ->addColumn('rentalMonth', function ($data) {
                    $date = Carbon::parse($data->rental_month)->format('F, Y');
                    return $date;
                })

                ->addColumn('rent_status', function ($data) {

                    $rentAmount = DB::table('transactions')->where('rent_info_id', $data->rent_info_id)->where('deleted_at', null)->where('rental_month', $data->rental_month)->get();

                    $TotalRentAmount = [];
                    foreach ($rentAmount as $key => $value) {
                        $balance = $value->amount;
                        $total   = json_decode($balance);
                        $TotalRentAmount[] = $total;
                    }

                    $result =  array_sum($TotalRentAmount);
                    $rent_status = $data->total_rent - $result;

                    if($rent_status == 0){
                        $value ='<span class="badge badge-success" title="Paid">Paid</span>';
                    }else{
                        $value ='<a href="' . route('due-collect', $data->id) . ' " class="badge badge-danger" title="Due">Due</a>';
                    }

                    return $value ;
                })

                ->addColumn('received_rent', function ($data) {

                    $rentAmount =  DB::table('transactions')->where('rent_info_id', $data->rent_info_id)->where('deleted_at', null)->where('rental_month', $data->rental_month)->get();

                    $TotalRentAmount = [];
                    foreach ($rentAmount as $key => $value) {
                        $balance = $value->amount;
                        $total   = json_decode($balance);
                        $TotalRentAmount[] = $total;
                    }

                    $result = array_sum($TotalRentAmount);
                    return $result;
                })

                ->addColumn('collection_type', function ($data) {
                    if ($data->transaction_purpose == 1) {
                        $purpose = 'Rent Collect';
                    } elseif ($data->transaction_purpose == 2) {
                        $purpose = 'Due Collect';
                    }
                    return $purpose;
                })

            ->addColumn('action', function ($data) {
                if(Auth::user()->can('manage_flat')){

                $btn = '<a id="edit" href="' . route('rent-collect-transaction', $data->rent_info_id . '/' .$data->rental_month) . ' " class="btn btn-sm btn-primary show" title="Details"><i class="fa fa-eye"></i></a>';

                }
                return $btn ;
            })

            ->addIndexColumn()
            ->rawColumns(['rentalMonth','received_rent','rent_status','action'])
            ->toJson();
        }
        return view('rent_info.rent_collect.index');

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    use SmsTrait;
    public function store(Request $request)
    {
        $messages = array(
            'rental_month.required'   => 'Enter rental month',
            'receive_amount.required' => 'Enter receive amount',
        );

        $this->validate($request, array(
            'receive_amount' => 'required|numeric|min:0|not_in:0',
            'payment_method' => 'required|',
            'rental_month'   => 'required|',
        ), $messages);

        if ($request->receive_amount > $request->total_rent) {
            return redirect()->back()->with('error', "Received amount can't be more than total amount");
        }

        DB::beginTransaction();

        try {
            $due = new Installment();
            $due->rent_info_id = $request->rent_info_id;
            $due->rental_month = $request->rental_month;
            $due->amount       = $request->receive_amount;
            $due->transaction_purpose   = $request->transaction_purpose;
            $due->created_by   = Auth::user()->id;
            $due->save();

            $data = new Transaction();
            $data->rent_info_id          = $request->rent_info_id;
            $data->owner_info_id         = $request->owner_info_id;
            $data->flat_info_id          = $request->flat_info_id;
            $data->tenant_info_id        = $request->tenant_info_id;
            $data->rental_month          = $request->rental_month;
            $data->amount                = json_encode($request->receive_amount);
            $data->account_id            = $request->account_id;
            $data->mobile_banking_id     = $request->mobile_banking_id;
            $data->payment_method        = $request->payment_method;
            $data->mobile_transaction_id = $request->mobile_transaction_id;
            $data->transaction_purpose   = $request->transaction_purpose;
            $data->created_by            = Auth::user()->id;
            $data->save();

            $tenant = Transaction::with('tenants','flats','rents')->findOrFail($data->id);
            $name = $tenant->tenants->tenant_name;
            $contact = $tenant->tenants->contact_no;
            $email = $tenant->tenants->email;
            $flat = $tenant->flats->flat_name;
            $rent = $tenant->rents->total_rent;
            $month = Carbon::parse($tenant->rental_month)->format('F , Y');
            $amount = json_decode($tenant->amount);
            $date = Carbon::parse($tenant->created_at)->format('d M, Y');
            $result =  Transaction::where('rent_info_id', $tenant->rent_info_id)->get();

            $rentAmount = [];
            foreach ($result as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $rentAmount[]  = $total;
            }

            $totalRentAmount = array_sum($rentAmount);

            $due = $rent - $totalRentAmount;

            $msg = "Date : $date, Name: $name, E-mail : $email, Phone : $contact, Flat Name : $flat, Rental Month : $month, Flat Rent : $rent, Paid Amount : $amount, Due Amount : $due, ";

            if($data){
                // $this->SendSms($contact, $msg);
                // Mail::to($email)->send(new SendEmail($tenant, $due));
            }

            DB::commit();

            return redirect()->route('rent-collect.index')
                ->with('success', 'Rent collect created successfully');
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
        $data = Transaction::with('owners','flats','tenants','rents')->findOrFail($id);
        $rentAmount = DB::table('transactions')->where('rent_info_id', $data->rent_info_id)->where('rental_month', $data->rental_month)->where('deleted_at', null)->get();

        $TotalRentAmount = [];
        foreach($rentAmount as $key => $value) {
            $total   = json_decode($value->amount);
            $TotalRentAmount[] = $total;
        }

        $totalAmount = array_sum($TotalRentAmount);
        $due = ($data->rents->total_rent) - ($totalAmount);

        return view('rent_info.rent_collect.show', compact('data','totalAmount','due','total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Transaction::with('owners','flats','tenants','rents')->findOrFail($id);
        $banks = BankAccount::with('banks','owners')->where('status', 1)->get();
        $mobilebanks = MobileBankingAccount::with('mobileBankings','owners')->where('status', 1)->get();

        $rentAmount = Installment::where('rent_info_id', $data->rent_info_id)->where('rental_month', $data->rental_month)->get('amount');

        $TotalRentAmount = [];
        foreach($rentAmount as $key => $value) {
            $total   = json_decode($value->amount);
            $TotalRentAmount[] = $total;
        }

        $result = array_sum($TotalRentAmount);
        $due = ($data->rents->total_rent) - ($result);

        return view('rent_info.rent_collect.edit', compact('data','banks','mobilebanks','due'));
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
            'rental_month.required'   => 'Enter rental month',
            'receive_amount.required' => 'Enter receive amount',
        );

        $this->validate($request, array(
            'receive_amount' => 'required|numeric|min:0|not_in:0',
            'rental_month' => 'required|',
        ), $messages);

        if ($request->receive_amount > $request->total_rent) {
            return redirect()->back()->with('error', "Received amount can't be more than total amount");
        }

        DB::beginTransaction();

        try {
            $due = Installment::findOrFail($id);
            $due->rent_info_id = $request->rent_info_id;
            $due->rental_month = $request->rental_month;
            $due->amount       = $request->receive_amount;
            $due->updated_by  = Auth::user()->id;
            $due->update();

            $data = Transaction::findOrFail($id);
            $data->rent_info_id          = $request->rent_info_id;
            $data->owner_info_id         = $request->owner_info_id;
            $data->flat_info_id          = $request->flat_info_id;
            $data->tenant_info_id        = $request->tenant_info_id;
            $data->rental_month          = $request->rental_month;
            $data->amount                = json_encode($request->receive_amount);
            $data->account_id            = $request->account_id;
            $data->mobile_banking_id     = $request->mobile_banking_id;
            $data->payment_method        = $request->payment_method;
            $data->mobile_transaction_id = $request->mobile_transaction_id ;
            $data->transaction_purpose = 1;
            $data->updated_by = Auth::user()->id;
            $data->update();

            $tenant = Transaction::with('tenants','flats','rents')->findOrFail($data->id);
            $name = $tenant->tenants->tenant_name;
            $contact = $tenant->tenants->contact_no;
            $email = $tenant->tenants->email;
            $flat = $tenant->flats->flat_name;
            $rent = $tenant->rents->total_rent;
            $month = Carbon::parse($tenant->rental_month)->format('F , Y');
            $amount = json_decode($tenant->amount);
            $date = Carbon::parse($tenant->created_at)->format('d M, Y');

            $result =  Transaction::where('rent_info_id', $tenant->rent_info_id)->get();

            $rentAmount = [];
            foreach ($result as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $rentAmount[]  = $total;
            }

            $totalRentAmount = array_sum($rentAmount);
            $due = $rent - $totalRentAmount;
            $msg = "Date : $date, Name: $name, E-mail : $email, Phone : $contact, Flat Name : $flat, Rental Month : $month, Flat Rent : $rent, Paid Amount : $amount, Due Amount : $due";

            // $this->SendSms($contact, $msg);

            // Mail::to($email)->send(new SendEmail($tenant, $due));

            DB::commit();

            return Redirect::route('rent-collect-transaction', array('id' => $data->rent_info_id, 'month' => $data->rental_month))
                ->with('success', 'Rent collect updated successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
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
            $data = Transaction::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Rent collect deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Rent collect delete failed',
            ]);
        }
    }

    public function RentCheck(Request $request)
    {
        try {
            $rental_month = Carbon::parse($request->rental_month)->format('Y-m');
            $check = Transaction::where('rental_month', $rental_month)->where('rent_info_id', $request->id)->first();

            if ($check) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rent already taken for the selected month',
                ]);
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function revenue(Request $request)
    {
        try {

        if ($request->ajax()) {
            $data = DB::table('transactions')
                ->Join('rent_infos', 'rent_infos.id', '=', 'transactions.rent_info_id')
                ->Join('owner_infos', 'owner_infos.id', '=', 'transactions.owner_info_id')
                ->Join('tenant_infos', 'tenant_infos.id', '=', 'transactions.tenant_info_id')
                ->Join('flat_infos', 'flat_infos.id', '=', 'transactions.flat_info_id')
                ->select('transactions.*','flat_infos.flat_name','tenant_infos.tenant_name','owner_infos.owner_name','rent_infos.rent_title')
                ->whereNull('transactions.deleted_at')
                ->whereNull('rent_infos.deleted_at')
                ->whereNull('owner_infos.deleted_at')
                ->whereNull('tenant_infos.deleted_at')
                ->whereNull('flat_infos.deleted_at')
                ->whereIn('transactions.transaction_purpose', [1, 2])
                ->get();

            return Datatables::of($data)
                ->addColumn('date', function ($data) {
                    $date = Carbon::parse($data->created_at)->format('d F, Y');
                    return $date ;
                })

                ->addColumn('collection_type', function ($data) {
                    if ($data->transaction_purpose == 1) {
                        $purpose = 'Rent Collect';
                    } elseif ($data->transaction_purpose == 2) {
                        $purpose = 'Due Collect';
                    }
                    return $purpose;
                })

                ->addColumn('received_rent', function ($data) {
                    $rent = json_decode($data->amount);
                    return $rent;
                })

            ->addIndexColumn()
            ->rawColumns(['collection_type','received_rent','date'])
            ->toJson();
        }

        return view('rent_info.rent_collect.revenue');

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function RentCollectTransaction($id, $month)
    {
        try {
            $month = $month;
            $id = $id;
            return view('rent_info.rent_collect.monthlytransaction', compact('month','id'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function RentCollectList(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = DB::table('transactions')->where('rent_info_id', $request->id)->where('rental_month', $request->month)->whereNull('deleted_at')->get();

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
                        }
                        return $purpose;
                    })

                    ->addColumn('received_rent', function ($data) {
                        $rent = json_decode($data->amount);
                        return $rent;
                    })

                    ->addColumn('collection_type', function ($data) {
                        if ($data->transaction_purpose == 1) {
                            $purpose = 'Rent Collect';
                        } elseif ($data->transaction_purpose == 2) {
                            $purpose = 'Due Collect';
                        }
                        return $purpose;
                    })

                    ->addColumn('action', function ($data) {
                        if(Auth::user()->can('manage_flat')){
                        $action = '<div class="btn-group open">
                        <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                        <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">

                            <li><a class="dropdown-item" href="' . route('rent-collect.show', $data->id) . ' " ><i class="fa fa-eye" ></i> Details</a></li>

                            <li><a class="dropdown-item" href="' . route('rent-collect.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>

                            <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('rent-collect.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>
                        </ul>
                        </div>';
                        }
                        return $action ;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['date', 'purpose', 'received_rent', 'collection_type','action'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
