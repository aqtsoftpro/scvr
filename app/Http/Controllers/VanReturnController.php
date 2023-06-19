<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\VanReturn;
use Illuminate\Http\Request;
use App\Http\Resources\VanReturnResource;

class VanReturnController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }

    public function index(VanReturn $vanReturn){
        return response()->json(VanReturnResource::collection($vanReturn->orderBy('id', 'desc')->get()));
    }

    public function show(VanReturn $vanReturn){
        return response()->json($vanReturn->find($vanReturn->id));
    }

    public function store(Request $request, VanReturn $vanReturn){

        $validation = $request->validate([
            'van_out_id' => 'required|integer',
            'location_id' => 'required|integer',
            'mileage' => 'required',
            'fuel_tank' => 'required',
            'condition' => 'required',
            'require_maintenance' => 'required',
            'demage_caused_by_customer' => 'required',
            'return_date' => 'required',
        ],[
            'van_out_id.integer' => 'Select Booking ID from list',
            'location_id.integer' => 'Select Location',
        ]);

        $newVanReturn = $vanReturn->create($request->all());

        $booking = VanOut::find($newVanReturn->van_out_id);
        $booking->vehicle()->update([
            'status_id' => 3
        ]);
        $booking->status = 0;
        $booking->save();

        $res = [
            'status' => 'success',
            'message' => 'Van return record created',
            'data' => $vanReturn
        ];
        return response()->json($res);
    }

    public function update(Request $request, VanReturn $vanReturn){
        $vanReturn->update($request->all());
        $vanReturn->save();
        $res = [
            'message' => 'Van return record updated',
            'data' => $vanReturn
        ];
        return response()->json($res);
    }

    public function destroy(VanReturn $vanReturn){
        $vanReturn->delete();
        $res = [
            'message' => 'Van return record deleted',
        ];
        return response()->json($res, 204);
    }

    public function van_return_options(VanReturn $vanReturn){
        return response()->json($vanReturn->all(['id', 'condition']));
    }
}
