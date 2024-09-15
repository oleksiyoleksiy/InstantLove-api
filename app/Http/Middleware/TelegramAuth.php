<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TelegramAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->all();
        $hash = $data['hash'];
        unset($data['hash']);
        ksort($data);

        $check_string = '';

        foreach ($data as $key => $value) {
            $check_string .= "$key=$value\n";
        }

        $check_string = rtrim($check_string, "\n");
        $secret_key = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $hmac = hash_hmac('sha256', $check_string, $secret_key);

        if (hash_equals($hmac, $hash)) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
