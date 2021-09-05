<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LandMiddleware
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
        $land = $request->route('land');
        
        if($land==null) {
            return response()->json(['message'=>'Item not found'], 404);
        }

        if($land->agent_id != auth('agent-api')->user()->id) {
            return response()->json(['message'=>'You are not the owner'], 401);
        }
        return $next($request);
    }
}
