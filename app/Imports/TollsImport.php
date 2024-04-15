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
                $start = ($row['start_date'] - 25569) * 86400;
                $start = date('d/m/Y', $start);
            } else {
                $carbonStart = Carbon::createFromFormat('d/m/Y H:i:s', $row['start_date']);
                $start = $carbonStart->format('m/d/Y');
            }
    
            if (is_numeric($row['end_date'])) {
                $end = ($row['end_date'] - 25569) * 86400;
                $end = date('d/m/Y', $end);
            } else {
                $carbonEnd = Carbon::createFromFormat('d/m/Y H:i:s', $row['end_date']);
                $end = $carbonEnd->format('m/d/Y');
            }

            $vanOut = VanOut::where('vehicle_id', $vehicle->id)
                ->where(function ($query) use ($row) {
                    $query->where('van_out_date', '<=', Carbon::parse($row['start_date'])->toDateString())
                        ->orWhereNull('van_out_date'); // To handle cases where van_out_date is null
                })
                ->orderBy('created_at', 'desc')
                ->first();

            if ($vanOut) {
                $customer = $vanOut->customer_id;
                $cost = str_replace('$', '', $row['trip_cost']);
                $trip_cost = (float)$cost;
                $toll = Toll::where([
                    'customer_id' => $customer, 
                    'reg_plate_number'=> $row['lpn'],
                    'date' => $start,
                    'due_date' => $end
                    ])->first();
                
                if ($customer && !$toll) {
                    return new Toll([
                        'toll_number' => $row['details'],
                        'date' => $start,
                        'reg_plate_number' => $row['lpn'],
                        'customer_id' => $customer,
                        'payment_status' => 'unpaid',
                        'due_date' => $end,
                        'details' => $row['details'],
                        'trip_cost' => $trip_cost
                    ]);
                }
            }
        }
    }
}
