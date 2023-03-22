<?php

namespace App\Http\Controllers;

use App\TaxRecord;
use Illuminate\Http\Request;

class TaxRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(TaxRecord $taxRecord){
        return $taxRecord->all();
    }

    public function show(TaxRecord $taxRecord){
        return $taxRecord->find($taxRecord->id);
    }

    public function store(Request $request, TaxRecord $taxRecord){
        $taxRecord->create($request->all());
        return $taxRecord;
    }

    public function update(Request $request, TaxRecord $taxRecord){
        $taxRecord->update($request->all());
        return $taxRecord;
    }
    public function destroy(TaxRecord $taxRecord){
        $taxRecord->delete();
        return $taxRecord;
    }

    public function tax_record_options(TaxRecord $taxRecord){
        return response()->json($taxRecord->all(['id', 'name']));
    }
}
