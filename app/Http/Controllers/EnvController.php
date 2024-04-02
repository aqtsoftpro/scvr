<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class EnvController extends Controller
{
    public function setVariable(Request $request){

        $var = $request->variableName;
        $val = $request->variableValue;

        Settings::create(
            [
                'key' => $var,
                'value' => $val
            ]);

        return "$var=$val";
    }
}
