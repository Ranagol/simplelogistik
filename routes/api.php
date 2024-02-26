<?php

use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Models\TmsForwarder;
use App\Models\TmsPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
