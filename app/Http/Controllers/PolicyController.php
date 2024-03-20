<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(){
        return response()->json(Policy::all());
    }

    public function store(Request $request){
        $policy = new Policy();
        $policy->create($request->all());
        return response()->json($policy);
    }

    public function show(Policy $policy){
        return response()->json($policy);
    }

    public function update(Request $request, Policy $policy){
        $policy->update($request->all());
        return response()->json($policy);
    }

    public function destroy(Policy $policy){
        $policy->delete();
        return response()->json($policy);
    }

    public function policy_options(Policy $policy){
        return response()->json($policy->all(['id', 'name']));
    }
}
