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

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/rma', function () {
    return view('livewire.payment')
        ->withComponent('rma-payment-component')
        ->withTitle('RMA Payment');
})->name('rma-payment');

Route::get('/stripe', function () {
    return view('livewire.stripe-payment')
        ->withComponent('stripe-payment-component')
        ->withTitle('Stripe Payment');
})->name('stripe-payment');

