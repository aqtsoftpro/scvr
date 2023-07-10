<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Channels\WhatsAppChannel;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customer as CustomerMail;
use App\Http\Resources\CustomerResource;
use App\Channels\Messages\WhatsAppMessage;
use App\Http\Resources\CustomerOptionResource;

class CustomerController extends Controller
{
    public function index(Customer $customer){
        return response()->json(CustomerResource::collection($customer->orderBy('id', 'desc')->get()));
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
            'address' => 'required',
            'driver_licence_number' => 'required',
            'driver_licence_front_picture' => 'required',
            'driver_licence_back_picture' => 'required',
            'driver_licence_expiry' => 'required',
            'secondary_id_number' => 'required',
            'secondary_id_front_picture' => 'required',
            'secondary_id_back_picture' => 'required',
            'secondary_id_expiry' => 'required',
            'nationality' => 'required',
        ]);


        //driver licence front picture
        if($request->hasFile('driver_licence_front_picture')){
            $image = $request->file('driver_licence_front_picture');
            $filename = 'dlf-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $dlfImage = url('/images/customer/' . $filename);
        }
        // driver licence back picture
        if($request->hasFile('driver_licence_back_picture')){
            $image = $request->file('driver_licence_back_picture');
            $filename = 'dlb-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $dlbImage = url('/images/customer/' . $filename);
        }

        //secondary id front picture
        if($request->hasFile('secondary_id_front_picture')){
            $image = $request->file('secondary_id_front_picture');
            $filename = 'sidf-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $sidfImage = url('/images/customer/' . $filename);
        }

        //secondary id back picture
        if($request->hasFile('secondary_id_back_picture')){
            $image = $request->file('secondary_id_back_picture');
            $filename = 'sidb-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $sidbImage = url('/images/customer/' . $filename);
        }

        if($newCustomer = $customer->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'driver_licence_number' => $request->driver_licence_number,
            'driver_licence_front_picture' => $dlfImage,
            'driver_licence_back_picture' => $dlbImage,
            'driver_licence_expiry' => $request->driver_licence_expiry,
            'nationality' => $request->nationality,
            'secondary_id_number' => $request->secondary_id_number,
            'secondary_id_front_picture' => $sidfImage,
            'secondary_id_back_picture' => $sidbImage,
            'secondary_id_expiry' => $request->secondary_id_expiry
        ])){
            return response()->json([
                'status' => 'success',
                'message' => 'Customer created!',
                'data' => $newCustomer
            ]);
        }
    }

    public function update(Request $request, Customer $customer){

        $dlfImage = $request->driver_licence_front_picture;
        $dlbImage = $request->driver_licence_back_picture;
        $sidfImage = $request->secondary_id_front_picture;
        $sidbImage = $request->secondary_id_back_picture;

        if($request->hasFile('driver_licence_front_picture')){
            $image = $request->file('driver_licence_front_picture');
            $filename = 'dlf-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $dlfImage = url('/images/customer/' . $filename);
        }
        // driver licence back picture
        if($request->hasFile('driver_licence_back_picture')){
            $image = $request->file('driver_licence_back_picture');
            $filename = 'dlb-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $dlbImage = url('/images/customer/' . $filename);
        }

        //secondary id front picture
        if($request->hasFile('secondary_id_front_picture')){
            $image = $request->file('secondary_id_front_picture');
            $filename = 'sidf-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $sidfImage = url('/images/customer/' . $filename);
        }

        //secondary id back picture
        if($request->hasFile('secondary_id_back_picture')){
            $image = $request->file('secondary_id_back_picture');
            $filename = 'sidb-' . $request->email . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $filename);
            $sidbImage = url('/images/customer/' . $filename);
        }

        if($customer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'driver_licence_number' => $request->driver_licence_number,
            'driver_licence_front_picture' => $dlfImage,
            'driver_licence_back_picture' => $dlbImage,
            'driver_licence_expiry' => $request->driver_licence_expiry,
            'nationality' => $request->nationality,
            'secondary_id_number' => $request->secondary_id_number,
            'secondary_id_front_picture' => $sidfImage,
            'secondary_id_back_picture' => $sidbImage,
            'secondary_id_expiry' => $request->secondary_id_expiry
        ])){
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

        return response()->json(CustomerOptionResource::collection($customer->all()));
    }

    public function invite(Request $request){
        $validator = $request->validate([
            'email' => 'required|email|unique:customers'
        ]);

        $email = $request->email;

        if(Mail::to($email)->send(new CustomerMail($email))){
            return response()->json([
                ['status' => 'success', 'message' => 'The invication email has been sent']
            ]);
        }
    }


    public function whatsapp_invite(Request $request){

        $sid = env("TWILIO_AUTH_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $from = env("TWILIO_WHATSAPP_FROM");
        $phoneNumber = $request->phone_number;

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
          ->create("whatsapp:" . $phoneNumber, // to
            array(
              "from" => "whatsapp:" . $from,
              "body" => "please click on the link to register yourself on 'Super Cheap Van Rental ':" .  "scvrapp.aqtdemos.com/user/register"
            )
        );

        return response()->json([
            'status' => 'success',
            'sid' => $message->sid,
            'message' => 'Your whatsapp client invitation has been sent to number ' . $phoneNumber
        ]);
    }
}
