<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
	{
		return view('back.auth.login');
	}
	public function loginPost(Request $request)
	{
		if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
		{
			toastr()->success(Auth::user()->name,'Admin Panele Hoş Geldiniz '); // TODO toastr() uyarısı ekleme
		    return redirect()->route('admin.dashboard');
		}
		else
		{
			return redirect()->route('admin.login')->withErrors('Email veya Şifre Hatalı.');
		}
	}
	public function logout()
	{
		Auth::logout();
		return redirect()->route('admin.login');
	}
}
