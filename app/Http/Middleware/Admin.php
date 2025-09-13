<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (!auth()->check()) {
            return redirect('/login'); // atau abort(401, 'Unauthorized');
        }
        if (auth()->user()->position !== 'Admin') {
            abort(403, 'Akses ditolak.');
        }
    
        
        return $next($request);
    }
}
