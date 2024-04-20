<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Toll;
use App\{VanReturn, VanOut, Vehicle};
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class TollsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }


    // function convertSerialDate($date,$hr)	{
    //     $datestr = ($date - 25569) * 86400;
    //     $timestr = ($hr - 25569) * 86400;
    //     $n1 =  date("Y-m-d",$datestr);
    //     $n2 =  date("H:i",$timestr);
    //     return $n1.' '.$n2;
    // }
    
    // if(strpos($row['enddate'],".") > 0){
    //    $v = explode('.', $row['enddate']);
    //    $carbonDate = convertSerialDate($v[0], $v[1]);
    // }else{
    //     $carbonDate = date_create($row['enddate']);
    //     $carbonDate = date_format('Y-m-d H:i', $carbonDate);	
    // }
    

    public function model(array $row)
    {
        $customer = null;
        $vehicle = Vehicle::where('reg_plate_number', $row['LPN/Tag number'])->first();
        if ($vehicle) {

            if(strpos($row['Start Date'],".") > 0){
                $v = explode('.', $row['Start Date']);
                $dateTime = $this->convertSerialDate($v[0], $v[1]);
                $dateTime = \DateTime::createFromFormat('Y-m-d H:i', $dateTime);
                $day = $dateTime->format('d');
                $month = $dateTime->format('m');
                $dateTime->setDate($dateTime->format('Y'), $day, $month);
                // Format back to the desired format
                $startDate = $dateTime->format('Y-m-d H:i');

                $startDate = \DateTime::createFromFormat('Y-m-d H:i', $startDate);

            }else{
                $startDate = \DateTime::createFromFormat('d/m/Y H:i', $row['Start Date']);
            }

            if(strpos($row['End Date'],".") > 0){
                $v = explode('.', $row['End Date']);
                $endTime = $this->convertSerialDate($v[0], $v[1]);
                $endTime = \DateTime::createFromFormat('Y-m-d H:i', $endTime);
                $day = $endTime->format('d');
                $month = $endTime->format('m');
                $endTime->setDate($endTime->format('Y'), $day, $month);
                // Format back to the desired format
                $endDate = $endTime->format('Y-m-d H:i');
                $endDate = \DateTime::createFromFormat('Y-m-d H:i', $endDate);
            }else{
                $endDate = \DateTime::createFromFormat('d/m/Y H:i', $row['End Date']);
            }

            $vanOut = VanOut::where('vehicle_id', $vehicle->id)
            // ->where(function ($query) use ($startDate) {
            //     $query->where('van_out_date', '<=', $startDate)
            //         ->orWhereNull('van_out_date'); // To handle cases where van_out_date is null
            // })
            ->orderBy('created_at', 'desc')->first();
            if ($vanOut) {
                $customer = $vanOut->customer_id;
                return new Toll([
                    'toll_number' => $row['Details'],
                    'date' => $startDate ?? 'No Date',
                    'reg_plate_number' => $row['LPN/Tag number'],
                    'customer_id' => $customer,
                    'payment_status' => 'unpaid',
                    'due_date' => $endDate,
                    'details' => $row['Details'],
                    'trip_cost' => 20,
                ]);
            }
        }
    }

    public function convertSerialDate($date,$hr)
    {
        $datestr = ($date - 25569) * 86400;
        $timestr = ($hr - 25569) * 86400;
        $n1 =  date("Y-m-d",$datestr);
        $n2 =  date("H:i",$timestr);
        return $n1.' '.$n2;
    }
}
