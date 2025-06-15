<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  string $role): Response
    {
        Log::info('Middleware Role dijalankan', [
            'required_role' => $role,
            'user_role' => optional($request->user())->role,
        ]);
    
        if (!$request->user() || $request->user()->role !== $role) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        return $next($request);
    }
    
    
}
