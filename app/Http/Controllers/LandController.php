<?php

namespace App\Http\Controllers;
use App\Models\Land;
use Illuminate\Http\Request;

class LandController extends Controller
{
    public function show(Land $land) {
        return response()->json($land,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $lands = Land::where('type','like',"%$request->key%")
            ->orWhere('location','like',"%$request->key%")->get();

        return response()->json($lands, 200);
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
            $land = Land::create([
                'image' => $request->image,
                'location' => $request->location,
                'type' => $request->type,
                'size' => $request->size,
                'description' => $request->description,
                'price' => $request->price,
                'agent_id' => auth('agent-api')->user()->id
            ]);
            return response()->json($land, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Land $land) {
        try {
            $land->update($request->all());
            return response()->json($land, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Land $land) {
        $land->delete();
        return response()->json(['message'=>'Land Property deleted.'],202);
    }

    public function index() {
        $lands = Land::orderBy('price')->get();
        return response()->json($lands, 200);
    }
}
