<?php

namespace App\Http\Controllers;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Location $location){
        return $location->all();
    }

    public function store(Request $request, Location $location){
        $location->create($request->all());
        return $location;
    }

    public function show(Location $location){
        return $location;
    }

    public function update(Request $request, Location $location){
        $location->update($request->all());
        return $location;
    }

    public function destroy(Location $location){
        $location->delete();
        return $location;
    }
}
