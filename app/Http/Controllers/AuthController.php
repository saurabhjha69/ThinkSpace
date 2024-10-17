<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use Illuminate\Container\Attributes\DB ;
use Illuminate\Support\Facades\DB as DBFacade;

class AuthController extends Controller
{

    public function __construct()
    {
        
    }

    public function login(Request $request)
    {
        $data = request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:20',
        ]);
    
        $user = Auth::attempt($data);
        if(!$user){
            return back()->withErrors(['fail'=>'Invalid Credentials']);
        }
        else {
            
            return redirect('/dash');
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
        if(!$res){
            return redirect('/signup')->withErrors(['fail'=>'Failed to Register User!']);
        }
        else {
            Auth::login($user);
            return redirect('/prefrences');
        }
    }

    public function logout()
    {
        \Illuminate\Support\Facades\Session::flush();
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
