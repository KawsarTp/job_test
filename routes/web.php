<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PayPalPaymentController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AppointmentController::class,'index'])->name('home');
Route::post('appointment', [AppointmentController::class,'appointment'])->name('appointment');
Route::get('find/doctor', [AppointmentController::class,'findDoctor'])->name('find');
Route::get('find/schedule', [AppointmentController::class,'findSchedule'])->name('schedule');
Route::get('time/schedule', [AppointmentController::class,'findTimeSchedule'])->name('time');
Route::get('delete', [AppointmentController::class,'delete'])->name('delete');


Route::post('make/payment', [AppointmentController::class,'pay'])->name('make.payment');
Route::post('paypal', [PayPalPaymentController::class,'ipn'])->name('paypal');

Route::get('payment/success',[AppointmentController::class, ''])->name('payment.success');


