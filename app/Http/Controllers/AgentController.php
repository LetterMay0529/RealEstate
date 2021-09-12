<?php

namespace App\Http\Controllers;
use \App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'bdate' => 'required|date',
            'gender'=>'required|in:female,male,none',
            'contact_number' => 'required|numeric',
            'broker_name' => 'required|string',
            'broker_license' => 'required|numeric',
            'email' => 'required|email|unique:agents,email',
            'password' => 'required|string'
        ]);

        $user = Agent::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'bdate' => $request->bdate,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
            'broker_name' => $request->broker_name,
            'broker_license' => $request->broker_license,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'message' => 'Registration success'
        ], 202);
    }

    public function login(Request $request) {
        $creds = $request->only('email','password');

        if(!$token = auth('agent-api')->attempt($creds)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return $this->respondwithToken($token);

    }

    public function agent() {
        return response()->json(auth()->user());
    }

    public function logout() {
        auth()->logout();
        return response()->json([
            'message' => 'Successfully logged out.'
        ]);
    }

    private function respondwithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'express_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
