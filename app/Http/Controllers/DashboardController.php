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

        //return VanOut::where('status', 1)->get('due_return');
        //return VanoutDashboardResource::collection(VanOut::whereBetween('due_return', [Carbon::now()->format('d-m-Y'), Carbon::now()->addDays(7)->format('d-m-Y')])->where('status', 1)->get());
        //return VanOut::whereBetween('due_return', 'desc')->get('due_return');
        //return Carbon::now()->format('d-m-Y h:i:s') . ' - ' . Carbon::now()->addDays(7)->format('d-m-Y h:i');

        $vans = Vehicle::where('vehicle_type_id', 3)->count();
        $available_vans = Vehicle::where('vehicle_type_id', 3)->where('status_id', 1)->count();
        $cars = Vehicle::where('vehicle_type_id', 1)->count();
        $available_cars = Vehicle::where('vehicle_type_id', 1)->where('status_id', 1)->count();
        $vanoutCount = VanOut::where('status', 1)->count();
        $vanreturnsCount = VanReturn::count();


        //$vanouts = VanoutDashboardResource::collection(VanOut::whereBetween('due_return', [Carbon::now()->format('d-m-Y'), Carbon::now()->addDays(7)->format('d-m-Y')])->where('status', 1)->get());
        $vanoutsArray = [];
        $vanouts = VanoutDashboardResource::collection(VanOut::where('status', 1)
                        //->whereBetween('due_return', [Carbon::now()->format('Y-m-d'), Carbon::now()->addDays(7)->format('Y-m-d')])
                        //->where('due_return', '<=', Carbon::now()->addDays(7)->format('d-m-Y'))
                        ->get());

        foreach($vanouts as $vanout){
            //return (date('d-m-Y', strtotime($vanout->due_return)) > date('d-m-Y'))? 'yes' : 'no';
            //return Carbon::createFromFormat('d-m-Y', '1-1-2023 12:00')->format('d-m-Y');
            if(
                date('d-m-Y', strtotime($vanout->due_return)) > Carbon::now()->format('d-m-Y')
                && date('d-m-Y', strtotime($vanout->due_return)) <= Carbon::now()->addDays(7)->format('d-m-Y')
            ){
                $vanoutsArray[] = $vanout;
            }
        }


        $vanins = VanReturnDashboardResource::collection(VanReturn::all());

        $data = [
            'vans' => $vans,
            'available_vans' => $available_vans,
            'cars' => $cars,
            'available_cars' => $available_cars,
            'vanout_count' => $vanoutCount,
            'vanreturn_count' => $vanreturnsCount,
            'vanouts' => $vanoutsArray,
            'vanins' => $vanins
        ];

        return response()->json($data);
    }
}
