<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        // $user_roles_name = DB::table('user_roles')
        //     ->join('roles', 'user_roles.role_id', '=', 'roles.id')
        //     ->join('users', 'user_roles.user_id', '=', 'users.id')
        //     ->select('user_roles.role_id', 'roles.name as rolename', 'user_roles.user_id', 'users.name as username', 'users.email')
        //     ->get();
        return view('team', ['users' => User::all()]);
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

    public function show($id)
    {

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
            foreach($user_ids_array as $user_id){
                User::destroy($user_id);
            }
            return redirect()->back();
        }
        return redirect()->back();


    }

}
