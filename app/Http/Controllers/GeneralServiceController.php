<?php

namespace App\Http\Controllers;

use App\GeneralService;
use Illuminate\Http\Request;

class GeneralServiceController extends Controller
{
    public function __construct()   {
      $this->middleware('auth:sanctum');
    }

    public function index(GeneralService $general_service){
        return $general_service->all();
    }

    public function store(Request $request, GeneralService $general_service){
        $general_service->create($request->all());
        return response()->json($general_service);
    }

    public function show(GeneralService $general_service, int $id){
        return response()->json($general_service->find($id));
    }

    public function update(Request $request, GeneralService $general_service, int $id){
        $general_service->find($id)->update($request->all());
        return $general_service;
    }

    public function destroy(GeneralService $general_service, int $id){
        $general_service->find($id)->delete();
    }
}
