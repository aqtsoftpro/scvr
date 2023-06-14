<?php

namespace App\Http\Controllers;

use App\Insurance;
use Illuminate\Http\Request;
use App\Http\Resources\InsuranceResource;

class InsuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Insurance $insurance){
        return response()->json(InsuranceResource::collection($insurance->all()));
    }

    public function store(Request $request, Insurance $insurance){

        //upload image
        if($request->hasFile('damage_picture')){
            $image = $request->file('damage_picture');
            $filename = 'damage-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/insurance'), $filename);
        }
        // get storage path
        $uploaded_image_path = url('/images/' . $filename);

        $insurance->create([
            'vehicle_id' => $request->vehicle_id,
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
        return $insurance;
    }

    public function show(Insurance $insurance){
        return $insurance;
    }

    public function update(Request $request, Insurance $insurance){
        return $insurance->update($request->all());
    }

    public function destroy(Insurance $insurance){
        return $insurance->delete();
    }

    public function insurance_options(Insurance $insurance){
        return response()->json($insurance->all(['id', 'name']));
    }
}
