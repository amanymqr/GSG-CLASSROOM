<?php

namespace App\Http\Controllers;

use Error;
use Stripe\Charge;
use Illuminate\Support\Facades\Response;
use Stripe\StripeClient;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Subscription $subscription)
    {
        return view('checkout', [
            'subscription' => $subscription,
        ]);
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
        // return $request->all();

        $stripe = new StripeClient(config('services.stripe.secret_ket'));
        $stripe->paymentIntents->retrieve(
            $payment_intent =  $request->input('payment_intent'),
            []
        );
        // dd($payment_intent);

    }

    public function cancel(Request $request)
    {
        return $request->all();
    }



}
