<?php

namespace App\Http\Middleware;
use App\Models\Commercial;
use App\Http\Controller\CommercialController;
use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
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
        $commercial = $request->route('commercial');
        
        if($commercial==null) {
            return response()->json(['message'=>'Item not found'], 404);
        }

        if($commercial->agent_id != auth('agent-api')->user()->id) {
            return response()->json(['message'=>'You are not the owner'], 401);
        }
        return $next($request);
    }
}
