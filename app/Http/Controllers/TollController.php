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
        return response()->json(new Toll($toll->find($toll->id)));
    }

    public function store(Request $request, Toll $toll){


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
            'message' => 'Toll record created',
            'data' => $newToll
        ];
        return response()->json($res);
    }

    public function update(Request $request, Toll $toll){

        $uploaded_image_path = $request->toll_image;
        //upload image
        if($request->hasFile('toll_image')){
            $image = $request->file('toll_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/toll'), $filename);
            $uploaded_image_path = url('/images/toll/' . $filename);
        }

        $request['toll_image'] = $uploaded_image_path;

        $toll->update($request->all());
        $toll->save();

        $res = [
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
