<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Settings $settings){



        $settings_array = [];

        foreach($settings->all() as $setting){
            $settings_array[$setting->key] = $setting->value;
        }

        return response()->json($settings_array);
    }

    public function show(Request $request, Settings $settings){
        return response()->json($settings);
    }

    public function update(Request $request){


        foreach($request->all() as $key => $val){
            if($val != '' && $val != null){
                Settings::where('key', $key)->update(['value' => $val]);
            }
        }

        return response()->json(Settings::all());

    }
}
