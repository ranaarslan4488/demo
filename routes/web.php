<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [App\Http\Controllers\DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{doctor}', [App\Http\Controllers\DoctorController::class, 'show'])->name('doctors.show');

Route::post('/appointments/{doctor}', [App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/payment/{appointment_id}', [App\Http\Controllers\PaymentController::class, 'paymentPage'])->name('payment.page');
Route::post('/process-payment/{appointment_id}', [App\Http\Controllers\PaymentController::class ,'processPayment'])->name('process.payment');
Route::get('/success', [App\Http\Controllers\PaymentController::class,'success'])->name('success');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Example for Doctor route
Route::middleware(['auth', 'role:doctor'])->group(function () {
    // Doctor routes go here
});