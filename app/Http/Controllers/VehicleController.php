<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Insurance;
use App\Maintenance;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Resources\VehicleResource;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Vehicle $vehicle){
        return response()->json(VehicleResource::collection($vehicle->all()));
    }

    public function show(Vehicle $vehicle){
        return response()->json(new VehicleResource($vehicle));
    }

    public function store(Request $request, Vehicle $vehicle){

        //upload image
        if($request->hasFile('picture')){
            $image = $request->file('picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
        }
        // get storage path
        $uploaded_image_path = url('/images/' . $filename);

        $new_vehicle = $vehicle->create(
            [
                //Basic Vehicle Info
                'picture' => $uploaded_image_path,
                'vin' => $request->vin,
                'reg_plate_number' => $request->reg_plate_number,
                'mileage' => $request->mileage,
                'make' => $request->make,
                'model' => $request->model,
                'vehicle_type_id' => $request->vehicle_type_id,
                'purchase_date' => $request->purchase_date,
                'purchase_price' => $request->purchase_price,
                // Seller's Info
                'seller_name' => $request->seller_name,
                'seller_address' => $request->seller_address,
                'seller_contact_number' => $request->seller_contact_number,

                //'Next maintenenace ddud'
                'next_maintenance_due_date' => $request->next_maintenance_due_date
            ]
        );

        //Create Insurace Record
        Insurance::create([
            'vehicle_id' => $new_vehicle->id,
            'company_name' => $request->company_name,
            'policy_type_id' => $request->policy_type_id,
            'policy_start_date' => $request->policy_start_date,
            'policy_end_date' => $request->policy_end_date,
            'road_side_assistance' => $request->road_side_assistance,
            'road_side_assistance_start_date' => $request->road_side_assistance_start_date,
            'road_side_assistance_end_date' => $request->road_side_assistance_end_date,
            'demage_details' => $request->demage_details
        ]);

        foreach($request->maintenance_records as $maintanance){
            Maintenance::create([
                'vehicle_id' => $new_vehicle->id,
                'mileage' => $maintanance['maintenance_mileage'],
                'service_type_id' => $maintanance['maintenance_type_id'],
                'mechanic_name' => $maintanance['mechanic_name'],
                'cost' => $maintanance['maintenance_cost'],
                'place' => $maintanance['maintenance_place'],
                'date' => $maintanance['maintenance_date'],
                'part_replaced' => (isset($maintanance['part_replaced'])) ? $maintanance['part_replaced'] : '',
                'comments' => $maintanance['comments']
            ]);
        }

        return response()->json($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle){
        $vehicle->update($request->all());
        return response()->json($vehicle);
    }

    public function destroy(Vehicle $vehicle){
        try {
            $vehicle->delete();
            return response()->json([
                'status' => 'sucess',
                'message' => 'Vehicle deleted successfully!',
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle could not be deleted!',
            ]);
        }

    }

    public function vehicle_options(Vehicle $vehicle, Request $request){

        if($request->mode == 'active'){
            $vehicles = $vehicle->where('status_id', 1)->get();
            $options = [];

            foreach($vehicles as $key => $vehicle){
                $options[$key]['id'] = $vehicle->id;
                $options[$key]['name'] = $vehicle->make . ' ' . $vehicle->model . ' (' . $vehicle->reg_plate_number . ')';
            }

            return response()->json($options);

        } else {
            $vehicles = $vehicle->where('status_id', 1)->get();
            $options = [];

            foreach($vehicles as $key => $vehicle){
                $options[$key]['id'] = $vehicle->id;
                $options[$key]['name'] = $vehicle->make . ' ' . $vehicle->model . ' (' . $vehicle->reg_plate_number . ')';
            }
            return response()->json($options);
        }
    }
}
