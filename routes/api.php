<?php

use App\Models\Toll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TollController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\VanOutController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TaxTypeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\AccessoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\RepairJobController;
use App\Http\Controllers\TaxRecordController;
use App\Http\Controllers\VanReturnController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PolicyTypeController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleStatusController;
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

Route::get('search', 'App\Http\Controllers\SearchController@search');


Route::post('logout/{user}', function(User $user){
    return response()->json($user->tokens);
    $user->tokens()->delete();
    return response()->json([
        'message' => 'Logged out'
    ]);
});

Route::post('/login/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }

    return response()->json([
        'status' => 'success',
        'token' => $user->createToken($request->device_name)->plainTextToken,
    ]);
});

Route::get('dashboard_data', 'App\Http\Controllers\DashboardController@index');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('users', UserController::class);
Route::get('customer_options', 'App\Http\Controllers\UserController@customer_options');
Route::resource('accessory', AccessoryController::class);
Route::get('accessory_options', 'App\Http\Controllers\AccessoryController@accessory_options');
Route::resource('general_service', GeneralServiceController::class);
Route::get('general_service_options', 'App\Http\Controllers\GeneralServiceController@general_service_options');
Route::resource('insurance', InsuranceController::class);
Route::get('insurance_options', 'App\Http\Controllers\InsuranceController@insurance_options');
Route::resource('location', LocationController::class);
Route::get('location_options', 'App\Http\Controllers\LocationController@location_options');
Route::resource('maintenance', MaintenanceController::class);
Route::get('maintenance_options', 'App\Http\Controllers\MaintenanceController@maintenance_options');
Route::resource('policy_type', PolicyTypeController::class);
Route::get('policy_type_options', 'App\Http\Controllers\PolicyTypeController@policy_type_options');
Route::resource('repair_job', RepairJobController::class);
Route::get('repair_job_options', 'App\Http\Controllers\RepairJobController@repair_job_options');
Route::resource('service_type', ServiceTypeController::class);
Route::get('service_type_options', 'App\Http\Controllers\ServiceTypeController@service_type_options');
Route::resource('tax_record', TaxRecordController::class);
Route::get('tax_record_options', 'App\Http\Controllers\TaxRecordController@tax_record_options');
Route::resource('tax_type', TaxTypeController::class);
Route::get('tax_type_options', 'App\Http\Controllers\TaxTypeController@tax_type_options');
Route::resource('vanout', VanOutController::class);
Route::get('van_out_options', 'App\Http\Controllers\VanOutController@van_out_options');
Route::get('returned_van_out_options', 'App\Http\Controllers\VanOutController@returned_van_out_options');
Route::resource('van_return', VanReturnController::class);
Route::get('van_return_options', 'App\Http\Controllers\VanReturnController@van_return_options');
Route::resource('vehicle_type', VehicleTypeController::class);
Route::get('vehicle_type_options', 'App\Http\Controllers\VehicleTypeController@vehicle_type_options');
Route::resource('vehicle', VehicleController::class);
Route::put('update_vehicle_status/{vehicle}', 'App\Http\Controllers\VehicleController@updateStatus');
Route::get('vehicle_options', 'App\Http\Controllers\VehicleController@vehicle_options');
Route::get('available_vehicles_options/{vehicle}', 'App\Http\Controllers\VehicleController@get_available_vehicles');
Route::resource('mechanic', MechanicController::class);
Route::get('mechanic_options', 'App\Http\Controllers\MechanicController@mechanic_options');
Route::resource('role', RoleController::class);
Route::get('role_options', 'App\Http\Controllers\RoleController@role_options');
Route::resource('permission', PermissionController::class);
Route::get('permission_options', 'App\Http\Controllers\PermissionController@permission_options');
Route::resource('vehicle_status', VehicleStatusController::class);
Route::get('vehicle_status_options', 'App\Http\Controllers\VehicleStatusController@vehicle_status_options');
Route::resource('customer', CustomerController::class);
Route::get('customer_options', 'App\Http\Controllers\CustomerController@customer_options');
Route::resource('toll', TollController::class);
Route::get('toll_options', 'App\Http\Controllers\TollController@toll_options');

Route::get('reports/earnings', 'App\Http\Controllers\ReportsController@earnings');
Route::get('reports/maintenance_cost', 'App\Http\Controllers\ReportsController@maintenance_cost');
Route::get('reports/maintenance_list', 'App\Http\Controllers\ReportsController@maintenance_list');
Route::get('reports/rental_history', 'App\Http\Controllers\ReportsController@rental_history');
Route::get('reports/profit_loss', 'App\Http\Controllers\ReportsController@profit_loss');

Route::post('password-reset', 'App\Http\Controllers\Auth\PasswordResetLinkController@store');
Route::post('invite-customer', 'App\Http\Controllers\CustomerController@invite');
Route::post('whatsapp-invite-customer', 'App\Http\Controllers\CustomerController@whatsapp_invite');
Route::post('register-customer', 'App\Http\Controllers\CustomerController@store');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user_id = $request->user()->id;
    $user = User::where('id', $user_id)->with('roles')->first();
    return $user;
});
