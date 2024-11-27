<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('login');
        }

        // Kiểm tra vai trò của người dùng thông qua cột 'role'
        $user = Auth::user();
        if (trim($user->role) !== trim($role)) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }

}
