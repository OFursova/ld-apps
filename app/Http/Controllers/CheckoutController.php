<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Notifications\ChargeSuccessNotification;
use Illuminate\Http\Request;

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

        $intent = auth()->user()->createSetupIntent();

        return view('billings.checkout', compact('plan', 'intent', 'countries'));
    }

    public function process(Request $request)
    {
        $plan = Plan::findOrFail($request->input('billing_plan_id'));

        try {
            $user = auth()->user();
            $user->newSubscription($plan->name, $plan->stripe_price_id)
                ->create($request->input('payment_method'));
            $user->update([
               'trial_ends_at' => null
            ]);
            $user->billingData()->updateOrCreate(
                ['user_id' => $user->id],
                $request->input('billing_details')
            );
// Find a way to fetch charge data
//            $user = User::where('stripe_id', $charge['customer']->first());
//
//            if ($user) {
//                $payment = Payment::create([
//                    'user_id' => $user->id,
//                    'stripe_id' => $charge['id'],
//                    'subtotal' => $charge['amount'],
//                    'total' => $charge['amount'],
//                ]);
//
//                $user->notify(new ChargeSuccessNotification($payment));
//            }
            return redirect()->route('billings.index')->withMessage('Subscribed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
