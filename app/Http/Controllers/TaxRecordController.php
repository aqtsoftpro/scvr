<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaxRecordResource;
use App\TaxRecord;
use Illuminate\Http\Request;

class TaxRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(TaxRecord $taxRecord){
        return TaxRecordResource::collection($taxRecord->all());
    }

    public function show(TaxRecord $taxRecord){
        return $taxRecord->find($taxRecord->id);
    }

    public function store(Request $request, TaxRecord $taxRecord){

        $validation = $request->validate([
            'tax_type_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'filer_name' => 'required',
            'filer_contact' => 'required',
            'accountant_fee' => 'required',
            'comments' => 'required',
        ]);

        if(!$validation){
            return response()->json([
                'status' => 'error',
                'message' => 'Tax cream, m nbnhaopusp;isd7t6rylyuil6y7tylxcidug;hkgfplhk8gfihghligh99opoyhlokup;ukkpjhlpjhk;[jk;=piulpio0i-io--[-8owa-a-l muo8i98oooooobbbt6899yltion error'
            ]);
        }

        if($taxRecord->create($request->all())){
            return response()->json([
                'status' => 'success',
                'message' => 'Tax record created',
                'data' => $taxRecord
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tax creation error'
            ]);
        }
    }

    public function update(Request $request, TaxRecord $taxRecord){
        if($taxRecord->update($request->all())){
            return response()->json([
               'status' => 'success',
               'message' => 'Tax record updated!',
               'data' => $taxRecord
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tax record update error'
            ]);
        }
    }
    public function destroy(TaxRecord $taxRecord){
        if($taxRecord->delete()){
            return response()->json([
                'status' => 'success',
                'message' => 'Tax record deleted!',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tax record deletion error'
            ]);
        }
    }

    public function tax_record_options(TaxRecord $taxRecord){
        return response()->json($taxRecord->all(['id', 'name']));
    }
}
