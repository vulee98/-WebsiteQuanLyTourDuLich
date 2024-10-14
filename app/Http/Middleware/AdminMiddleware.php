<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // lấy thông tin user đang đăng nhập
        $user = Auth::user();

        if (empty($user)) {
            return route('login');
        }

        // nếu không phải admin trả về trang 403
        if ($user->role != 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
