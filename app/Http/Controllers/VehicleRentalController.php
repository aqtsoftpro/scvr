<?php

namespace App\Http\Controllers;

use App\VanOut;
use Illuminate\Http\Request;

class VehicleRentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VanOut $vanOut)
    {
        $vanout = $vanOut->load('customer', 'vehicle', 'location');

        return response()->json($vanout);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VanOut $vanOut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VanOut $vanOut)
    {
        //
    }
}
