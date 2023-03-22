<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Resources\VehicleResource;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Vehicle $vehicle){
        return response()->json(VehicleResource::collection($vehicle->all()));
    }

    public function show(Vehicle $vehicle){
        return response()->json(new VehicleResource($vehicle));
    }

    public function store(Request $request, Vehicle $vehicle){
        $vehicle->create($request->all());
        return response()->json($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle){
        $vehicle->update($request->all());
        return response()->json($vehicle);
    }

    public function destroy(Vehicle $vehicle){
        try {
            //$vehicle->delete();
            return response()->json([
                'status' => 'sucess',
                'message' => 'Vehicle deleted successfully!',
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle could not be deleted!',
            ]);
        }

    }

    public function vehicle_options(Vehicle $vehicle){
        return response()->json($vehicle->all(['id', 'make', 'model']));
    }
}
