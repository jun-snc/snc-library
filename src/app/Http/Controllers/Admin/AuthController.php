<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // 既にログイン済みの場合はダッシュボードへ
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $passwordHash = env('ADMIN_PASSWORD_HASH');

        if (Hash::check($request->password, $passwordHash)) {
            // ログイン成功
            $request->session()->put('admin_authenticated', true);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'ログインしました。');
        }

        // ログイン失敗
        return back()
            ->withErrors(['password' => 'パスワードが正しくありません。'])
            ->withInput();
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'ログアウトしました。');
    }
}
