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
            return response()->json(VanOutResource::collection($vanOut->where('status', 1)->orderBy('id', 'desc')->get()));
        }
        return response()->json(VanOutResource::collection($vanOut->orderBy('id','desc')->get()));
    }

    public function show($vanOut){
        return response()->json(new VanOutResource(Vanout::find($vanOut)));
    }

    public function store(Request $request, VanOut $vanOut){

        /*
        Create a new booking
        */
        $validation = $request->validate([
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'location_id' => 'required|integer',
            'reason_of_renting' => 'required',
            'rental_period' => 'required',
            'rental_amount' => 'required',
            'amount_frequency' => 'required',
            'mileage' => 'required',
            'van_out_date' => 'required',
            'due_return' => 'required',
            'accessories' => 'required'
        ],
    [
        'customer_id.integer' => 'Select Customer',
        'vehicle_id.integer' => 'Select Vehicle ',
        'location_id.integer' => 'Select Location',
    ]);




        $vanOut->fill($request->all());
        $vanOut->save();

        /*
        Add assign accessories to vanout
        */
        $vanOut->accessories()->attach($request->accessories);

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
            'status' => 'success',
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
        $vehicle_id = VanOut::find($vanOut)->vehicle_id;
        Vanout::find($vanOut)->delete();

        Vehicle::find($vehicle_id)->update([
            'status_id' => 1
        ]);

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
