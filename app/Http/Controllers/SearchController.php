<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\SearchResource;

class SearchController extends Controller
{
    public function search(Request $request, Vehicle $vehicle, Customer $customer){
        if(isset($request->mode)){
            if($request->mode == 'vehicle'){
                if(isset($request->keyword)){
                    $results = $vehicle
                    ->where('reg_plate_number', 'like', '%' . $request->keyword . '%')
                    ->get();

                    return response()->json([
                        'mode' => $request->mode,
                        'results' => SearchResource::collection($results)
                    ]);
                } else {

                    $results = $vehicle->all();

                    return response()->json([
                        'mode' => $request->mode,
                        'results' => SearchResource::collection($results)
                    ]);
                }
            } elseif($request->mode == 'customer'){

                $results = $customer
                ->where('first_name', 'like', '%' . $request->keyword . '%')
                ->get();

                return response()->json([
                    'mode' => $request->mode,
                    'results' => $results
                ]);
            } else {
                $results = $customer->all();

                return response()->json([
                    'mode' => $request->mode,
                    'results' => $results
                ]);
            }
        }
    }
}
