<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Purchasedcourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\StripeClient;
// use Session;

class PaymentController extends Controller
{
    public function success()
    {
        $stripe = new StripeClient('sk_test_51PySJ6FDSWNoYbpZacsKpojbRFfP2m5uacznkWIoLwXg2FxgST5IvdXFbjzWCl2NBPlMcokuE9PvuH8ekZSvWeSg00byZoZkFU');
        $session_id = request()->query('session_id');
        $session = $stripe->checkout->sessions->retrieve($session_id);

        // Retrieve payment associated with the Stripe session
        $payment = Payment::where('stripe_session_id', $session->id)->first();

        if ($payment) {
            $payment->payment_status = $session->payment_status;
            $payment->status = $session->status;
            $payment->save();


            $user =  User::find($payment->user_id);
            $user->courses()->attach($payment->course_id, ['enrolled_at' => now()]);
            $user->save();
        }
        if (request('coupon')) {
            $coupon = Coupon::find(request('coupon'));

            // Update total_usage_count
            $coupon->total_usage_count += 1;
            $coupon->save(); // Save the updated count

            // Update the user's coupon usage status to 'success'
            DB::table('used_coupon')
            ->where('coupon_id', $coupon->id)
            ->where('user_id', Auth::id())
            ->where('course_id', $payment->course_id)
            ->update(['status' => 'success']);
        }



        return response('Successfully Purchased The Course');
    }

    public function process(Coupon $coupon)
    {
        // dd($coupon);
        $course = Course::find(request('course_id'));
        $user = Auth::user();
        $stripe = new StripeClient('sk_test_51PySJ6FDSWNoYbpZacsKpojbRFfP2m5uacznkWIoLwXg2FxgST5IvdXFbjzWCl2NBPlMcokuE9PvuH8ekZSvWeSg00byZoZkFU');


        $checkout_session = $stripe->checkout->sessions->create([
            'customer_email' => $user->email,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $course->name,
                            'images' => [$course->thumbnail_url],
                        ],
                        'unit_amount' => ($course->price * 100) - $coupon->discount_amount*100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}&coupon='.$coupon->id,
            'cancel_url' => 'http://localhost:8000/course/' . $course->id . '?failed=true&session_id={CHECKOUT_SESSION_ID}&coupon='.$coupon->id,

        ]);



        Payment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'amount' => $course->price,
            // Default status before payment confirmation
            'stripe_session_id' => $checkout_session->id,
        ]);
        // dd((double)$coupon->discount_amount);
        DB::table('used_coupon')->insert([
            'coupon_id' => $coupon->id,
            'course_id' => $course->id,
            'user_id' => Auth::id(),
            'discount' => (double) $coupon->discount_amount,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to($checkout_session->url);
    }
}
