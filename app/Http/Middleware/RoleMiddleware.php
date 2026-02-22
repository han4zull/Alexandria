<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Log debugging
        \Illuminate\Support\Facades\Log::info('RoleMiddleware check', [
            'web_check' => Auth::guard('web')->check(),
            'admin_check' => Auth::guard('admin')->check(),
            'petugas_check' => Auth::guard('petugas')->check(),
            'user_id' => Auth::guard('web')->id(),
            'roles_required' => $roles,
        ]);

        // 1️⃣ PASTIKAN ADA YANG LOGIN
        if (!Auth::guard('web')->check() &&
            !Auth::guard('admin')->check() &&
            !Auth::guard('petugas')->check()
        ) {
            return $this->unauth($request);
        }

        // 2️⃣ AMBIL USER DARI GUARD YANG AKTIF
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        } elseif (Auth::guard('petugas')->check()) {
            $user = Auth::guard('petugas')->user();
        } else {
            $user = Auth::guard('web')->user();
        }

        \Illuminate\Support\Facades\Log::info('User info', [
            'user_id' => $user?->id,
            'user_role' => $user?->role,
            'user_name' => $user?->username,
        ]);

        // 3️⃣ CEK ROLE
        if (!isset($user->role) || !in_array($user->role, $roles)) {
            \Illuminate\Support\Facades\Log::error('Role check failed', [
                'user_role' => $user?->role,
                'required_roles' => $roles,
            ]);
            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }

    private function unauth(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        return redirect()
            ->route('akun.masuk')
            ->with('error', 'Silakan login terlebih dahulu');
    }
}
