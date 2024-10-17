<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(){
        return view('roles.create', ['permissions' => Permission::all()]);
    }
    public function process_role(){
        $validatedData = request()->validate([
            'role_name' => 'string|required|unique:roles,name',
            'expiry_date' => 'date',
            'max_users_allowed' => 'nullable|integer',
        ]);
        if (!request('permissions')) {
            flash()->error('Please select at least one permission');
            return back();
        }


        $role = Role::create([
            'name' => \Illuminate\Support\Str::ucfirst($validatedData['role_name']),
            'expiry' => $validatedData['expiry_date'],
            'max_users' => $validatedData['max_users_allowed'],
        ]);
        if (!$role) {
            flash()->error('Failed to create role');
            return back();
        }

        if (request('permissions') && is_array(request('permissions'))) {
            foreach (request('permissions') as $permission) {
                $role->permissions()->attach($permission);
            }
        }

        flash()->success('Successfully Created Role' . $role->name);
        return redirect('/roles');
    }
}
