<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Resources\VanOutResource;
use App\Http\Resources\VanoutOptionsResource;

class VanOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request, VanOut $vanOut){
        if(isset($request->mode) && $request->mode == 'active'){
            return response()->json(VanOutResource::collection($vanOut->where('status', 1)->get()));
        }
        return response()->json(VanOutResource::collection($vanOut->orderBy('id','desc')->get()));
    }

    public function show($vanOut){
        return response()->json(Vanout::find($vanOut));
    }

    public function store(Request $request, VanOut $vanOut){

        /*
        Create a new booking
        */
        $vanOut->fill($request->all());
        $vanOut->save();

        /*
        Update the vehicle status to rented out
        */
        $vanOut->vehicle()->update([
            'status_id' => 2
        ]);

        /*
        Send the success message and created object
        */
        $res = [
            'message' => 'Booking created',
            'data' => $vanOut
        ];
        return response()->json($res);
    }

    public function update(Request $request, $vanOut){
        $booking = VanOut::find($vanOut);
        $booking->fill($request->all());
        $booking->save();
        $res = [
            'message' => 'Booking updated',
            'data' => $vanOut
        ];
        return response()->json($res);
    }

    public function destroy($vanOut){
        Vanout::find($vanOut)->delete();
        $res = [
            'message' => 'Booking deleted',
        ];
        return response()->json($res, 204);
    }

    public function van_out_options(VanOut $vanOut){
        return response()->json(VanoutOptionsResource::collection($vanOut->all()));
        return $vanOut->query()->with(['vehicle' => function($query){
            $query->select('id', 'reg_plate_number');
        }])->get(['id', 'vehicle_id']);
    }
}
