<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts\MobileBanking;
use Yajra\DataTables\Facades\DataTables;

class MobileBankingController extends Controller
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
                        $data = DB::table('mobile_bankings')
                              ->whereNull('deleted_at')
                              ->get();

                return Datatables::of($data)

                ->addColumn('status', function ($data) {
                    if (Auth::user()->can('manage_user')) {
                        $button = '<label class="switch">';
                        $button .= ' <input type="checkbox" class="changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= ' ><span class="slider round"></span>';
                        $button .= '</label>';
                        return $button;
                   }
                    elseif(Auth::user()->can('manage_mobile_banking')){
                        if ($data->status == 1) {
                            $button = '<span class="badge badge-primary" title="Active">Active</span>';
                        }else{
                            $button = '<span class="badge badge-danger" title="Inactive">Inactive</span>';
                        }
                        return $button;
                    }

                })

                 ->addColumn('action', function ($data) {

                    if (Auth::user()->can('manage_user')) {
                        $edit = '<a id="edit" href="' . route('mobile-banking.edit', $data->id) . ' " class="btn btn-sm btn-info edit" title="Edit"><i class="fa fa-edit"></i></a> ';
                    } else {
                        $edit = '';
                    }

                    if (Auth::user()->can('manage_user')) {
                        $delete = '<button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('mobile-banking.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                    } else {
                        $delete = '';
                    }
                    return $edit . $delete;
                })

                ->addIndexColumn()
                ->rawColumns(['status','action'])
                ->toJson();
            }
            return view('accounts.mobile_banking.index');

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
        return view('accounts.mobile_banking.create');
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
            'name.required'   => 'Enter mobile banking name',
        );

        $this->validate($request, array(
            'name' => 'required|unique:mobile_bankings,name,NULL,id,deleted_at,NULL',
        ), $messages);

        try {
            $data = new MobileBanking();
            $data->name = $request->name;
            $data->status = $request->status;
            $data->created_by = Auth::user()->id;
            $data->save();

            return redirect()->route('mobile-banking.index')
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
        $data = MobileBanking::findOrFail($id);
        return view('accounts.mobile_banking.edit', compact('data'));
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
            'name.required'   => 'Enter mobile banking name',
        );

        $this->validate($request, array(
            'name' => 'required|unique:mobile_bankings,name,' . $id . ',id,deleted_at,NULL',
        ), $messages);

        try {
            $data = MobileBanking::findOrFail($id);
            $data->name = $request->name;
            $data->status = $request->status;
            $data->updated_by = Auth::user()->id;
            $data->update();

            return redirect()->route('mobile-banking.index')
                ->with('success', 'Mbile banking updated successfully');
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
            $data = MobileBanking::findOrFail($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Mobile banking deleted successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile banking delete failed',
            ]);
        }
    }
    public function StatusChange(Request $request)
    {
        $data = MobileBanking::findOrFail($request->id);
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
}
