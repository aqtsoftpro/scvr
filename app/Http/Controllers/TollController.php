<?php

namespace App\Http\Controllers;

use App\VanOut;
use App\VanReturn;
use Carbon\Carbon;
use App\Models\Toll;
use Illuminate\Http\Request;
use App\Http\Resources\TollResource;

class TollController extends Controller
{
    public function index(Toll $toll){
        return response()->json(TollResource::collection($toll->orderBy('id', 'desc')->get()));
    }

    public function show(Toll $toll){
        return response()->json(new TollResource($toll->find($toll->id)));
    }

    public function store(Request $request, Toll $toll){

        $validation = $request->validate([
            'toll_number' => 'required',
            'date' => 'required|date',
            'toll_image' => 'required'
        ]);

        //upload image
        if($request->hasFile('toll_image')){
            $image = $request->file('toll_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/toll'), $filename);
            $uploaded_image_path = url('/images/toll/' . $filename);
        }
        // get storage path

        $newToll = $toll->create([
            'toll_number' => $request->toll_number,
            'date' => $request->date,
            'reg_plate_number' => $request->reg_plate_number,
            'customer_id' => $request->customer_id,
            'toll_image' => $uploaded_image_path,
            'payment_status' => $request->payment_status
        ]);


        // $reg_plate_number = $request->reg_plate_number;
        // $date = $request->date;
        // $vanOuts = VanOut::all();
        // $vanOutRecords = [];
        // $index = 0;
        // if($vanOuts->count() > 0){
        //     foreach($vanOuts as $vanOut){
        //         if($vanOut->vehicle->reg_plate_number == $reg_plate_number && Carbon::parse($date)->between(Carbon::parse($vanOut->van_out_date)->format('Y-m-d'), Carbon::parse($vanOut->due_return)->format('Y-m-d'))){
        //             $vanOutRecords[$index]['id'] = $vanOut->id;
        //             $vanOutRecords[$index]['reg_plate_number'] = $vanOut->vehicle->reg_plate_number;
        //             $vanOutRecords[$index]['van_out_date'] = Carbon::parse($vanOut->van_out_date)->format('Y-m-d');
        //             $vanOutRecords[$index]['due_return'] = Carbon::parse($vanOut->due_return)->format('Y-m-d');
        //             $vanOutRecords[$index]['customer'] = $vanOut->customer->first_name . ' ' . $vanOut->customer->last_name;
        //             $vanOutRecords[$index]['customer_id'] = $vanOut->customer->id;
        //         }
        //         $index++;
        //     }

        //     $vanOutRecords = array_values($vanOutRecords);

        //     if(count($vanOutRecords) > 0){
        //         $newToll->update(['customer_id' => $vanOutRecords[0]['customer_id']]);
        //     }
        // }
        // return response()->json($vanOutRecords);


        $res = [
            'status' => 'success',
            'message' => 'Toll record created',
            'data' => $newToll
        ];
        return response()->json($res);
    }

    public function search_toll_record($tollDate, $plateNumber){
        // return response()->json([
        //     'toll_date' => $tollDate,
        //     'plate_number' => $plateNumber
        // ]);

        // return Carbon::parse($tollDate)->between(Carbon::parse('08-11-2023')->format('d-m-Y'), Carbon::parse('11-11-2023')->format('d-m-Y'));

        $records = [];
        if($tollDate != ''){
            $vanout_records =  VanOut::with('vehicle', 'customer')->get();
            foreach($vanout_records as $vanout){

                if(Carbon::parse($tollDate)->between(Carbon::parse($vanout->van_out_date), Carbon::parse($vanout->due_return))){
                    if($vanout->vehicle->reg_plate_number == $plateNumber){
                        $records[] = [
                            'id' => $vanout->id,
                            'van_out_date' => Carbon::parse($vanout->van_out_date)->format('d-m-Y'),
                            'due_return' => Carbon::parse($vanout->due_return)->format('d-m-Y'),
                            'customer' => $vanout->customer->first_name . ' ' . $vanout->customer->last_name,
                            'customer_id' => $vanout->customer->id,
                            'customer_email' => $vanout->customer->email,
                            'vehicle' => $vanout->vehicle->reg_plate_number,
                        ];
                    }
                }
            }
        }
        return response()->json($records);
    }

    public function update(Request $request, Toll $toll){

        $tollImage = $request->toll_image;

        if($request->hasFile('toll_image')){
            $image = $request->file('toll_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/toll'), $filename);
            $tollImage = url('/images/toll/' . $filename);
        }

        $toll->update($request->all());
        $toll->save();

        $res = [
            'status' => 'success',
            'message' => 'Toll record updated',
            'data' => $toll
        ];

        return response()->json($res);

    }

    public function destroy(Toll $toll){
        $toll->delete();
        $res = [
            'message' => 'Toll record deleted',
        ];
        return response()->json($res, 204);
    }

    public function van_out_options(Toll $toll){
        return response()->json(TollResource::collection($toll->all()));
    }
}
