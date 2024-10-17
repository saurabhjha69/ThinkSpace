<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subPermissions = [
            'View',
            'Create',
            'Update',
            'Delete',
            'Approve',
            'Reject',
            'Moderate',
            'Suspend',
            'Unsuspend',
            'Block',
            'Unblock',
            'Users',
        ];
        foreach ($subPermissions as $subPermission) {
            \App\Models\SubPermission::create([
                'name' => $subPermission,
            ]);
        }

    




    }
}
