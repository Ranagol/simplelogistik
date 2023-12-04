<?php

use Inertia\Inertia;
use App\Models\TmsCustomer;
use App\Models\TmsCargoOrder;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperimentController;
use App\Http\Controllers\TmsAddressController;
use App\Http\Controllers\TmsVehicleController;
use App\Http\Controllers\TmsCustomerController;
use App\Http\Controllers\TmsCargoOrderController;
use App\Http\Controllers\TmsRequirementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::resource('users', UserController::class);
    Route::resource('customers', TmsCustomerController::class);
    Route::post('/customers-batch-delete', [TmsCustomerController::class, 'batchDelete'])->name('customers.batch.delete');
    Route::resource('cargo-orders', TmsCargoOrderController::class);
    Route::resource('addresses', TmsAddressController::class);
    Route::post('/addresses-batch-delete', [TmsAddressController::class, 'batchDelete'])->name('addresses.batch.delete');
    Route::resource('experiments', ExperimentController::class);
    Route::resource('vehicles', TmsVehicleController::class);
    Route::post('/vehicles-batch-delete', [TmsVehicleController::class, 'batchDelete'])->name('vehicles.batch.delete');
    Route::resource('requirements', TmsRequirementController::class);
    Route::post('/requirements-batch-delete', [TmsRequirementController::class, 'batchDelete'])->name('requirements.batch.delete');



    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/pamyra', function () {
        return Inertia::render('Pamyra');
    })->name('pamyra');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
