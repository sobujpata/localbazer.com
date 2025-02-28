<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();

        // Check if the IP address has already been logged today
        $existingVisitor = Visitor::where('ip_address', $ipAddress)
                                  ->whereDate('created_at', now()->toDateString())
                                  ->first();

        if (!$existingVisitor) {
            // Store the visitor's IP address
            Visitor::create(['ip_address' => $ipAddress]);
        }

        return $next($request);
    }
}
