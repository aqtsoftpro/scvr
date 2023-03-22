<?php

namespace App\Http\Controllers;

use App\VanReturn;
use Illuminate\Http\Request;
use App\Http\Resources\VanReturnResource;

class VanReturnController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }

    public function index(VanReturn $vanReturn){
        return response()->json(VanReturnResource::collection($vanReturn->all()));
    }

    public function show(VanReturn $vanReturn){
        return response()->json($vanReturn->find($vanReturn->id));
    }

    public function store(Request $request, VanReturn $vanReturn){
        $vanReturn->create($request->all());
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

    public function van_return_options(VanReturn $vanReturn){
        return response()->json($vanReturn->all(['id', 'condition']));
    }
}
