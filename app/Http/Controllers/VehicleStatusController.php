<?php

namespace App\Http\Controllers;

use App\Models\VehicleStatus;
use Illuminate\Http\Request;

class VehicleStatusController extends Controller
{
    public function index(VehicleStatus $vehicleStatus){
        return response()->json($vehicleStatus->all());
    }

    public function store(Request $request, VehicleStatus $vehicleStatus){
        $newVehicleStatus = $vehicleStatus->create($request->all());
        return response()->json($newVehicleStatus);
    }

    public function update(Request $request, VehicleStatus $vehicleStatus){
        $vehicleStatus->update($request->all());
        return response()->json($vehicleStatus);
    }

    public function destroy(VehicleStatus $vehicleStatus){
        $vehicleStatus->delete();
    }

    public function vehicle_status_options(VehicleStatus $vehicleStatus){
        return response()->json($vehicleStatus->all(['id', 'name']));
    }
}
