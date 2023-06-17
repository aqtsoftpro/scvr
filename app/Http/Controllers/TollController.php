<?php

namespace App\Http\Controllers;

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
            'toll_image' => $uploaded_image_path
        ]);
        $res = [
            'status' => 'success',
            'message' => 'Toll record created',
            'data' => $newToll
        ];
        return response()->json($res);
    }

    public function update(Request $request, Toll $toll){

        $tollImage = $request->toll_image;

        if($request->hasFile('toll_image')){
            $image = $request->file('toll_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/toll'), $filename);
            $tollImage = url('/images/toll/' . $filename);
        }

        $toll->update([
            'toll_number' => $request->toll_number,
            'date' => $request->date,
            'toll_image' => $tollImage
        ]);
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
