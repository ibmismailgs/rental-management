<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the roles page
     *
     */
    public function index()
    {
        try {
            $roles = Role::pluck('name', 'id');

            return view('permission', compact('roles'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Show the role list with associate permissions.
     * Server side list view using yajra datatables
     */

    public function getPermissionList(Request $request)
    {
        $data = Permission::get();

        return Datatables::of($data)
                ->addColumn('roles', function ($data) {
                    $roles = $data->roles()->get();
                    $badges = '';
                    foreach ($roles as $key => $role) {
                        $badges .= '<span class="badge badge-dark m-1">'.$role->name.'</span>';
                    }
                    return $badges;
                })

                ->addIndexColumn()
                ->rawColumns(['roles'])
                ->make(true);
    }

    /**
     * Store new roles with assigned permission
     * Associate permissions will be stored in table
     */

    public function create(Request $request)
    {
        try {
            $permission = Permission::create(['name' => $request->permission]);
            $permission->syncRoles($request->roles);

            if ($permission) {
                return redirect('permission')->with('success', 'Permission created succesfully!');
            } else {
                return redirect('permission')->with('error', 'Failed to create permission! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }



    public function update(Request $request)
    {
        // update permission table
        $permission = Permission::find($request->id);
        $permission->name = $request->name;
        $permission->save();

        return $permission;
    }


    public function delete($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $delete = $permission->delete();
            $perm = $permission->roles()->delete();

            return redirect('permission')->with('success', 'Permission deleted!');
        } else {
            return redirect('404');
        }
    }


    public function getPermissionBadgeByRole(Request $request)
    {
        $badges = '';
        if ($request->id) {
            $role = Role::find($request->id);
            $permissions = $role->permissions()->pluck('name', 'id');
            foreach ($permissions as $key => $permission) {
                $badges .= '<span class="badge badge-dark m-1">'.$permission.'</span>';
            }
        }

        if ($role->name == 'Super Admin') {
            $badges = 'Super Admin has all the permissions!';
        }

        return $badges;
    }
}
