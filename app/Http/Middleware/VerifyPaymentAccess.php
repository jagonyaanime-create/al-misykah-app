<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyPaymentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika belum ada session "pembayaran_verified", lempar ke halaman input password
        if (!$request->session()->has('pembayaran_verified')) {
            return redirect()->route('pembayaran.auth');
        }

        return $next($request);
    }
}
