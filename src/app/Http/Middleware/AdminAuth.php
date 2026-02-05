<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // セッションに管理者ログイン情報があるか確認
        if (!$request->session()->get('admin_authenticated')) {
            // ログインしていない場合はログインページにリダイレクト
            return redirect()->route('admin.login')
                ->with('error', 'ログインが必要です。');
        }

        return $next($request);
    }
}
