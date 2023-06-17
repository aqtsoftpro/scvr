<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Customer $customer){
        return response()->json($customer->all());
    }

    public function show(Customer $customer){
        return response()->json($customer);
    }

    public function store(Request $request, Customer $customer){

        $validation = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:customers,email',
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        if($newCustomer = $customer->create($request->all())){
            return response()->json([
                'status' => 'success',
                'message' => 'Customer created!',
                'data' => $newCustomer
            ]);
        }
    }

    public function update(Request $request, Customer $customer){
        if($customer->update($request->all())){
            return response()->json([
                'status' => 'success',
                'message' => 'Customer updated!',
                'data' => $customer
            ]);
        }
    }

    public function destroy(Customer $customer){
        $customer->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted'
        ]);
    }

    public function customer_options(Customer $customer){
        return response()->json($customer->all(['id', 'first_name']));
    }
}
