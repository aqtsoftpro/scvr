<?php

namespace App\Http\Controllers;

use App\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(ServiceType $serviceType){
        return $serviceType->all();
    }

    public function store(Request $request, ServiceType $serviceType){
        $serviceType->create($request->all());
        return $serviceType->all();
    }

    public function show(ServiceType $serviceType){
        return $serviceType->find($serviceType->id);
    }

    public function update(Request $request, ServiceType $serviceType){
        $serviceType->update($request->all());
        return $serviceType->all();
    }

    public function destroy(ServiceType $serviceType){
        $serviceType->delete();
        return $serviceType->all();
    }
}
