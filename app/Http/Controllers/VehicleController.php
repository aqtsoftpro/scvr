<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Vehicle $vehicle){
        return $vehicle->all();
    }

    public function show(Vehicle $vehicle){
        return $vehicle;
    }

    public function store(Request $request, Vehicle $vehicle){
        $vehicle->create($request->all());
        return $vehicle;
    }

    public function update(Request $request, Vehicle $vehicle){
        $vehicle->update($request->all());
        return $vehicle;
    }

    public function destroy(Vehicle $vehicle){
        $vehicle->delete();
        return $vehicle;
    }
}
