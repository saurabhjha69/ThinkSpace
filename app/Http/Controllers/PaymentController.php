<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Purchasedcourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
// use Session;

class PaymentController extends Controller
{
    public function showPaymentForm(Course $course)
    {
        return view('payment.form',['course'=> $course]);
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Stripe expects the amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment description',
            ]);
            // dd($charge->status);

            $purchaseCourse = Purchasedcourse::create([
                'user_id' => Auth::user()->id,
                'course_id' => $request->course_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $payments = Payment::create([
                'purchased_course_id' => $purchaseCourse->id,
                'payment_amount' => $charge->paid * 10,
                'payment_method' => $charge->payment_method,
                'payment_status' => $charge->status,
                'payment_date' => now(),
            ]);



            // Payment was successful
            Session::flash('success', 'Payment successful!');
            return redirect('/payment/'.$request->course_id);

        } catch (\Exception $e) {
            // Handle payment failure
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}

