<?php

namespace App\Http\Controllers;

use App\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(VehicleType $vehicleType){
        return $vehicleType->all();
    }

    public function store(Request $request, VehicleType $vehicleType){
        $vehicleType->create($request->all());
        return $vehicleType;
    }

    public function update(Request $request, VehicleType $vehicleType){
        $vehicleType->update($request->all());
        return $vehicleType;
    }

    public function show(VehicleType $vehicleType){
        return $vehicleType;
    }


    public function destroy(VehicleType $vehicleType){
        $vehicleType->delete();
        return $vehicleType;
    }
}
