<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResidentialMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $residential = $request->route('residential');
        
        if($residential==null) {
            return response()->json(['message'=>'Item not found'], 404);
        }

        if($residential->agent_id != auth('agent-api')->user()->id) {
            return response()->json(['message'=>'You are not the owner'], 401);
        }
        return $next($request);
    }
}
