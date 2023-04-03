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
        $newMechanic = $mechanic->create($request->all());
        $res = [
            'message' => 'Mechanic record created',
            'data' => $newMechanic
        ];
        return response()->json($res);
    }

    public function update(Request $request, Mechanic $mechanic){
        $mechanic->fill($request->all());
        $mechanic->save();
        $res = [
            'message' => 'Mechanic record updated',
            'data' => $mechanic
        ];
        return response()->json($res);
    }

    public function destroy(Mechanic $mechanic){

        $mechanic->delete();
        $res = [
            'message' => 'Mechanic record deleted',
        ];
        return response()->json($res, 204);
    }
}
