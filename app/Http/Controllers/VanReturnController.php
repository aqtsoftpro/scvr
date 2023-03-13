<?php

namespace App\Http\Controllers;

use App\VanReturn;
use Illuminate\Http\Request;

class VanReturnController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }

    public function index(VanReturn $vanReturn){
        return response()->json($vanReturn->all());
    }

    public function show(VanReturn $vanReturn){
        return response()->json($vanReturn->find($vanReturn->id));
    }

    public function store(Request $request, VanReturn $vanReturn){
        $vanReturn->fill($request->all());
        $vanReturn->save();
        return response()->json($vanReturn);
    }

    public function update(Request $request, VanReturn $vanReturn){
        $vanReturn->fill($request->all());
        $vanReturn->save();
        return response()->json($vanReturn);
    }

    public function destroy(VanReturn $vanReturn){
        $vanReturn->delete();
        return response()->json(null, 204);
    }
}
