<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\Vehicle;
use App\VanReturn;
use Carbon\Carbon;
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
        $available_vans = Vehicle::where('vehicle_type_id', 3)->where('status_id', 1)->count();
        $cars = Vehicle::where('vehicle_type_id', 1)->count();
        $available_cars = Vehicle::where('vehicle_type_id', 1)->where('status_id', 1)->count();
        $vanoutCount = VanOut::where('status', 1)->count();
        $vanreturnsCount = VanReturn::count();
        $vanouts = VanoutDashboardResource::collection(VanOut::whereBetween('due_return', [Carbon::now(), Carbon::now()->addDays(7)])->where('status', 1)->get());
        $vanins = VanReturnDashboardResource::collection(VanReturn::all());

        $data = [
            'vans' => $vans,
            'available_vans' => $available_vans,
            'cars' => $cars,
            'available_cars' => $available_cars,
            'vanout_count' => $vanoutCount,
            'vanreturn_count' => $vanreturnsCount,
            'vanouts' => $vanouts,
            'vanins' => $vanins
        ];

        return response()->json($data);
    }
}
