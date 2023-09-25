<?php

namespace App\Http\Controllers\RentInfo;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RentInfo\OwnerInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class OwnerInfoController extends Controller
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
                      ->where('deleted_at', null)
                      ->orderBy('id', 'desc')
                      ->get();
              }else{
                $data = DB::table('owner_infos')
                      ->where('id', (Auth::user()->owners->id))
                      ->where('deleted_at', null)
                      ->orderBy('id', 'desc')
                      ->get();
            }

            return Datatables::of($data)

            ->addColumn('gender', function ($data) {
                if ($data->gender == 1) {
                     $gender = 'Male';
                } else {
                    $gender = 'Female';
                }
                return $gender;
            })

            ->addColumn('action', function ($data) {

                    $result = '';

                    $profile = '<li><a class="dropdown-item" href="' . route('profile', $data->id) . ' " ><i class="fa fa-user" ></i> Profile</a></li>';

                    $report = ' <li><a class="dropdown-item" href="' . route('owner-report', $data->id) . ' " ><i class="fa fa-file" ></i> Report</a></li>';

                    $details = '<li><a class="dropdown-item" href="' . route('owner-info.show', $data->id) . ' " ><i class="fa fa-eye" ></i> Details</a></li>';

                    $edit = '<li><a class="dropdown-item" href="' . route('owner-info.edit', $data->id) . ' "><i class="fa fa-edit"></i> Edit</a></li>';

                    $delete = '<li><a class="dropdown-item btn-delete" href="#" data-remote=" ' . route('owner-info.destroy', $data->id) . ' "><i class="fa fa-trash"></i> Delete</a></li>';

                    if(Auth::user()->can('manage_user')){
                        $result = $profile. $report. $details. $edit. $delete;
                    }else if(Auth::user()->can('manage_owner')){
                        $result = $profile. $report. $details. $edit;
                    }

                    return '<div class="btn-group open">
                    <a class="badge badge-primary dropdown-toggle" href="#" role="button"  data-toggle="dropdown">Actions<i class="ik ik-chevron-down mr-0 align-middle"></i></a>
                    <ul class="dropdown-menu" role="menu" style="width:auto; min-width:auto;">'.$result.'
                    </ul>
                </div>';

            })

            ->addIndexColumn()
            ->rawColumns(['gender','action'])
            ->toJson();
        }
         return view('rent_info.owner_info.index');
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
        return view('rent_info.owner_info.create');
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
            'owner_name.required' => 'Enter owner name',
            'contact_no.required' => 'Enter contact number',
            'email.required' => 'Enter email address',
            'gender.required' => 'Select your gender',
            'address.required' => 'Wrirte address',
        );

        $this->validate($request, array(
            'owner_name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'contact_no' => 'required||min:11|max:11|regex:/(01)[0-9]{9}/|unique:owner_infos,contact_no,NULL,id,deleted_at,NULL',
            'email' => 'required|string|unique:owner_infos,email,NULL,id,deleted_at,NULL',
            'owner_photo.*' => 'required|max:2048|mimes:jpeg,png,jpg',
        ), $messages);

        DB::beginTransaction();

        try {
            $user = new User();
            $user->name  = $request->owner_name;
            $user->email = $request->email;
            $user->type = 2;
            $user->password  = Hash::make('1234');
            $user->save();

            $user->syncRoles(2);

            $data = new OwnerInfo();

            foreach($request->file('card_photo') as $image) {
                $filename = time() . $image->getClientOriginalName();
                $image->move(public_path('/img/'), $filename);
                $photo[] = $filename;
            }

            if ($request->file('owner_photo')) {
                $file = $request->file('owner_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->owner_photo = $filename;
            }

            $data->user_id    = $user->id;
            $data->owner_name = $request->owner_name;
            $data->card_name  = json_encode($request->card_name);
            $data->card_no    = json_encode($request->card_no);
            $data->card_photo = json_encode($photo);
            $data->email      = $request->email;
            $data->gender     = $request->gender;
            $data->address    = $request->address;
            $data->contact_no = $request->contact_no;
            $data->created_by = Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect()->route('owner-info.index')
                ->with('success', 'Owner created successfully');
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
        $data = OwnerInfo::findOrFail($id);
        return view('rent_info.owner_info.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = OwnerInfo::findOrFail($id);
        return view('rent_info.owner_info.edit', compact('data'));
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
            'owner_name.required' => 'Enter owner name',
            'contact_no.required' => 'Enter contact number',
            'email.required'      => 'Enter email address',
            'gender.required'     => 'Select your gender',
            'address.required'    => 'Wrirte address',
        );

        $this->validate($request, array(
            'owner_name' => 'required',
            'gender'     => 'required',
            'address'    => 'required',
            'contact_no' => 'required||min:11|max:11|regex:/(01)[0-9]{9}/|unique:owner_infos,contact_no,' . $id . ',id,deleted_at,NULL',
            'email'      => 'required|unique:owner_infos,email,' . $id . ',id,deleted_at,NULL',
            'owner_photo.*' => 'required|max:2048|mimes:jpeg,png,jpg',
        ), $messages);

        DB::beginTransaction();

        try {

            $data = OwnerInfo::findOrFail($id);

            if ($request->file('owner_photo')) {
                $file = $request->file('owner_photo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->owner_photo = $filename;
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

            $data->owner_name = $request->owner_name;
            $data->card_name  = json_encode($request->card_name);
            $data->card_no    = json_encode($request->card_no);
            $data->card_photo = json_encode($photo);
            $data->email      = $request->email;
            $data->gender     = $request->gender;
            $data->address    = $request->address;
            $data->contact_no = $request->contact_no;
            $data->updated_by = Auth::user()->id;
            $data->update();

            $user = User::where('id', $data->user_id)->first();
            $user->name = $request->owner_name;
            $user->email  = $request->email;
            $user->type = 2;
            $user->update();

            DB::commit();

            return redirect()->route('owner-info.index')
                ->with('success', 'Owner updated successfully');
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
            $data = OwnerInfo::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Owner deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Owner delete failed',
            ]);
        }
    }

    public function Transaction(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $data = DB::table('transactions')->where('owner_info_id', $id)->whereNull('deleted_at')->get();
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
                    ->rawColumns(['date', 'debit_amount', 'purpose', 'credit_amount', 'current_balance'])
                    ->toJson();
            }
            return view('rent_info.owner_info.transaction');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function profile($id){
        $data = OwnerInfo::findOrFail($id);
        return view('rent_info.owner_info.profile', compact('data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        DB::beginTransaction();

         Validator::make($request->all(), [
            'email' => 'required|unique:users,email,' . $id . ',id,deleted_at,NULL',
        ]);

        try {

            $data = OwnerInfo::findOrFail($id);
            $data->owner_name = $request->owner_name;
            $data->email      = $request->email;
            $data->contact_no = $request->contact_no;
            $data->address    = $request->address;
            $data->updated_by = Auth::user()->id;
            $data->update();

            $user = User::where('id', $data->user_id)->first();
            $user->name = $request->owner_name;
            $user->email  = $request->email;
            $user->update();

            DB::commit();

            return redirect()->route('owner-info.index')
                ->with('success', 'Profile updated successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}

