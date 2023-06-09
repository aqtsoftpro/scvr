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
        $newCustomer = $customer->create($request->all());
        return response()->json($newCustomer);
    }

    public function update(Request $request, Customer $customer){
        $customer->update($request->all());
        return response()->json($customer);
    }

    public function destroy(Customer $customer){
        $customer->delete();
        return response()->json([
            'message' => 'Customer deleted'
        ]);
    }

    public function customer_options(Customer $customer){
        return response()->json($customer->all(['id', 'first_name']));
    }
}
