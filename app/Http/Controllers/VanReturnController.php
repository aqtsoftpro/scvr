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

        $uploaded_image_path = '';
        //upload image
        if($request->hasFile('demage_picture')){
            $image = $request->file('demage_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/damagePics/'), $filename);
            $uploaded_image_path = url('/images/damagePics/' . $filename);
        }

        // get storage path


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

        $newVanReturn = $vanReturn->create([
            'van_out_id' => $request->van_out_id,
            'location_id' => $request->location_id,
            'mileage' => $request->mileage,
            'fuel_tank' => $request->fuel_tank,
            'condition' => $request->condition,
            'require_maintenance' => $request->require_maintenance,
            'require_maintenance_text' => $request->require_maintenance_text,
            'demage_caused_by_customer' => $request->demage_caused_by_customer,
            'return_date' => $request->return_date,
            'demage_picture' => $uploaded_image_path,
            'demage_text' => $request->demage_text,
            'bond_deposit' => $request->bond_deposit,
            'payment_mode' => $request->payment_mode,
            'bond_return_amount' => $request->bond_return_amount
        ]);

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

        $demagePicture = $request->demage_picture;

        if($request->hasFile('demage_picture')){
            $image = $request->file('demage_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/damagePics'), $filename);
            $demagePicture = url('/images/damagePics/' . $filename);
        }

        $vanReturn->update([
            'van_out_id' => $request->van_out_id,
            'location_id' => $request->location_id,
            'mileage' => $request->mileage,
            'fuel_tank' => $request->fuel_tank,
            'condition' => $request->condition,
            'require_maintenance' => $request->require_maintenance,
            'require_maintenance_text' => $request->require_maintenance_text,
            'demage_caused_by_customer' => $request->demage_caused_by_customer,
            'return_date' => $request->return_date,
            'demage_picture' => $demagePicture,
            'demage_text' => $request->demage_text,
            'bond_deposit' => $request->bond_deposit,
            'payment_mode' => $request->payment_mode,
            'bond_return_amount' => $request->bond_return_amount
        ]);
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
