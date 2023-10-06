<?php

namespace App\Http\Controllers;

use App\TaxType;
use Illuminate\Http\Request;

class TaxTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(TaxType $taxType){
        return $taxType->all();
    }

    public function show(TaxType $taxType){
        return $taxType;
    }

    public function store(Request $request, TaxType $taxType){
        $taxType->create($request->all());
        return $taxType;
    }

    public function update(Request $request, TaxType $taxType){
        $taxType->update($request->all());
        return $taxType;
    }

    public function destroy(TaxType $taxType){
        $taxType->delete();
        return $taxType;
    }

    public function tax_type_options(TaxType $taxType){
        return response()->json($taxType->all(['id', 'name']));
    }
}
