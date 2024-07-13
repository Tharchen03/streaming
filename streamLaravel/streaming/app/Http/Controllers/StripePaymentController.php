<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Payment;
use Illuminate\View\View;
use App\Models\UserSession;
use Illuminate\Http\Request;
use App\Services\VdoCipherService;
use Illuminate\Support\Facades\Log;


class StripePaymentController extends Controller
{
    protected $vdoCipher;

    public function __construct(VdoCipherService $vdoCipher)
    {
        $this->vdoCipher = $vdoCipher;
    }

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
             'link',
            'card',
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
        return redirect()->route('verify')->with('success', 'Payment successful.');
        // return view('verify-code-stripe', ['customerEmail' => $customerEmail]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);
        $payment = Payment::where('random_text', $request->code)->first();
        if ($payment) {
            UserSession::create([
                'payment_id' => $payment->id,
                'session_key' => 'verified',
                'ip_address' => $request->ip(),
                'session_value' => 'true',
            ]);

            session([
                'payment_id' => $payment->id,
                'verified' => true,
                'availability_date' => '2024-01-01',
            ]);

            // Fetch video details from VdoCipher
            $videoId = 'f2c1b44e9ed24d08972bcc8cefea38fb'; // Replace with your actual video ID
            $videoDetails = $this->vdoCipher->getVideoById($videoId);
            // dd($videoDetails);
            return view('video', [
                'otp' => $videoDetails['otp'],
                'playbackInfo' => $videoDetails['playbackInfo'],
            ]);        } else {
            return redirect()->back()->withErrors(['code' => 'Verification code is incorrect.']);
        }
    }

    // public function verify(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'required|string',
    //     ]);

    //     $payment = Payment::where('random_text', $request->code)->first();
    //     if ($payment) {
    //         // Create user session for verification tracking
    //         UserSession::create([
    //             'payment_id' => $payment->id,
    //             'session_key' => 'verified',
    //             'ip_address' => $request->ip(),
    //             'session_value' => 'true',
    //         ]);

    //         // Store payment and verification status in session for application use
    //         session([
    //             'payment_id' => $payment->id,
    //             'verified' => true,
    //         ]);

    //         // Fetch video details from VdoCipher
    //         $videoId = 'f2c1b44e9ed24d08972bcc8cefea38fb'; // Replace with your actual video ID

    //         // Example of configuring playback policy via VdoCipher API
    //         $policyResponse = $this->vdoCipher->createPlaybackPolicy($videoId, [
    //             'start' => '2024-07-13T12:00:00Z', // Start time in ISO 8601 format (UTC)
    //             'end' => '2024-07-13T15:00:00Z', // End time in ISO 8601 format (UTC)
    //         ]);
    //         dd($policyResponse);

    //         // Logging API response for debugging
    //         Log::debug('Policy API Response: ' . print_r($policyResponse, true));

    //         // Check if policy creation was successful
    //         if ($policyResponse && isset($policyResponse['success']) && $policyResponse['success']) {
    //             // Generate OTP with the policy ID
    //             $otpResponse = $this->vdoCipher->getVideoById($videoId, [
    //                 'policy' => $policyResponse['policyId'],
    //             ]);

    //             return view('video', [
    //                 'otp' => $otpResponse['otp'],
    //                 'playbackInfo' => $otpResponse['playbackInfo'],
    //             ]);
    //         } else {
    //             // Handle policy creation failure or invalid response
    //             $errorMessage = isset($policyResponse['message']) ? $policyResponse['message'] : 'Unknown error';
    //             Log::error('Failed to create playback policy: ' . $errorMessage);
    //             return redirect()->back()->withErrors(['error' => 'Failed to create playback policy.']);
    //         }
    //     } else {
    //         return redirect()->back()->withErrors(['code' => 'Verification code is incorrect.']);
    //     }
    // }

}
