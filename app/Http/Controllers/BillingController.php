<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Services\InvoicesService;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $payment = Payment::with('user')->find(1);
        return (new InvoicesService())->generateInvoice($payment);

        $plans = Plan::all();
        $currentPlan = auth()->user()->subscription();
        $paymentMethods = auth()->user()->paymentMethods();
        $defaultPaymentMethod = auth()->user()->defaultPaymentMethod();
        return view('billings.index', compact('plans', 'currentPlan', 'paymentMethods', 'defaultPaymentMethod'));
    }

    public function cancel()
    {
        auth()->user()->subscription('default')->cancel();
        return redirect('billings');
    }

    public function resume()
    {
        auth()->user()->subscription('default')->resume();
        return redirect('billings');
    }
}
