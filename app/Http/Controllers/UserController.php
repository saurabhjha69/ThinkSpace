<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
{
    request()->validate([
        'filterByRole' => Rule::in(['Admin','Learner','Instructor','All']),
        'filterByStatus' => Rule::in(['0','1','All']),
    ],
[
    'filterByRole' => 'Filter role is Invalid, please select a valid role or select All',
    'filterByStatus' => 'Filter status is Invalid, please select a valid status or select All',
]);

    $users = User::with('roles')
        ->when(request('search'), function($query) {
            $query->where('username', 'like', request('search') . '%');
        })
        ->when(request('filterByRole') && request('filterByRole') != 'All', function($query) {
            $query->whereHas('roles', function($q) {
                $q->where('name', request('filterByRole'));
            });
        })
        ->when(request()->has('filterByStatus') && request('filterByStatus') != 'All', function($query) {
            $query->where('is_active', request('filterByStatus'));
        })
        ->orderBy('created_at', 'asc')
        ->simplePaginate(10)
        ->appends(request()->query());

    return view('team', ['users' => $users]);
}

    public function suspend(User $user){
        if($user->is_active){
            $user->is_active = false;
            $user->save();
            flash()->success( 'Successfully Suspended User '.$user->username);
        }else{
            $user->is_active = true;
            $user->save();
            flash()->success( 'Successfully Reactivated User '.$user->username);
        }
        return redirect('/user/'.$user->id);
    }

    public function create()
    {
        return view('user.create', ['roles' => Role::all()]);
    }

    public function store()
    {
        // dd(request());
        request()->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:12|confirmed'
        ]);
        $user = User::create([
            'username' => request('username'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'is_active' => true,
        ]);

        $roles = Role::all()->pluck('id');

        if(request('role') && is_array(request('role'))){
            foreach(request('role') as $role){
                if($roles->contains($role)){
                    $user->roles()->attach($role);
                }
            }
        }
        $user->save();
        flash()->success( 'Successfully Created User '.$user->username);
        return redirect('user/create');
    }

    public function show(User $user)
    {
        $courses = Course::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('user.show',['user'=>$user,'existingcourses' => $courses]);
    }



    public function edit(User $user)
    {


        return view('user.edit', ['user' => $user, 'roles' => Role::all()]);
    }

    public function update(User $user)
    {
        if(request('username')!=null){
            $user->username = request('username');
        }
        if(request('email')!=null){
            $user->email = request('email');
        }
        if(request('is_active')!=null){
            $user->is_active = request('is_active');
        }
        $roles = Role::all()->pluck('id');

        if(request('role') && is_array(request('role'))){
            $ids = [];
            foreach(request('role') as $role){
                if($roles->contains($role)){
                    $ids[] = $role;
                }
            }
            $user->roles()->sync($ids);
        }
        $user->save();
        flash()->success( 'Successfully Updated User '.$user->username);
        return redirect('/user/edit/'.$user->id);

    }

    public function destroy()
    {
        // dd(request('user_ids'));
        $users_id = '['.request('user_ids').']';
        $user_ids_array = json_decode($users_id,true);
        if($user_ids_array!=null){
            try{
                foreach($user_ids_array as $user_id){
                    DB::table('deleted_users')->insert([
                        'username' => User::find($user_id)->username,
                        'email' => User::find($user_id)->email,
                        'deleted_at' => now(),
                    ]);
                    $user = User::find($user_id);
                    $user->delete();
                }
                flash()->success( 'Successfully Deleted Users');
                return redirect()->back();
            }
            catch(\Exception $e){
                flash()->error( 'Failed to Delete Users');
                return redirect()->back();
            }
        }
        return redirect()->back();


    }

}
