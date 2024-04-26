<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\Vehicle;
use App\Accessory;
use App\Models\Customer;
use App\Models\{DemageGallery, Swap, SwapGallery};
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
            return response()->json(VanOutResource::collection($vanOut->with('swapWith')->where('status', 1)->orderBy('id', 'desc')->get()));
        }
        return response()->json(VanOutResource::collection($vanOut->with('swapWith')->orderBy('id','desc')->get()));
    }

    public function show($vanOut){
        $van_out = Vanout::find($vanOut);
        return response()->json(new VanOutResource($van_out));
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
            'rental_amount' => 'required',
            'amount_frequency' => 'required',
            'mileage' => 'required',
            'van_out_date' => 'required',
            'accessories' => 'required'
        ],
        [
            'customer_id.integer' => 'Select Customer',
            'vehicle_id.integer' => 'Select Vehicle ',
            'location_id.integer' => 'Select Location',
        ]);
        //$access_to_be_attached =  array_values($request->accessories);

        //$access_to_be_attached = [];
        //foreach($request->accessories as $accessory){
        //    $access_to_be_attached[] = $accessory;
        //}
        //return $access_to_be_attached;
        $data = array_merge($request->all(), ['booking_id' => md5(now())]);
        // $data['rental_period'] = 
        if ($request->hasFile('demage_video')) {
            $video = $request->file('demage_video')->store('demage-videos', 'public');
            $data['video'] =url('storage/'.$video);
        }

        $vanout = Vanout::create($data);

        if ($vanout && $request->hasFile('demage_pics')) {
            foreach ($request->file('demage_pics') as $image) {
                $imagePath = $image->store('demage-gallery', 'public');
                $main_path = url('storage/'.$imagePath);
                $gallery = DemageGallery::create([
                    'van_out_id'=> $vanout->id,
                    'image' => $main_path
                ]);
            }
        }

        if ($vanout) {
            $customer = Customer::find($request->customer_id);
            $customer->update([
                'is_available' => 0
            ]);
        }

        /*
        Add assign accessories to vanout
        */

        $vanout->accessories()->attach($request->accessories);

        /*
        Update the vehicle status to rented out
        */
        $vanout->vehicle()->update([
            'status_id' => 2
        ]);

        /*
        Send the success message and created object
        */
        $res = [
            'status' => 'success',
            'message' => 'Booking created',
            'data' => $vanout
        ];
        return response()->json($res);
    }

    public function update(Request $request, $vanOut){
        $booking = VanOut::find($vanOut);
        if ($booking->swap_with !== null) {
            Vehicle::find($booking->swap_with)->update([
                'status_id' => 1
            ]);

            $swap = $booking->swaps()->latest()->first();
        }

        $data = $request->all();
        if ($request->hasFile('demage_video')) {
            $video = $request->file('demage_video')->store('demage-videos', 'public');
            $data['video'] =url('storage/'.$video);
        }

        $booking->fill($data);
        $booking->save();

        $booking->vehicle()->update([
            'status_id' => 1
        ]);

        if ($booking->reason_of_renting== 'Swap' && $request->swapped_data != null ) {
            $vehicle = Vehicle::find($request->swapped_data['vehicle_id']);
            $vehicle->update([
                'status_id' => 2
            ]);

            // dd($vehicle);

            if ($request->hasFile('swapped_data.video')) {
                dd($request->file('swapped_data.video'));
                $save_path = $request->file('swapped_data.video')->store('swaped', 'public');
            }



            $swap = Swap::create([
                'customer_id' => $booking->customer_id,
                'vehicle_id' => $vehicle->id,
                'parent_id' => $swap->id ?? null,
                'van_out_id' => $booking->id,
                'condition' => $request->swapped_data['condition'],
                'video' => $save_path ?? null,
                // 'rental_period' => $request->swapped_data['rental_period'],
                'rental_amount' => $request->swapped_data['rental_amount'],
                'out_date' => $request->swapped_data['out_date'],
                'vehicle_reg' => $vehicle->reg_plate_number,
                'long_term' => $request->swapped_data['long_term'],
                'due_return' => $request->swapped_data['due_return'],
                'location_id' => $request->swapped_data['location_id'],
                'mileage' => $request->swapped_data['mileage'],
                'amount_frequency' => $request->swapped_data['amount_frequency'],
            ]);

            if ($swap && $request->hasFile('swapped_data.images')) {
                foreach ($request->file('swapped_data.images') as $image) {
                    $imagePath = $image->store('swaped-gallery', 'public');

                    SwapGallery::create([
                        'swap_id' => $swap->id, 
                        'image' => $imagePath
                    ]);

                }
            }
        }

        if ($request->hasFile('demage_pics')) {
            foreach ($request->file('demage_pics') as $image) {
                $imagePath = $image->store('demage-gallery', 'public');
                $main_path = url('storage/'.$imagePath);
                $gallery = DemageGallery::create([
                    'van_out_id'=> $booking->id,
                    'image' => $main_path
                ]);
            }
        }


        $res = [
            'message' => 'Booking updated',
            'data' => $vanOut
        ];

        $booking->accessories()->sync($request->accessories);

        return response()->json($res);
    }

    public function destroy($vanOut){
        $out_vehicle = VanOut::find($vanOut);
        if ($out_vehicle && $out_vehicle->vehicle_id !== null) {
            Vehicle::find($out_vehicle->vehicle_id)->update([
                'status_id' => 1
            ]);
        }

        if ($out_vehicle && $out_vehicle->customer_id !== null) {
            $customer = Customer::find($out_vehicle->customer_id);
            $customer->update([
                'is_available' => 1
            ]);
        }


        $out_vehicle->delete();
        $res = [
            'message' => 'Booking deleted',
        ];
        return response()->json($res, 204);
    }

    public function van_out_options(VanOut $vanOut, Request $request){

        $vanouts = $vanOut->where('status', 1)->with('vehicle')->get();
        $list = [];

        foreach($vanouts as $key => $vanout){
            $list[] = ['id' => $vanout['id'] , 'booking_regnumber' => $vanout['vehicle']['reg_plate_number']];
        }

        //return $list;
        //$vanouts = VanoutOptionsResource::collection($list);

        $vanouts = $this->append_selected_item($list, $request->selected);

        return response()->json($vanouts);

        return $vanOut->query()->with(['vehicle' => function($query){
            $query->select('id', 'reg_plate_number');
        }])->get(['id', 'vehicle_id']);
    }

    public function returned_van_out_options(VanOut $vanOut){
        return response()->json(VanoutOptionsResource::collection($vanOut->where('status', 0)->get()));
    }

    function append_selected_item($list, $value){
        if(isset($value)){
            $vanout = VanOut::find($value);
            if($vanout){
                foreach($list as $key => $customer){
                    if($customer['id'] == $vanout->id){
                        unset($list[$key]);
                    }
                }
                $vahicle = Vehicle::find($vanout->vehicle_id);
                $list[] = ['id' => $vanout->id, 'booking_regnumber' => $vahicle->reg_plate_number];
            }
            return $list;
        } else {
            return $list;
        }
    }

    public function customer_van_out($id)
    {
        $booking = VanOut::where(['customer_id' => $id, 'status'=> 1])->latest()->first();
        if ($booking) {
            return response()->json($booking);
        } else {
            $booking = null;
        }
        
    }
}
