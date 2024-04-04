<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Toll;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TollsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $customer = null;

        if (isset($row['customer']) && $row['customer'] != null) {

            // Assuming $row['customer'] contains "John Doe"
            $fullName = $row['customer'];

            // Split the full name into an array of first and last names
            $customerNames = explode(' ', $fullName);

            // Extract first name and last name
            $firstName = $customerNames[0]; // "John"
            $lastName = isset($customerNames[1]) ? $customerNames[1] : '';

            $customerRecord = Customer::where('first_name', 'like', '%' . $firstName . '%')->where('last_name', 'like', '%' . $lastName . '%')->first();
            if ($customerRecord) {
                $customer = $customerRecord->id;
            } else {
                // Create a new customer if not found
                $newCustomer = Customer::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName
                ]);
                $customer = $newCustomer->id;
            }
        }

        if ($customer) {
            return new Toll([
                'toll_number' => $row['toll_number'],
                'date' => Carbon::parse($row['date'])->format('d-m-Y'),
                'reg_plate_number' => $row['reg_plate_number'],
                'customer_id' => $customer,
                'payment_status' => $row['payment_status']
            ]);
        }
    
    }
}
