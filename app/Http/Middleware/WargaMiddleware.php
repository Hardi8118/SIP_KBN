<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class WargaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->peran === 'warga') {
            return $next($request);
        }
        return redirect('/admin/dashboard');
    }
}
