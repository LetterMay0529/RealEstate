<?php

namespace App\Http\Controllers;
use App\Models\Residential;
use Illuminate\Http\Request;

class ResidentialController extends Controller
{
    public function show(Residential $residential) {
        return response()->json($residential,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $residentials = Residential::where('type','like',"%$request->key%")
            ->orWhere('location','like',"%$request->key%")->get();

        return response()->json($residentials, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'string|required',
            'location' => 'string|required',
            'type' => 'string|required',
            'size' => 'string|required',
            'description' => 'string|required',
            'no_of_rooms' => 'string|required',
            'price' => 'numeric|required',
        ]);

        try {
            $residential = Residential::create([
                'image' => $request->image,
                'location' => $request->location,
                'type' => $request->type,
                'size' => $request->size,
                'description' => $request->description,
                'no_of_rooms' => $request->no_of_rooms,
                'price' => $request->price,
                'agent_id' => auth('agent-api')->user()->id
            ]);
            return response()->json($residential, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Residential $residential) {
        try {
            $residential->update($request->all());
            return response()->json($residential, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Residential $residential) {
        $residential->delete();
        return response()->json(['message'=>'Residential Property deleted.'],202);
    }

    public function index() {
        $residentials = Residential::orderBy('price')->get();
        return response()->json($residentials, 200);
    }
}
