<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\Bookings;
use Stripe\Stripe;
use Stripe\PaymentIntent;




class PaymentsController extends Controller
{
  public function create(){ 
    request()->validate([
        'booking_id' => 'required|exists:bookings,id',
        'amount' => 'required|numeric',
        'Payment_method' => 'required|string',
    ]);

    Stripe::setApiKey(config('services.stripe.secret'));

    $intent = PaymentIntent::create([
        'amount' =>request()->amount * 100, // in cents
        'currency' => 'usd',
        'payment_method_types' => ['card'],
        'payment_method' => request()->payment_method,
    ]);
    
    $payment = Payments::create([
        'booking_id' =>auth()->user->booking()->latest()->first()->id,
        'amount' =>request()->amount,
        'status' => 'pending',
        'Payment_method' => 'credit_card',
        'transaction_id' => $intent->id,
    ]);

    return response()->json([
        'payment_id' => $payment->id,
        'client_secret' => $intent->client_secret,
    ]);
}
}
