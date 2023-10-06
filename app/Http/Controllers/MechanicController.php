<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index(Mechanic $mechanic){
        return response()->json($mechanic->orderBy('id', 'desc')->get());
    }

    public function show(Mechanic $mechanic){
        return response()->json($mechanic->find($mechanic->id));
    }

    public function store(Request $request, Mechanic $mechanic){

        $validation = $request->validate([
           'name' => 'required',
           'workshop_contact' => 'required',
           'workshop_address' => 'required',
           'expertise' => 'required',
           'comments' => 'required'
        ]);

        if($newMechanic = $mechanic->create($request->all())){
            $res = [
                'status' => 'success',
                'message' => 'Mechanic record created',
                'data' => $newMechanic
            ];
            return response()->json($res);
        } else {
            $res = [
                'status' => 'error',
                'message' => 'Mechanic record not created',
            ];
            return response()->json($res);
        }
    }

    public function update(Request $request, Mechanic $mechanic){
        $mechanic->update($request->all());
        if($mechanic->save()){
            $res = [
                'status' => 'success',
                'message' => 'Mechanic record updated',
                'data' => $mechanic
            ];
            return response()->json($res);
        } else {
            $res = [
                'status' => 'error',
                'message' => 'Mechanic record not updated',
            ];
            return response()->json($res);
        }

    }

    public function destroy(Mechanic $mechanic){

        if($mechanic->delete()){
            $res = [
                'status' => 'success',
                'message' => 'Mechanic record deleted',
            ];
            return response()->json($res);
        } else {
            $res = [
                'status' => 'error',
                'message' => 'Mechanic record not deleted',
            ];
            return response()->json($res);
        }

    }

    public function mechanic_options(Mechanic $mechanic){
        return response()->json($mechanic->all());
    }
}
