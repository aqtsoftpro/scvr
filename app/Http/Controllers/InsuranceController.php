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
        $insurance->create($request->all());
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
}
