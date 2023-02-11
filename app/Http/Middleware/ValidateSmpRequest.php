<?php

namespace App\Http\Middleware;

use App\Models\ApiRequest;
use Closure;
use Illuminate\Http\Request;

class ValidateSmpRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->logCall($request);
        if ($this->validateToken($request)) {
            return $next($request);
        }

        return response("Unauthorized", 401);
    }

    private function validateToken($request): bool
    {
        if (!$request->has('denizenkey')) {
            return false;
        }

        $token = $request->input('denizenkey');
        $secret = config('services.minecraft.denizensecret');

        return $token === $secret;
    }

    private function logCall(Request $request): void
    {
        ApiRequest::create([
            'ip'    => $request->getClientIp(),
            'route' => $request->route()->getName(),
            'token' => $request->input('denizenkey', 'NOKEY')
        ]);
    }
}
