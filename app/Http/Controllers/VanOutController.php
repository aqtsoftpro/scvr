<?php

namespace App\Http\Controllers;

use App\VanOut;
use Illuminate\Http\Request;
use App\Http\Resources\VanOutResource;

class VanOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(VanOut $vanOut){
        return response()->json(VanOutResource::collection($vanOut->orderBy('id','desc')->get()));
    }

    public function show($vanOut){
        return response()->json(Vanout::find($vanOut));
    }

    public function store(Request $request, VanOut $vanOut){
        $vanOut->fill($request->all());
        $vanOut->save();
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
        return $vanOut->query()->with(['vehicle' => function($query){
            $query->select('id', 'reg_plate_number');
        }])->get(['id', 'vehicle_id']);
    }
}
