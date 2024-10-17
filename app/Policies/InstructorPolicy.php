<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InstructorPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }
    public function edit_profile(User $user){
        return Auth::id() == $user->id;
    }
}
