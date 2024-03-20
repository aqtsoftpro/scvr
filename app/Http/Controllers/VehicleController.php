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
        return response()->json(VehicleResource::collection($vehicle->orderBy('id', 'desc')->get()));
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
                'vehicle_condition' => $request->vehicle_condition,
                // Seller's Info
                'seller_name' => $request->seller_name,
                'seller_address' => $request->seller_address,
                'seller_contact_number' => $request->seller_contact_number,

                //'Next maintenenace ddud'
                'next_maintenance_mileage' => $request->next_maintenance_mileage,
                'next_maintenance_due_date' => $request->next_maintenance_due_date,
                'next_maintenance_service' => $request->next_maintenance_service,
                'next_maintenance_comments' => $request->next_maintenance_comments
            ]
        );

        //Create Insurace Record
        $uploaded_image_path = '';

        if($request->hasFile('damage_picture')){
            $image = $request->file('damage_picture');
            $filename = '/damage-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/insurance'), $filename);
            $uploaded_image_path = url('/images/insurance' . $filename);
        }
        // get storage path
        Insurance::create([
            'vehicle_id' => $new_vehicle->id,
            'company_name' => $request->company_name,
            'policy_number' => $request->policy_number,
            'policy_type_id' => $request->policy_type_id,
            'policy_start_date' => $request->policy_start_date,
            'policy_end_date' => $request->policy_end_date,
            'road_side_assistance' => $request->road_side_assistance,
            'road_side_assistance_company' => $request->road_side_assistance_company,
            'road_side_assistance_start_date' => $request->road_side_assistance_start_date,
            'road_side_assistance_end_date' => $request->road_side_assistance_end_date,
            'demage_details' => $request->demage_details,
            'damage_picture' => $uploaded_image_path
        ]);

        foreach($request->maintenance_records as $maintanance){
            if($maintanance['maintenance_date'] != '' && $maintanance['maintenance_date'] != null){
                Maintenance::create([
                    'vehicle_id' => $new_vehicle->id,
                    'mileage' => isset($maintanance['maintenance_mileage']) ? $maintanance['maintenance_mileage'] : '',
                    'service_type_id' => $maintanance['maintenance_type_id'],
                    'mechanic_name' => isset($maintanance['mechanic_name']) ? $maintanance['mechanic_name'] : '',
                    'cost' => isset($maintanance['maintenance_cost']) ? $maintanance['maintenance_cost'] : '',
                    'place' => isset($maintanance['maintenance_place']) ? $maintanance['maintenance_place'] : '',
                    'date' => $maintanance['maintenance_date'],
                    'part_replaced' => (isset($maintanance['part_replaced'])) ? $maintanance['part_replaced'] : '',
                    'part_repaired' => (isset($maintanance['part_repaired'])) ? $maintanance['part_repaired'] : '',
                    'tyre_replaced' => (isset($maintanance['tyre_replaced'])) ? $maintanance['tyre_replaced'] : '',
                    'comments' => (isset($maintanance['comments'])) ? $maintanance['comments'] : ''
                ]);
             }
        }

        return response()->json($vehicle);
    }

    public function updateStatus(Request $request, Vehicle $vehicle){
        $vehicle->update([
            'status_id' => $request->status_id,
        ]);

        return response()->json($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle){

        $vehicle->update([
            'picture' => $request->picture,
            'vin' => $request->vin,
            'reg_plate_number' => $request->reg_plate_number,
            'mileage' => $request->mileage,
            'make' => $request->make,
            'model' => $request->model,
            'vehicle_type_id' => $request->vehicle_type_id,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'vehicle_condition' => $request->vehicle_condition,

            'seller_name' => $request->seller_name,
            'seller_address' => $request->seller_address,
            'seller_contact_number' => $request->seller_contact_number,

            'next_maintenance_mileage' => $request->next_maintenance_mileage,
            'next_maintenance_due_date' => $request->next_maintenance_due_date,
            'next_maintenance_service' => $request->next_maintenance_service,
            'next_maintenance_comments' => $request->next_maintenance_comments
        ]);



        if(isset($vehicle->insurance)){

            $uploaded_image_path = $vehicle->insurance->damage_picture;

            //Image Upload on if new image has been selected
            if($request->hasFile('damage_picture')){
                $image = $request->file('damage_picture');
                $filename = '/damage-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/insurance'), $filename);
                $uploaded_image_path = url('/images/insurance' . $filename);
            }

            // get storage path

            $vehicle->insurance->update(
                [
                    'vehivle_id' => $vehicle->id,
                    'company_name' => $request->company_name,
                    'policy_number' => $request->policy_number,
                    'policy_type_id' => $request->policy_type_id,
                    'policy_start_date' => $request->policy_start_date,
                    'policy_end_date' => $request->policy_end_date,
                    'road_side_assistance' => $request->road_side_assistance,
                    'rPPoad_side_assistance_company' => $request->road_side_assistance_company,
                    'road_side_assistance_start_date' => $request->road_side_assistance_start_date,
                    'road_side_assistance_end_date' => $request->road_side_assistance_end_date,
                    'demage_details' => $request->demage_details,
                    'damage_picture' => $uploaded_image_path
                ]
            );
        } else {


            $uploaded_image_path = "";

            //Image Upload on if new image has been selected
            if($request->hasFile('damage_picture')){
                $image = $request->file('damage_picture');
                $filename = '/damage-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/insurance'), $filename);
                $uploaded_image_path = url('/images/insurance' . $filename);
            }

            Insurance::create([
                'vehicle_id' => $vehicle->id,
                'company_name' => $request->company_name,
                'policy_number' => $request->policy_number,
                'policy_type_id' => $request->policy_type_id,
                'policy_start_date' => $request->policy_start_date,
                'policy_end_date' => $request->policy_end_date,
                'road_side_assistance' => $request->road_side_assistance,
                'road_side_assistance_company' => $request->road_side_assistance_company,
                'road_side_assistance_start_date' => $request->road_side_assistance_start_date,
                'road_side_assistance_end_date' => $request->road_side_assistance_end_date,
                'demage_details' => $request->demage_details,
                'damage_picture' => $uploaded_image_path
            ]);
        }


        foreach($request->maintenance_records as $maintanance){
            //If record does not exist create a new one
            if(!isset($maintanance['maintenance_id'])){
                if($maintanance['maintenance_date'] != '' && $maintanance['maintenance_date'] != null){
                    Maintenance::create([
                        'vehicle_id' => $vehicle->id,
                        'mileage' => isset($maintanance['maintenance_mileage']) ? $maintanance['maintenance_mileage'] : '',
                        'service_type_id' => isset($maintanance['maintenance_type_id']) ? $maintanance['maintenance_type_id'] : '',
                        'mechanic_name' => isset($maintanance['mechanic_name']) ? $maintanance['mechanic_name'] : '',
                        'cost' => isset($maintanance['maintenance_cost']) ? $maintanance['maintenance_cost'] : '',
                        'place' => isset($maintanance['maintenance_place']) ? $maintanance['maintenance_place'] : '',
                        'date' => $maintanance['maintenance_date'],
                        'part_replaced' => (isset($maintanance['part_replaced'])) ? $maintanance['part_replaced'] : '',
                        'part_repaired' => (isset($maintanance['part_repaired'])) ? $maintanance['part_repaired'] : '',
                        'tyre_replaced' => (isset($maintanance['tyre_replaced'])) ? $maintanance['tyre_replaced'] : '',
                        'comments' => (isset($maintanance['comments'])) ? $maintanance['comments'] : ''
                    ]);
                }
            //else if record exist then update it
            } else {
                Maintenance::find($maintanance['maintenance_id'])->update([
                    'vehicle_id' => $vehicle->id,
                    'mileage' => isset($maintanance['maintenance_mileage']) ? $maintanance['maintenance_mileage'] : '',
                    'service_type_id' => isset($maintanance['maintenance_type_id']) ? $maintanance['maintenance_type_id'] : '',
                    'mechanic_name' => isset($maintanance['mechanic_name']) ? $maintanance['mechanic_name'] : '',
                    'cost' => isset($maintanance['maintenance_cost']) ? $maintanance['maintenance_cost'] : '',
                    'place' => isset($maintanance['maintenance_place']) ? $maintanance['maintenance_place'] : '',
                    'date' => $maintanance['maintenance_date'],
                    'part_replaced' => (isset($maintanance['part_replaced'])) ? $maintanance['part_replaced'] : '',
                    'part_repaired' => (isset($maintanance['part_repaired'])) ? $maintanance['part_repaired'] : '',
                    'tyre_replaced' => (isset($maintanance['tyre_replaced'])) ? $maintanance['tyre_replaced'] : '',
                    'comments' => (isset($maintanance['comments'])) ? $maintanance['comments'] : ''
                ]);
            }
        }


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

    public function get_available_vehicles(Request $request, Vehicle $vehicle){
        $available_vehicles = Vehicle::where('status_id', 1)->where('id', '!=', $vehicle->id)->get();
        $filtered_vehicles = [];

        foreach($available_vehicles as $key => $vehicle){
            $filtered_vehicles[$key]['id'] = $vehicle->id;
            $filtered_vehicles[$key]['name'] = $vehicle->make . ' ' . $vehicle->model . ' (' . $vehicle->reg_plate_number . ')';
        }

        return $filtered_vehicles;
    }

    public function vehicle_options(Vehicle $vehicle, Request $request){

        $vehicles = $vehicle->where('status_id', 1)->orderBy('id', 'desc')->get();
        $options = [];

        foreach($vehicles as $key => $vehicle){
            $options[$key]['id'] = $vehicle->id;
            $options[$key]['name'] = $vehicle->make . ' ' . $vehicle->model . ' (' . $vehicle->reg_plate_number . ')';
        }

        $options = $this->append_selected_item($options, $request->selected);

        return response()->json($options);
    }

    function append_selected_item($list, $value){
        if(isset($value)){
            $cust = Vehicle::find($value);
            if($cust){
                foreach($list as $key => $customer){
                    if($customer['id'] == $cust->id){
                        unset($list[$key]);
                    }
                }
                $list[] = ['id' => $cust->id, 'name' => $cust->make . ' ' . $cust->model . ' (' . $cust->reg_plate_number . ')'];
            }
            return array_values($list);
        } else {
            return $list;
        }
    }
}
