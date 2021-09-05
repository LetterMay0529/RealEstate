<?php

namespace App\Http\Controllers;
use App\Models\Commercial;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    public function show(Commercial $commercial) {
        return response()->json($commercial,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $commercials = Commercial::where('type','like',"%$request->key%")
            ->orWhere('location','like',"%$request->key%")->get();

        return response()->json($commercials, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'string|required',
            'location' => 'string|required',
            'type' => 'string|required',
            'size' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required',
        ]);

        try {
            $commercial = Commercial::create([
                'image' => $request->image,
                'location' => $request->location,
                'type' => $request->type,
                'size' => $request->size,
                'description' => $request->description,
                'price' => $request->price,
                'agent_id' => auth('agent-api')->user()->id
            ]);
            return response()->json($commercial, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Commercial $commercial) {
        try {
            $commercial->update($request->all());
            return response()->json($commercial, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Commercial $commercial) {
        $commercial->delete();
        return response()->json(['message'=>'Commercial Property deleted.'],202);
    }

    public function index() {
        $commercials = Commercial::orderBy('price')->get();
        return response()->json($commercials, 200);
    }
}
