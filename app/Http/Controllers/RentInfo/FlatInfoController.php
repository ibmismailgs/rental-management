<?php

namespace App\Http\Controllers\RentInfo;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RentInfo\FlatInfo;
use App\Models\RentInfo\OwnerInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FlatInfoController extends Controller
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

                $data = DB::table('owner_infos')
                    ->rightJoin('flat_infos', 'owner_infos.id', '=', 'flat_infos.owner_info_id')
                    ->whereNull('flat_infos.deleted_at')
                    ->whereNull('owner_infos.deleted_at')
                    ->select('owner_infos.owner_name', 'flat_infos.*')
                    ->orderByDesc('flat_infos.id')
                    ->get();
            }else{
                $data = DB::table('owner_infos')
                    ->rightJoin('flat_infos', 'owner_infos.id', '=', 'flat_infos.owner_info_id')
                    ->whereNull('flat_infos.deleted_at')
                    ->whereNull('owner_infos.deleted_at')
                    ->where('owner_infos.user_id', (Auth::user()->id))
                    ->select('owner_infos.owner_name', 'flat_infos.*')
                    ->orderByDesc('flat_infos.id')
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

                ->addColumn('total_bedroom', function ($data) {
                    $total = $data->bedroom + $data->master_bedroom + $data->guest_bedroom;
                    return $total;
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
                                <li><a class="dropdown-item" href="' . route('flat-report', $data->id) . ' " ><i class="fa fa-file" ></i> Report</a></li>
                                <li><a class="dropdown-item" href="' . route('flat-info.show', $data->id) . ' " ><i class="fa fa-eye" ></i> Details</a></li>
                                <li><a class="dropdown-item" href="' . route('flat-info.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('flat-info.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>';
                        }
                        return $action;
                    })

                ->addIndexColumn()
                ->rawColumns(['owner_name','total_bedroom','status','action'])
                ->toJson();
        }
            return view('rent_info.flat_info.index');
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
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $owners = DB::table('owner_infos')->where('deleted_at', null)->get();
        return view('rent_info.flat_info.create', compact('owners','user_role'));
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
            'flat_name.required'        => 'Enter flat name',
            'flat_size.required'        => 'Enter flat name',
            'bedroom.required'          => 'Enter total bedroom',
            'bathroom.required'         => 'Enter toal bathroom',
            'master_bedroom.required'   => 'Enter total master bedroom',
            'guest_bedroom.required'    => 'Enter total guest bedroom',
            'balcony.required'          => 'Enter total balcony',
            'owner_info_id .required'   => 'Select owner name',
        );

        $this->validate($request, array(
            'flat_name'         => 'required|string|',
            'flat_size'         => 'required|numeric|min:0|not_in:0',
            'bedroom'           => 'required|integer|',
            'bathroom'          => 'required|integer|',
            'master_bedroom'    => 'required|integer|',
            'guest_bedroom'     => 'required|integer|',
            'balcony'           => 'required|integer|',
            'owner_info_id'     => 'required|',
            'flat_photo.*' => 'required|max:2048|mimes:jpeg,png,jpg',
        ), $messages);

        try {
            $data = new FlatInfo();
            if ($request->file('flat_photo')) {
                $file = $request->file('flat_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->flat_photo = $filename;
            }

            $data->flat_name        = $request->flat_name;
            $data->flat_size        = $request->flat_size;
            $data->bedroom          = $request->bedroom;
            $data->bathroom         = $request->bathroom;
            $data->daining_space    = $request->daining_space;
            $data->master_bedroom   = $request->master_bedroom;
            $data->guest_bedroom    = $request->guest_bedroom;
            $data->balcony          = $request->balcony;
            $data->status           = $request->status;
            $data->owner_info_id    = $request->owner_info_id;
            $data->created_by       = Auth::user()->id;
            $data->save();

            return redirect()->route('flat-info.index')
                ->with('success', 'Flat info created successfully');
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
        $data = FlatInfo::with('owners')->findOrFail($id);
        $toalRoom = $data->bedroom + $data->master_bedroom + $data->guest_bedroom;
        return view('rent_info.flat_info.show', compact('data','toalRoom'));
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
        $data = FlatInfo::findOrFail($id);
        $owners = OwnerInfo::all();
        $toalRoom = $data->bedroom + $data->master_bedroom + $data->guest_bedroom;
        return view('rent_info.flat_info.edit', compact('data', 'owners','toalRoom','user_role'));
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
            'flat_name.required'        => 'Enter flat name',
            'flat_size.required'        => 'Enter flat name',
            'bedroom.required'          => 'Enter total bedroom',
            'bathroom.required'         => 'Enter toal bathroom',
            'master_bedroom.required'   => 'Enter total master bedroom',
            'guest_bedroom.required'    => 'Enter total guest bedroom',
            'balcony.required'          => 'Enter total balcony',
            'owner_info_id .required'   => 'Select owner name',
        );

        $this->validate($request, array(
            'flat_name'         => 'required|string|',
            'flat_size'         => 'required|numeric|min:0|not_in:0',
            'bedroom'           => 'required|numeric|',
            'bathroom'          => 'required|numeric|',
            'master_bedroom'    => 'required|numeric|',
            'guest_bedroom'     => 'required|numeric|',
            'balcony'           => 'required|numeric|',
            'owner_info_id'     => 'required|',
            'flat_photo.*'      => 'required|max:2048|mimes:jpeg,png,jpg,gif',
        ), $messages);

        try {
            $data = FlatInfo::findOrFail($id);
            if ($request->file('flat_photo')) {
                $file = $request->file('flat_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->flat_photo = $filename;
            }

            $data->flat_name        = $request->flat_name;
            $data->flat_size        = $request->flat_size;
            $data->bedroom          = $request->bedroom;
            $data->bathroom         = $request->bathroom;
            $data->daining_space    = $request->daining_space;
            $data->master_bedroom   = $request->master_bedroom;
            $data->guest_bedroom    = $request->guest_bedroom;
            $data->balcony          = $request->balcony;
            $data->status           = $request->status;
            $data->owner_info_id    = $request->owner_info_id;
            $data->updated_by       = Auth::user()->id;
            $data->update();

            return redirect()->route('flat-info.index')
                ->with('success', 'Flat info updated successfully');
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
            $data = FlatInfo::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Flat deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Flat delete failed',
            ]);
        }
    }

    public function StatusChange(Request $request)
    {
        $data = FlatInfo::findOrFail($request->id);
        $data->status = $data->status == 1 ? 0 : 1;
        $data->update();

        if ($data->status == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Flat status  is on',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Flat status is of',
            ]);
        }
    }
    public function Transaction(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('transactions')->where('flat_info_id', $id)->whereNull('deleted_at')->get();
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

                    ->addColumn('current_balance', function ($data) use (&$current_balance){
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
                    ->rawColumns(['date','month','debit_amount', 'purpose', 'credit_amount', 'current_balance'])
                    ->toJson();
            }
            return view('rent_info.flat_info.transaction');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
