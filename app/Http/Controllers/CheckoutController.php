<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\ChargeSuccessNotification;
use App\Services\InvoicesService;
use Illuminate\Http\Request;
use Stripe\Coupon;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout($planId)
    {
        $plan = Plan::findOrFail($planId);
        $countries = Country::all();

        $currentPlan = optional(auth()->user()->subscription())->stripe_price;
        if (!is_null($currentPlan) && $currentPlan != $plan->stripe_price_id) {
            auth()->user()->subscription('default')->swap($plan->stripe_price_id);
            return redirect('billings');
        }

        $subtotal = $plan->price;
        $taxPercent = auth()->user()->taxPercentage();
        $taxAmount = round($subtotal * $taxPercent / 100);
        $total = $subtotal + $taxAmount;

        $intent = auth()->user()->createSetupIntent();

        return view('billings.checkout', compact('plan', 'subtotal', 'taxPercent', 'taxAmount', 'total', 'intent', 'countries'));
    }

    public function process(Request $request)
    {
        $plan = Plan::findOrFail($request->input('billing_plan_id'));

        try {
            $user = auth()->user();
            $b = $user->newSubscription('default', $plan->stripe_price_id)
                ->withCoupon($request->input('coupon'))
                ->create($request->input('payment_method'));

            $charge = $user->invoices(true, ['subscription' => $b->stripe_id])->first();
            $user->update([
               'trial_ends_at' => null
            ]);
            $user->billingData()->updateOrCreate(
                ['user_id' => $user->id],
                $request->input('billing_details')
            );

            if ($user) {
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'stripe_id' => $charge->charge,
                    'subtotal' => $charge->subtotal,
                    'total' => $charge->total,
                ]);

                // Generate invoice
                (new InvoicesService())->generateInvoice($payment);

                $user->notify(new ChargeSuccessNotification($payment));
            }
            return redirect()->route('billings.index')->withMessage('Subscribed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function checkCoupon(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $coupon = Coupon::retrieve($request->input('coupon_code'));
        } catch (\Exception $e) {
            return response()->json(['error_text' => 'Coupon not found']);
        }

        return $coupon;
    }
}
