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

    public function process()
    {

    }
}
