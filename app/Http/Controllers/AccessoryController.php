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
        $accessory->create($request->all());

        return $accessory;
    }

    public function show(Accessory $accessory, int $id){
        return response()->json(new AccessoryResource($accessory->find($id)));
    }

    public function update(Request $request, Accessory $accessory, int $id){
        $accessory->find($id)->update($request->all());
        return $accessory;
    }

    public function destroy(Accessory $accessory){
        $accessory->delete();
    }

    public function accessory_options(Accessory $accessory){
        return response()->json($accessory->all(['id', 'name']));
    }
}
