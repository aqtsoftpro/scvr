<?php

namespace App\Http\Controllers;

use App\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Maintenance $maintenance){
        return $maintenance->all();
    }

    public function store(Request $request, Maintenance $maintenance){
        $maintenance->create($request->all());
        return $maintenance->all();
    }

    public function update(Request $request, Maintenance $maintenance){
        $maintenance->update($request->all());
        return $maintenance->all();
    }

    public function destroy(Maintenance $maintenance){
        $maintenance->delete();
        return $maintenance->all();
    }

}
