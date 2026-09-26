<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_id')) {
            return redirect('/admin/login')->with('error', 'Please log in as admin.');
        }

        return $next($request);
    }
}