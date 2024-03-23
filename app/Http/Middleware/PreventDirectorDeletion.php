<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDirectorDeletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasRole('Director')) {
            // Return a response indicating that Managers cannot delete data
            // return redirect()->back()->with('error', 'Managers are not allowed to delete data.');
            return response()->json(['error' => 'Directors are not allowed to remove data.'], 403);
        }
        return $next($request);
    }
}
