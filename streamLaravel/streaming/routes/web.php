<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('index');
// })->name('home');
Route::get('/otp', function () {
    return view('otp');
})->name('otp');

Route::get('/', function () {
    return view('index')
        ->withComponent('index')
        ->withTitle('Screaning');
})->name('/');

Route::get('/rma', function () {
    return view('livewire.payment')
        ->withComponent('rma-payment-component')
        ->withTitle('RMA Payment');
})->name('rma-payment');

Route::get('/OTP', function () {
    return view('livewire.rma.OTP')
        ->withComponent('OTP')
        ->withTitle('RMA Payment');
})->name('OTP');
