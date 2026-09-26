<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('admin_id')) {
            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}