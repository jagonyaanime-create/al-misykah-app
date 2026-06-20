<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoLockPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek dulu, apakah session sudah siap/terpasang? (Agar tidak error "Not set")
        // 2. Jika iya, dan kita di luar halaman pembayaran, hapus kuncinya
        if ($request->hasSession() && 
            !$request->is('pembayaran*') && 
            !$request->is('pembayaran-login*') && 
            !$request->is('generate-spp*') && 
            !$request->is('tagihan-masal*') &&
            !$request->is('pembayaran-lunas*')) {
            
            $request->session()->forget('pembayaran_verified');
        }

        return $next($request);
    }
}
