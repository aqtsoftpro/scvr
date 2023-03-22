<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\Vehicle;
use App\VanReturn;
use Illuminate\Http\Request;
use App\Http\Resources\VanoutDashboardResource;
use App\Http\Resources\VanReturnDashboardResource;

class DashboardController extends Controller
{
    public function __construct()   {
      $this->middleware('auth:sanctum');
    }

    public function index(){

        $vans = Vehicle::where('vehicle_type_id', 3)->count();
        $cars = Vehicle::where('vehicle_type_id', 1)->count();
        $vanoutCount = VanOut::count();
        $vanreturnsCount = VanReturn::count();
        $vanouts = VanoutDashboardResource::collection(VanOut::all());
        $vanins = VanReturnDashboardResource::collection(VanReturn::all());

        $data = [
            'vans' => $vans,
            'cars' => $cars,
            'vanout_count' => $vanoutCount,
            'vanreturn_count' => $vanreturnsCount,
            'vanouts' => $vanouts,
            'vanins' => $vanins
        ];

        return response()->json($data);
    }
}
