<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;

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

Route::get('/stripePayment', function () {
    return view('livewire.stripe-payment')
        ->withComponent('stripe-payment-component')
        ->withTitle('Stripe Payment');
})->name('stripe-payment');


// stripe route
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe','stripe')->name('stripe.index');
    Route::get('stripe/checkout','stripeCheckout')->name('stripe.checkout');
    Route::get('stripe/checkout/success','stripeCheckoutSuccess')->name('stripe.checkout.success');
    Route::post('/stripe/verify',  'verify')->name('stripe.verify');
});


Route::get('/verify', function () {
    return view('verify-code-stripe');
})->name('verify');


Route::get('/video', function () {
    return view('video');
})->name('video')->middleware('verify.access');

Route::get('/unauthorized', function () {
    return 'Unauthorized access';
})->name('unauthorized');

