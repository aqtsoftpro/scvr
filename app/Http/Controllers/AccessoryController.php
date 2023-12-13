<?php

namespace App\Http\Controllers;

use App\Accessory;
use Illuminate\Http\Request;
use App\Http\Resources\AccessoryResource;
use Spatie\Activitylog\Models\Activity;

class AccessoryController extends Controller
{
    public function __construct()  {
        $this->middleware('auth:sanctum');
    }

    public function index(Accessory $accessory){
        return response()->json(AccessoryResource::collection($accessory->all()));
    }

    public function store(Request $request, Accessory $accessory){

        $validation = $request->validate([
            'name' => 'required',
        ]);

        if($accessory->create($request->all())){
            return response()->json([
                'status' => 'success',
                'message' => 'Accessory created',
                'data' => $accessory
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Accessory not created'
            ]);
        }
    }

    public function show(Accessory $accessory, int $id){
        return response()->json(new AccessoryResource($accessory->find($id)));
    }

    public function update(Request $request, Accessory $accessory){
        $accessory->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Accessory updated',
            'data' => $accessory
        ]);
    }

    public function destroy(Accessory $accessory){
        $accessory->delete();
    }

    public function accessory_options(Accessory $accessory){
        return response()->json($accessory->all(['id', 'name']));
    }
}
