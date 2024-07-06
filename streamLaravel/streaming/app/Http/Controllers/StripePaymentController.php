<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use App\Models\Payment;


class StripePaymentController extends Controller
{
    public function stripe(): View
    {
        return view('stripe');
    }

    public function stripeCheckout(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $redirectUrl = route('stripe.checkout.success').'?session_id={CHECKOUT_SESSION_ID}';
        $response = $stripe->checkout->sessions->create([
            'success_url' => $redirectUrl,
            'customer_email' => [],
            'payment_method_types' => [
            //  'link',
            'card'
        ],
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $request->product,
                        ],
                        'unit_amount' => 100 * $request->price,
                        'currency' => 'USD',
                    ],
                    'quantity' => 1
                ],
            ],

            'mode' => 'payment',
            'allow_promotion_codes' => true,
        ]);

        return redirect($response['url']);
    }

    // public function stripeCheckoutSuccess(Request $request)
    // {
    //     $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    //     $response = $stripe->checkout->sessions->retrieve($request->session_id);
    //     // dd($response);
    //     return redirect()->route('stripe.index')
    //                         ->with('success','Payment successful.');
    // }
    public function stripeCheckoutSuccess(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = $stripe->checkout->sessions->retrieve($request->session_id, ['expand' => ['customer']]);
        $customerEmail = $response->customer_details->email;
        $customerName = $response->customer_details->name;
        // $product = $response->line_items->data[0]->description; 
        $price = $response->amount_total;
        $randomText = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $emailDetails = [
            'name' => $customerName,
            'product' => 'streaming',
            'price' => $price,
            'subject' => 'Payment Successful',
            'email_id' => $customerEmail,
            'payment_type' => 'stripe' ,
            'random_text' => $randomText,
        ];
        Payment::create($emailDetails);
        // dd(Payment::create($emailDetails));
        send_payment($customerEmail, 'Payment Successful', $emailDetails);
        return redirect()->route('stripe.index')->with('success', 'Payment successful.');
    }

}
