<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\SubPermission;

class SubPermissionController extends Controller
{
    public function mapSubPermissions(){
        return view('permissions.mapsubper', ['permissions' => Permission::all(),'subpermissions' => SubPermission::all()]);
    }

    public function processSubPermissions(){
        request()->validate(
            [
                'permission_id' => 'required|exists:permissions,id',
            ],
            [
                'permission_id.required' => 'The permission field is required.',
                'permission_id.exists' => 'The selected permission Doesnot  exist.',
            ]
        );

        $permission = Permission::find(request('permission_id'));

        if (request('subpermissions') && is_array(request('subpermissions'))) {
            foreach (request('subpermissions') as $subpermission) {
                $permission->subpermissions()->attach($subpermission, ['created_at' => now(), 'updated_at' => now()]);
            }
        }
        flash()->success('Successfully Mapped Subpermissions With Permission');
        return back();
    }
}
