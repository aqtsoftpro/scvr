<?php

namespace App\Http\Controllers;

use App\RepairJob;
use Illuminate\Http\Request;

class RepairJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(RepairJob $repairJob){
        return $repairJob->with('vehicle')->get();
    }

    public function store(Request $request, RepairJob $repairJob){
        $repairJob->vehicle()->attach($request->vehicle_id);
        return $repairJob;
    }

    public function update(Request $request, RepairJob $repairJob){
        $repairJob->vehicle()->sync($request->vehicle_id);
        return $repairJob;
    }


    public function show(RepairJob $repairJob){
        return $repairJob;
    }



    public function destroy(RepairJob $repairJob){
        $repairJob->delete();
        return $repairJob;
    }
}
