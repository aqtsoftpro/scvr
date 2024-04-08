<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Toll;
use App\{VanReturn, VanOut, Vehicle};
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

    protected $columnMapping = [
        // 'LPN/Tag number' => 'lpn_tag_number',
        'LPN' => 'lpn',
    ];

    public function model(array $row)
    {
        $customer = null;

        // return $row;

        $vehicle = Vehicle::where('reg_plate_number', $row['lpn'])->first();

        if ($vehicle) {

                // $vanOut = VanOut::whereDate('van_out_date', '<=', Carbon::parse($row['start_date']))
                //     ->where('vehicle_id', $vehicle->id)
                //     ->orderBy('created_at', 'desc')
                //     ->first();
                // if ($vanOut) {
                //     $customer = $vanOut->customer_id;
                // }

            $vanOut = VanOut::where('vehicle_id', $vehicle->id)
                ->where(function ($query) use ($row) {
                    $query->where('van_out_date', '<=', Carbon::parse($row['start_date'])->toDateString())
                        ->orWhereNull('van_out_date'); // To handle cases where van_out_date is null
                })
                ->orderBy('created_at', 'desc')
                ->first();

            if ($vanOut) {
                $customer = $vanOut->customer_id;
            }
        }

        if ($customer) {
            return new Toll([
                'toll_number' => $row['details'],
                'date' => Carbon::parse($row['start_date']),
                'reg_plate_number' => $row['lpn'],
                'customer_id' => $customer,
                'payment_status' => 'unpaid',
                'due_date' => Carbon::parse($row['end_date']),
                'details' => $row['details'],
                'trip_cost' => $row['trip_cost']
            ]);
        }
    }
}
