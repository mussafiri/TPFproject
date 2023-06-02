<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberAuthController extends Controller
{    
    public function login(){
        return view('member_portal.auth.member_login');
    }

    public function forgotPassword(){
        return view('member_portal.auth.member_forgot_password');

    }
    public function changePassword(){
        return view('member_portal.auth.member_change_password');

    }

    public function passwordReset(){
        return view('member_portal.auth.member_reset_password');
    }
    public function veryAccount(){
        return view('member_portal.auth.member_verify_account');
    }
    public function authenticateMember(Request $request)
    {
        $credentials = $request->only('member_code', 'password');

        if (Auth::guard('member')->attempt($credentials)) {
            return redirect()->intended('/member/dashboard');
        } else {
            return redirect()->back()->withErrors(['invalid_credentials' => 'The provided credentials are incorrect.']);
        }
    }  

}
