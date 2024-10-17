<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 100 users
        $users = User::factory(100)->create();

        // Create roles with necessary fields
        $adminRole = Role::create([
            'name' => 'Admin',
            'expiry' => '2023-01-01',
            'max_users' => 100,
        ]);
        $instructorRole = Role::create([
            'name' => 'Instructor',
            'expiry' => '2023-01-01',
            'max_users' => 100,
        ]);
        $learnerRole = Role::create([
            'name' => 'Learner',
            'expiry' => '2023-01-01',
            'max_users' => 100,
        ]);
        $guestRole = Role::create([
            'name' => 'Guest',
            'expiry' => '2023-01-01',
            'max_users' => 100,
        ]);

        // Attach a random role to each user
        foreach ($users as $user) {
            $randomRole = [$adminRole->id, $instructorRole->id, $learnerRole->id, $guestRole->id];
            $user->roles()->attach($randomRole[array_rand($randomRole)]);
        }

        // Fetch users with the 'Instructor' role manually
        $instructorRoleId = $instructorRole->id;
        $instructors = User::whereHas('roles', function ($query) use ($instructorRoleId) {
            $query->where('role_id', $instructorRoleId);
        })->get();

        // Create 20 courses, each assigned to a random instructor
        Course::factory(20)->create()->each(function ($course) use ($instructors) {
            $course->user_id = $instructors->random()->id; // Assign course to a random instructor
            $course->save();
        });
    }
}
