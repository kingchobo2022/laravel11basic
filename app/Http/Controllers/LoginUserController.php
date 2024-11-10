<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8, string'
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('posts.index'));
        } else {
            return back()->withErrors([
                'email' => '등록된 정보가 없습니다.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // 로그아웃과 관련된 정리작업을 진행함
        $request->session()->invalidate(); // 세션을 파괴함. session_destroy();
        $request->session()->regenerateToken(); // csrf 토큰 재생성
        return to_route('posts.index');
    }
}
