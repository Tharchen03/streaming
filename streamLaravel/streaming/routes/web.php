<?php

use Carbon\Carbon;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\DB;

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
    Route::post('/payment/verified',  'verify')->name('stripe.verify');
});


Route::get('/verify', function () {
    return view('verify-code-stripe');
})->name('verify');

// Route::get('/video', function () {
//     return view('video');
// })->name('video')->middleware(['verify.access', 'verify.date']);

Route::get('/video', function () {
    $otp = session('otp');
    $playbackInfo = session('playbackInfo');

    return view('video', [
        'otp' => $otp,
        'playbackInfo' => $playbackInfo,
    ]);
})->name('video')->middleware(['verify.access', 'verify.date']);


Route::get('/unauthorized', function () {
    return view('middleware.unauthorized');
})->name('unauthorized');

Route::get('/waiting', function () {
    $availabilityStart = session('availability_start');
    $availabilityEnd = session('availability_end');

    if (!$availabilityStart || !$availabilityEnd) {
        return redirect()->route('unauthorized');
    }

    $availabilityStart = Carbon::parse($availabilityStart);
    $availabilityEnd = Carbon::parse($availabilityEnd);
    $currentDate = Carbon::now('Asia/Thimphu');

    if ($currentDate->lt($availabilityStart)) {
        return view('middleware.waiting', [
            'availabilityStart' => $availabilityStart,
            'availabilityEnd' => $availabilityEnd,
        ]);
    } elseif ($currentDate->between($availabilityStart, $availabilityEnd)) {
        return redirect()->route('video');
    } else {
        // return redirect()->route('expired');
        return view('middleware.expired');

    }
})->name('waiting');

Route::get('/expired', function () {
    return view('middleware.expired');
})->name('expired');


Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is working!';
    } catch (\Exception $e) {
        return 'Could not connect to the database. Error: ' . $e->getMessage();
    }
});

// Route::middleware(['restore.session'])->group(function () {
//     Route::get('/video', [StripePaymentController::class, 'show']);
//     // Add other routes that require session restoration
// });


