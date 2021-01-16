<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;

class EnsureApiKeyIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Hash::check($request->header('X-API-Key'), config('api.keys.api_key'))) {
            return response()->json(['message' => config('api.messages.invalid_api_key')], 401);
        }

        return $next($request);
    }
}
