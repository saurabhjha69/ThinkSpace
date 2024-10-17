<?php

namespace App\Http\Controllers;

use App\Models\Role;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;
// use Illuminate\Container\Attributes\DB ;
use Illuminate\Support\Facades\DB as DBFacade;

class AuthController extends Controller
{

    public function __construct()
    {

    }

    public function loginView(){
        return view('auth.login');
    }
    public function signupView(){
        return view('auth.signup');
    }
    public function login(Request $request)
    {
        $data = request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:20',
        ]);
        Auth::logout();
        session()->flush();
        $user = Auth::attempt($data);

        if(!$user){
            session()->flash('fail', 'Invalid email or password');
            return back();
        }

        $user = Auth::user();
        if($user->hasRole('Admin')){
            session()->put('user_role', 'Admin');
            return redirect('/admin');
        }
        if($user->hasRole('Instructor')){
            session()->put('user_role', 'Instructor');
            return redirect('/instructor');
        }
        if($user->hasRole('Learner')){
            session()->put('user_role', 'Learner');
            return redirect('/dash');
        }
        else {
            flash()->warning('User Not Found!');
            return redirect('/login');
        }



    }
    public function refreshSession(){
        if(request('currentSignInRole') == 'Admin'){
            session()->put('user_role', 'Admin');
            flash()->success('Successfully Logged In As Admin!');
            return redirect('/admin');
        }
        if(request('currentSignInRole') == 'Instructor'){
            session()->put('user_role', 'Instructor');

            flash()->success('Successfully Logged In  As Instructor!');
            return redirect('/instructor');
        }
        if(request('currentSignInRole') == 'Learner'){
            session()->put('user_role', 'Learner');
            flash()->success('Successfully Logged In As Learner!');
            return redirect('/dash');
        }
        else {
            session()->flush();
            flash()->warning('Invalid Role!');
            return redirect()->back();
        }

    }

    public function signup(){
        request()->validate([
            'username' => 'required|max:55|string|unique:users,username',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed|min:6|max:20',
        ]);

        $user = new User();
        $user->username = request('username');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $res = $user->save();
        $role = Role::where('name', 'Learner')->first();
        $user->roles()->attach($role->id);
        if(!$res){
            return redirect('/signup')->withErrors(['fail'=>'Failed to Register User!']);
        }
        else {
            Auth::login($user);
            flash()->success('Successfully Registered User!');
            return redirect('/login');
        }
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('/login');
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
