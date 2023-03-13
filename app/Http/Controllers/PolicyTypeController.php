<?php

namespace App\Http\Controllers;

use App\PolicyType;
use Illuminate\Http\Request;

class PolicyTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(PolicyType $policyType){
        return $policyType->all();
    }

    public function store(Request $request, PolicyType $policyType){
        $policyType->create($request->all());
        return $policyType;
    }

    public function update(Request $request, PolicyType $policyType){
        $policyType->update($request->all());
        return $policyType;
    }

    public function destroy(PolicyType $policyType){
        $policyType->delete();
        return $policyType;
    }

}
