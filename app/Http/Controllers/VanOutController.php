<?php

namespace App\Http\Controllers;

use App\VanOut;
use Illuminate\Http\Request;

class VanOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(VanOut $vanOut){
        return response()->json($vanOut->all());
    }

    public function show(VanOut $vanOut){
        return response()->json($vanOut->find($vanOut->id));
    }

    public function store(Request $request, VanOut $vanOut){
        $vanOut->fill($request->all());
        $vanOut->save();
        return response()->json($vanOut);
    }

    public function update(Request $request, VanOut $vanOut){
        $vanOut->fill($request->all());
        $vanOut->save();
        return response()->json($vanOut);
    }

    public function destroy(VanOut $vanOut){
        $vanOut->delete();
        return response()->json(null, 204);
    }
}
