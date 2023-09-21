<?php

namespace App\Http\Controllers;

use Error;
use Stripe\Charge;
use Stripe\StripeClient;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\Payments\StripePayment;
use Illuminate\Support\Facades\Response;

class PaymentsController extends Controller
{
    public function create(StripePayment $srtipe, Subscription $subscription)
    {
        // Check if susbscription
        return $srtipe->createCheckoutSession($subscription);
    }

    public function store(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription_id);

        $stripe = new StripeClient(config('services.stripe.secret_ket'));
        try {
            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $subscription->price * 100,
                'currency' => 'usd',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'clientSecret' => $paymentIntent->client_secret,
            ];
        } catch (Error $e) {
            return Response::json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function seccess(Request $request)
    {
        return view('payments.success');
    }

    public function cancel(Request $request)
    {
        return view('payments.cancelled');
    }

}
