<?php

namespace App\Http\Controllers;

use App\Models\RentInfo\FlatInfo;
use App\Models\RentInfo\RentInfo;
use App\Models\RentInfo\TenantInfo;
use App\Models\Accounts\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\RentInfo\GeneralSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function dashboard()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();

        if ($user_role->name == 'Super Admin') {
            $rentedFlat = FlatInfo::where('rent_status', 1)->count();
            $unrentedFlat = FlatInfo::where('rent_status', 0)->count();
            $totalFlat = FlatInfo::count();
            $tenant = TenantInfo::count();

            $totalFlatRent = RentInfo::sum('total_rent');

            $rentAmount = Transaction::whereIn('transaction_purpose', [1, 2])->get();

            $TotalRentAmount = [];
            foreach ($rentAmount as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $TotalRentAmount[] = $total;
            }

            $totalRentCollect = array_sum($TotalRentAmount);
            $totalRentDue = $totalFlatRent - $totalRentCollect;

            $expenseAmount = Transaction::where('transaction_purpose', 3)->get();

            $TotalExpenseAmount = [];
            foreach ($expenseAmount as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $TotalExpenseAmount[] = $total;
            }

            $totalExpense = array_sum($TotalExpenseAmount);

        }else{

           $rentedFlat = FlatInfo::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->where('rent_status', 1)->count();
            $unrentedFlat = FlatInfo::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->where('rent_status', 0)->count();
            $totalFlat = FlatInfo::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->count();
            $tenant = TenantInfo::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->count();

            $totalFlatRent = RentInfo::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->sum('total_rent');

            $rentAmount = Transaction::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->whereIn('transaction_purpose', [1, 2])->get();

            $TotalRentAmount = [];
            foreach ($rentAmount as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $TotalRentAmount[] = $total;
            }

            $totalRentCollect = array_sum($TotalRentAmount);
            $totalRentDue = $totalFlatRent - $totalRentCollect;

            $expenseAmount = Transaction::with('owners')->where('owner_info_id', (Auth::user()->owners->id))->where('transaction_purpose', 3)->get();

            $TotalExpenseAmount = [];
            foreach ($expenseAmount as $key => $value) {
                $balance = $value->amount;
                $total   = json_decode($balance);
                $TotalExpenseAmount[] = $total;
            }

            $totalExpense = array_sum($TotalExpenseAmount);

        }
        return view('pages.dashboard', compact('rentedFlat','unrentedFlat','totalFlat','tenant','totalRentCollect','totalRentDue','totalFlatRent','totalExpense'));
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');

        return view('clear-cache');
    }

    public function GeneralSettings(){
        try {
            $data = GeneralSetting::first();
            return view('rent_info.general_setting.general_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function GeneralSettingStore(Request $request)
    {
        try {
            if (!$request->id) {
                $request->validate([
                    'name' => 'required',
                    'website' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'favicon' => 'required',
                    'logo' => 'required',
                ]);

                $data = new GeneralSetting();
            } else {
                $data = GeneralSetting::findOrFail($request->id);
            }
            if ($request->file('logo')) {
                $file = $request->file('logo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->logo = $filename;
            }
            if ($request->file('favicon')) {
                $file = $request->file('favicon');
                $filenamefavicon = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'),  $filenamefavicon);
                $data->favicon =  $filenamefavicon;
            }
            $data->name = $request->name;
            $data->website = $request->website;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->map = $request->map;
            $data->description = $request->description;

            if (!$request->id) {
                $data->save();
                return redirect()->route('general-settings')->with('success', ' General settings created successfull');
            } else {
                $data->update();
                return redirect()->route('general-settings')->with('success', 'General settings updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
