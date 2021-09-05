<?php

namespace App\Http\Controllers;
use \App\Models\Seeker;
use Illuminate\Http\Request;

class SeekerController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'bdate' => 'required|date',
            'contact_number' => 'required|numeric',
            'email' => 'required|email|unique:seekers,email',
            'password' => 'required|string'
        ]);

        $user = Seeker::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'bdate' => $request->bdate,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'message' => 'Registration success'
        ], 202);
    }

    public function login(Request $request) {
        $creds = $request->only('email','password');

        if(!$token = auth('seeker-api')->attempt($creds)) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return $this->respondwithToken($token);

    }

    public function seeker() {
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