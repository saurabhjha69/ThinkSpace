<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Users',
            'Courses',
            'Categories',
            'Comments',
            'Roles',
            'Ratings',
            'Quizzes',
            'Payments',
            'Reports',
            'Profile',
            'Settings',
            'Help'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminPermissions = Permission::all();
        $instructorPermissions = Permission::whereIn('name', ['Courses', 'Comments', 'Quizzes', 'Reports', 'Profile', 'Help'])->get();

        $learnerPermissions = Permission::whereIn('name', ['Courses', 'Comments','Ratings', 'Quizzes', 'Profile', 'Help'])->get();
        $guestPermissions = Permission::whereIn('name', ['Profile', 'Help'])->get();
        $adminRole = Role::where('name', 'Admin')->first();
        $instructorRole = Role::where('name', 'Instructor')->first();
        $learnerRole = Role::where('name', 'Learner')->first();
        $guestRole = Role::where('name', 'Guest')->first();
        $adminRole->permissions()->attach($adminPermissions);
        $instructorRole->permissions()->attach($instructorPermissions);
        $learnerRole->permissions()->attach($learnerPermissions);
        $guestRole->permissions()->attach($guestPermissions);

    }
}
