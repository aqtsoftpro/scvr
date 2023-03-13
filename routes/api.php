<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VanOutController;
use App\Http\Controllers\TaxTypeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\RepairJobController;
use App\Http\Controllers\TaxRecordController;
use App\Http\Controllers\VanReturnController;
use Illuminate\Validation\InsuranceContoller;
use App\Http\Controllers\PolicyTypeController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\GeneralServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

Route::resource('users', UserController::class);
Route::resource('accessory', AccessoryController::class);
Route::resource('general_service', GeneralServiceController::class);
Route::resource('insurance', InsuranceContoller::class);
Route::resource('location', LocationController::class);
Route::resource('maintenance', MaintenanceController::class);
Route::resource('policy_type', PolicyTypeController::class);
Route::resource('repair_job', RepairJobController::class);
Route::resource('service_type', ServiceTypeController::class);
Route::resource('tax_record', TaxRecordController::class);
Route::resource('tax_type', TaxTypeController::class);
Route::resource('vanout', VanOutController::class);
Route::resource('van_return', VanReturnController::class);
Route::resource('vehicle_type', VehicleTypeController::class);
Route::resource('vehicle', VehicleController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
