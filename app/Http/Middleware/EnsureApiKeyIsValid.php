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
        if (!Hash::check($request->header('Authorization'), config('api.keys.api_key'))) {
            return response()->json(['message' => 'Invalid API Key'], 401);
        }

        return $next($request);
    }
}
