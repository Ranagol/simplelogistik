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
use App\Http\Controllers\TmsCustomerController;
use App\Http\Controllers\TmsCargoOrderController;

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

Route::inertia('/first', 'First');//this is a shorter way of returning a Vue component, without controller

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::post('/delete-customer', [TmsCustomerController::class, 'customerDelete'])->name('customers.delete');
Route::resource('users', UserController::class);
Route::resource('customers', TmsCustomerController::class);
Route::post('/customers-batch-delete', [TmsCustomerController::class, 'batchDelete'])->name('customers.batch.delete');
Route::resource('cargo-orders', TmsCargoOrderController::class);
Route::resource('addresses', TmsAddressController::class);
Route::resource('experiments', ExperimentController::class);



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pamyra', function () {
    return Inertia::render('Pamyra');
})->name('pamyra');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
