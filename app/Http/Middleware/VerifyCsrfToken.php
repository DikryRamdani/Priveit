<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log; // Tambahkan ini

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/midtrans/callback',
    ];

    public function handle($request, \Closure $next) // Parameter bisa bervariasi sedikit antar versi Laravel, sesuaikan jika perlu
    {
        $requestUri = $request->path(); // Mendapatkan path request, e.g., 'midtrans/callback'
        Log::info("VerifyCsrfToken: Request URI: " . $requestUri); // Log URI yang masuk
        Log::info("VerifyCsrfToken: Except array: ", $this->except); // Log array $except

        foreach ($this->except as $exceptPath) {
            if ($request->is($exceptPath)) { // $request->is() adalah cara Laravel mencocokkan path, termasuk wildcard
                Log::info("VerifyCsrfToken: Path " . $requestUri . " MATCHES " . $exceptPath . " in except array. Skipping CSRF check.");
                return $next($request); // Lewati pemeriksaan CSRF
            }
        }

        Log::info("VerifyCsrfToken: Path " . $requestUri . " DOES NOT MATCH any in except array. Performing CSRF check.");
        return parent::handle($request, $next); // Lanjutkan ke pemeriksaan CSRF normal
    }
}