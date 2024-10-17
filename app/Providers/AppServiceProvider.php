<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\InstructorPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::policy(Course::class, CoursePolicy::class);
        Gate::define('view_users', function () {
            return session()->get('user_role') === 'Admin';
        });
        Gate::define('view_quizzes', function () {
            return in_array(session()->get('user_role'), ['Admin', 'Instructor']);
        });
        Gate::define('approve_courses', function () {
            return in_array(session()->get('user_role'), ['Admin']);
        });
        Gate::policy(User::class,InstructorPolicy::class);

        Gate::define('isAdmin',function(){
            return session()->get('user_role') == 'Admin';
        });
        Gate::define('isCourseInstructor',function(User $user){
            return session()->get('user_role') == 'Instructor' && $user->id == Auth::id();
        });
        Gate::define('isInstructor',function($id){
            return session()->get('user_role') == 'Instructor';
        });
        Gate::define('isLearner',function(){
            return session()->get('user_role') == 'Learner';
        });
        Gate::define('isGuest',function(){
            return session()->get('user_role') == 'Guest';
        });
    }
}
