<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;
        
        if (!in_array($userRole, $roles)) {
            // Redirect ke dashboard sesuai role user
            switch ($userRole) {
                case 'admin':
                    return redirect('/admin/dashboard')->with('error', 'Akses ditolak untuk halaman tersebut');
                case 'guru':
                    return redirect('/guru/dashboard')->with('error', 'Akses ditolak untuk halaman tersebut');
                case 'siswa':
                    return redirect('/siswa/dashboard')->with('error', 'Akses ditolak untuk halaman tersebut');
                default:
                    return redirect('/')->with('error', 'Akses ditolak');
            }
        }

        return $next($request);
    }
}