<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request){

        $messages = [
            'username.required' => 'Tài khoản không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ];

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],$messages);

        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])) { 
            session()->regenerate();
            return redirect()->route('admin.quan.ly.user');
        }
        
        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('username');

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('admin.login.form');
    }
}
