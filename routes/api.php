<?php

use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsOrderStatus;
use App\Models\TmsParcelType;
use App\Models\TmsPartner;
use App\Models\TmsPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\directoryExists;

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

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/countries', function (Request $request){
        return TmsCountry::all();
    });
    
    Route::get('/origins', function (Request $request){
        return [
            ["id" => 1, "title" => "general.origins.pamyra"],
            ["id" => 2, "title" => "general.origins.native"]
        ];
    });

    
    Route::get('/ratings', function (Request $request){
        return [
            ["id" => 1, "title" => "general.ratings.miserable", "rating" => 1],
            ["id" => 2, "title" => "general.ratings.poor", "rating" => 2],
            ["id" => 3, "title" => "general.ratings.average", "rating" => 3],
            ["id" => 4, "title" => "general.ratings.good", "rating" => 4],
            ["id" => 5, "title" => "general.ratings.excellent", "rating" => 5]
        ];
    });
    Route::get('/packingtypes', function (Request $request){
        return TmsParcelType::where("display", "=", true)->get();
    });
    Route::get('/payment-methods', function (Request $request){
        return TmsPaymentMethod::all();
    });
    Route::get('/order-statuses', function (Request $request){
        return TmsOrderStatus::all();
    });
    Route::get('/order-status/{id}', function (Request $request, $id){
        return TmsOrderStatus::findOrFail($id);
    });
    Route::get('/customer-types', function (Request $request){
        return [
            ["id" => 1, "name" => "general.customer_types.business"],
            ["id" => 2, "name" => "general.customer_types.private"],
        ];
    });
    Route::get('/invocie-shipping-methods', function (Request $request){
        return [
            ["id" => 1, "title" => "general.invoice_shipping_method.post"],
            ["id" => 2, "title" => "general.invoice_shipping_method.email"]
        ];
    });
    
    Route::get('/invocie-dispatch', function (Request $request){
        return [
            ["id" => 1, "title" => "general.invoice_dispatch.direct"],
            ["id" => 2, "title" => "general.invoice_dispatch.collected"]
        ];
    });


    Route::get('/forwarders', function (Request $request){
        return TmsForwarder::all();
    });
    Route::get('/customers', function (Request $request){
        return TmsCustomer::all();
    });
    Route::get('/addresses', function (Request $request){
        return TmsAddress::all();
    });
    Route::get('/partners', function (Request $request){
        return TmsPartner::all();
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
