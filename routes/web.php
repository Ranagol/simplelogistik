<?php

use App\Http\Controllers\TmsVehicleController;
use Inertia\Inertia;
use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TmsGearController;
use App\Http\Controllers\TmsOrderController;
use App\Http\Controllers\TmsAddressController;
use App\Http\Controllers\TmsCustomerController;
use App\Http\Controllers\TmsForwarderController;
use App\Http\Controllers\System\SystemSettingsController;

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
        return redirect('/dashboard');
        // return Inertia::render('Dashboard', [
        //     'canLogin' => Route::has('login'),
        //     'canRegister' => Route::has('register'),
        //     'laravelVersion' => Application::VERSION,
        //     'phpVersion' => PHP_VERSION,
        // ]);
    });

    Route::resource('users', UserController::class);
    Route::resource('customers', TmsCustomerController::class);
    //This is the route for adding comments to a customer
    Route::patch('/customers/{customer}/comments/create', [TmsCustomerController::class, 'addComment'])->name('customers.comments.create');
    Route::resource('orders', TmsOrderController::class);
    Route::resource('addresses', TmsAddressController::class);
    Route::resource('forwarders', TmsForwarderController::class);
    Route::resource('vehicles', TmsVehicleController::class);
    Route::middleware([])->group(function(){
        Route::get('/system/languages', [SystemSettingsController::class,'listLanguages'])->name('languages.index'); // List all Languages
        Route::get('/system/language/{id}', [SystemSettingsController::class,'showLanguages'])->name('languages.show'); // Show Details about Language
        Route::get('/system/language/{id}/edit', [SystemSettingsController::class,'editLanguage'])->name('languages.edit'); // Edit Language
        Route::get('/system/language/{id}/translations', [SystemSettingsController::class,'listLanguages'])->name('translation.index'); // List all Translations for a Language
        Route::get('/system/language/{id}/translations/{tid}', [SystemSettingsController::class,'listLanguages'])->name('translation.show'); // Show Details about Translation
        Route::get('/system/language/{id}/translations/{tid}/edit', [SystemSettingsController::class,'listLanguages'])->name('translation.edit'); // Edit Translation 
        Route::post('/system/languages/create', [SystemSettingsController::class,'storeLanguages'])->name('languages.store'); // create new Language
    });



    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard.index');

    Route::get('/pamyra', function () {
        return Inertia::render('Pamyra');
    })->name('pamyra');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.create');
});

require __DIR__.'/auth.php';
