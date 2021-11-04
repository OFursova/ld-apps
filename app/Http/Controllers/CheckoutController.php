<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout($planId)
    {
        $plan = Plan::findOrFail($planId);
        $intent = auth()->user()->createSetupIntent();

        return view('billings.checkout', compact('plan', 'intent'));
    }

    public function process(Request $request)
    {
        $plan = Plan::findOrFail($request->input('billing_plan_id'));

        try {
            auth()->user()->newSubscription($plan->name, $plan->stripe_price_id)
                ->create($request->input('payment_method'));
            return redirect()->route('billings.index')->withMessage('Subscribed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
