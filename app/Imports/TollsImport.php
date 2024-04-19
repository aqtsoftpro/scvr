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
        $vehicle = Vehicle::where('reg_plate_number', $row['lpn'])->first();
        if ($vehicle) { 

            if (is_numeric($row['start_date'])) {
                $carbonStart = ($row['start_date'] - 25569) * 86400;
                $start = date('m-d-Y H:i', $carbonStart); // Changed date format to Y-m-d
                // $vanOut = VanOut::where('vehicle_id', $vehicle->id)
                // ->where(function ($query) use ($row) {
                //     $query->whereDate('van_out_date', '<=', $carbonStart)
                //         ->orWhereNull('van_out_date'); // To handle cases where van_out_date is null
                // })
                // ->orderBy('created_at', 'desc')->first();
            }
            else {
                $carbonStart = \DateTime::createFromFormat('d/m/Y H:i', $row['start_date']);
                // $start = $carbonStart->format('m/d/Y'); // Changed date format to Y-m-d
            }

            if ($carbonStart) {
                $vanOut = VanOut::where('vehicle_id', $vehicle->id)
                // ->where(function ($query) use ($row) {
                //     $query->where('van_out_date', '<=', \DateTime::createFromFormat('d/m/Y H:i', $row['start_date'])->format('Y-m-d H:i:s'))
                //         ->orWhereNull('van_out_date'); // To handle cases where van_out_date is null
                // })
                ->orderBy('created_at', 'desc')->first();
                if ($vanOut) {

                    if (is_numeric($row['end_date'])) {
                        $carbonEnd = ($row['end_date'] - 25569) * 86400;
                        // $end = date('Y-m-d H:i', $end); // Changed date format to Y-m-d
                    } else {
                        $carbonEnd = Carbon::createFromFormat('d/m/Y H:i', $row['end_date']);
                        // $end = $carbonEnd->format('m/d/Y'); // Changed date format to Y-m-d
                    }
                    $customer = $vanOut->customer_id;
                    $cost = str_replace('$', '', $row['trip_cost']);
                    $trip_cost = (float)$cost;
                    $toll = Toll::where([
                            'date' => $carbonStart,
                            'due_date' => $carbonEnd,
                            'trip_cost' => $trip_cost,
                            'reg_plate_number' => $row['lpn'],
                            ])->first();
                    if (!$toll) {
                        return new Toll([
                            'toll_number' => $row['details'],
                            'date' => $carbonStart,
                            'reg_plate_number' => $row['lpn'],
                            'customer_id' => $customer,
                            'payment_status' => 'unpaid',
                            'due_date' => $carbonEnd,
                            'details' => $row['details'],
                            'trip_cost' => $trip_cost,
                        ]);
                    }
                }
            }
        }
    }
}
