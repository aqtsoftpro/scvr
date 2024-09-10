<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\VanReturn;
use App\Models\{DemageGallery, Customer};
use Illuminate\Http\Request;
use App\Http\Resources\{VanReturnResource, ShowVanReturnResource};

class VanReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(VanReturn $vanReturn){
        $vanReturn = $vanReturn->with('van_out.vehicle', 'van_out.customer')->orderBy('updated_at', 'desc')->get();
        return response()->json(VanReturnResource::collection($vanReturn));
        // return response()->json($vanReturn);
    }

    public function show(VanReturn $vanReturn){
        // $vanReturn->load('location', 'van_out.swaps');
        // ->find($vanReturn->id)
        return response()->json(new ShowVanReturnResource($vanReturn));
    }

    public function store(Request $request, VanReturn $vanReturn){

        $uploaded_image_path = '';
        $new_path = '';
        $status = 1;
        $video_url = '';
        //upload image
        if($request->hasFile('demage_vid')){
            $video = $request->file('demage_vid')->store('demage-videos', 'public');
            $video_url = url('storage/'.$video);
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
            'bond_return_amount' => $request->bond_return_amount,
            'total_driven' => $request->total_driven,
            'days_count' => $request->days_count,
            'video' => $video_url,
            'bond_comment' => $request->bond_comment,
            'bond_diff' => $request->bond_diff,
            'cust_fine' => $request->cust_fine ?? 0.00
        ]);


        if ($request->hasFile('demage_picture')) {
            foreach ($request->file('demage_picture') as $image) {
                $imagePath = $image->store('demage-gallery', 'public');
                $main_path = url('storage/'.$imagePath);
                $gallery = DemageGallery::create([
                    'van_return_id'=> $newVanReturn->id,
                    'image' => $main_path
                ]);
            }
            $new_path = $main_path;
            $status = 3;
        }

        $newVanReturn->update([
            'demage_picture' => $new_path
        ]);

        $booking = VanOut::find($newVanReturn->van_out_id);
        $booking->customer()->update([
            'is_available' => 1
        ]);
        if ($booking->swaps()->count() > 0) {
            $swap = $booking->swaps()->latest()->first();
            $swap->update([
                'vehicle_return_date' => $newVanReturn->return_date,
                'status'=> 0
            ]);
            $swap->vehicle()->update([
                'status_id' => $status,
                'mileage' => $request->mileage
            ]);
        }
        else {
            $booking->vehicle()->update([
                'status_id' => $status,
                'mileage' => $request->mileage
            ]);
        }

        $booking->status = 0;
        $booking->save();

        $res = [
            'status' => 'Success',
            'message' => 'Vehicle return record created',
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
            'bond_return_amount' => $request->bond_return_amount,
            'bond_comment' => $request->bond_comment
        ]);
        $booking = VanOut::find($vanReturn->van_out_id);
        $booking->vehicle()->update([
            'mileage' => $request->mileage
        ]);
        $res = [
            'message' => 'Vehicle return record updated',
            'data' => $vanReturn
        ];
        return response()->json($res);
    }

    public function destroy(VanReturn $vanReturn){
        $van_out = VanOut::find($vanReturn->van_out_id);
        if ($van_out) {
            $van_out->update([
                'status' => 1
            ]);
            if ($van_out->vehicle_id !== null) {
                $van_out->vehicle()->update([
                    'status_id' => 1
                ]);
            }

            if ($van_out->customer_id !== null) {
                $customer = Customer::find($van_out->customer_id);
                if ($customer) {
                    $customer->update([
                        'is_available' => 0
                    ]);
                }
            }
        }
        $vanReturn->delete();
        $res = [
            'message' => 'Vehicle return record deleted',
        ];
        return response()->json($res, 204);
    }

    public function van_return_options(VanReturn $vanReturn){
        return response()->json($vanReturn->all(['id', 'condition']));
    }

}
