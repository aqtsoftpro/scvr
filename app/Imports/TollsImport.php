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

        if(isset($row['customer']) && $row['customer'] != null){
            $customer = $row['customer'];
            $customerRecord = Customer::where('first_name', 'like', '%' . $row['customer'] . '%')->first();

            if($customerRecord){
                $customer = $customerRecord->id;
            } else {
                $customer = Customer::create([
                    'first_name' => $row['customer']
                ])->id;
            }
        }

        return $row;

        return new Toll([
            'toll_number' => $row['toll_number'],
            'date' => Carbon::parse($row['date'])->format('d-m-Y'),
            'reg_plate_number' => $row['reg_plate_number'],
            'customer_id' => $customer,
            'payment_status' => $row['payment_status']
        ]);
    }
}
