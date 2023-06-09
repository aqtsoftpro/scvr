<?php

namespace App\Http\Controllers;

use App\VanOut;
use Carbon\Carbon;
use App\Maintenance;
use App\VanReturn;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function earnings(){

        $bookings = VanOut::all();
        $total = 0;
        $earnings = [];

        foreach($bookings as $key => $booking){
            $earnings['earnings'][$key]['vehicle'] = $booking->vehicle->make . '-' . $booking->vehicle->model . ' (' . $booking->vehicle->reg_plate_number . ')';
            $earnings['earnings'][$key]['customer'] = $booking->customer->first_name . ' ' . $booking->customer->last_name;
            $earnings['earnings'][$key]['date'] = Carbon::parse($booking->created_at)->format('d M, Y');
            $earnings['earnings'][$key]['amount'] = $booking->rental_amount;
            $total += $booking->rental_amount;
        }
        $earnings['total'] = $total;

        return response()->json($earnings);
    }

    public function maintenance_cost(){

        $maintenance = Maintenance::all();
        $total = 0;
        $maintenance_entries = [];

        foreach($maintenance as $key => $entry){
            $maintenance_entries['maintenance'][$key]['vehicle'] = $entry->vehicle->make . '-' . $entry->vehicle->model . ' (' . $entry->vehicle->reg_plate_number . ')';
            $maintenance_entries['maintenance'][$key]['service'] = $entry->service_type->name;
            $maintenance_entries['maintenance'][$key]['date'] = Carbon::parse($entry->date)->format('d M, Y');
            $maintenance_entries['maintenance'][$key]['cost'] = $entry->cost;
            $total += $entry->cost;
        }

        $maintenance_entries['total'] = $total;

        return response()->json($maintenance_entries);

    }

    public function maintenance_list(){

        $maintenance = Maintenance::all();
        $maintenance_list = [];

        foreach($maintenance as $key => $entry){
            $maintenance_list[$key]['vehicle'] = $entry->vehicle->make . '-' . $entry->vehicle->model . ' (' . $entry->vehicle->reg_plate_number . ')';
            $maintenance_list[$key]['mileage'] = $entry->mileage;
            $maintenance_list[$key]['date'] = Carbon::parse($entry->date)->format('d M, Y');
            $maintenance_list[$key]['service_type'] = $entry->service_type->name;
            $maintenance_list[$key]['part_replaced'] = $entry->part_replaced;
            $maintenance_list[$key]['comments'] = $entry->comments;
            $maintenance_list[$key]['cost'] = $entry->cost;
        }

        return response()->json($maintenance_list);
    }

    public function rental_history(){

        $vanout = VanOut::with('customer', 'van_return')->get();

        $rental_history = [];

        foreach($vanout as $key => $record){
            $rental_history[$key]['rented_out'] = Carbon::parse($record->created_at)->format('d M, Y');
            $rental_history[$key]['vehicle'] = $record->vehicle->make . '-' . $record->vehicle->model . ' (' . $record->vehicle->reg_plate_number . ')';
            $rental_history[$key]['customer'] = $record->customer->first_name . ' ' . $record->customer->last_name;
            $rental_history[$key]['returned'] = ($record->van_return) ? Carbon::parse($record->van_return->return_date)->format('d M, Y') : 'Not returned yet';
        }

        return response()->json($rental_history);

    }
}
