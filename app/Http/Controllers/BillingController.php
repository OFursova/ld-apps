<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;

class BillingController extends Controller
{
    public function index()
    {
        $monthlyPlans = Plan::where('billing_period', 'monthly')->get();
        $yearlyPlans = Plan::where('billing_period', 'yearly')->get();$plans = Plan::all();
        $currentPlan = auth()->user()->subscription();

        $paymentMethods = null;
        $defaultPaymentMethod = null;
        if (!is_null($currentPlan)) {
            $paymentMethods = auth()->user()->paymentMethods();
            $defaultPaymentMethod = auth()->user()->defaultPaymentMethod();
        }

        $payments = Payment::where('user_id', auth()->id())->latest()->get();

        return view('billings.index', compact('monthlyPlans', 'yearlyPlans', 'currentPlan', 'paymentMethods', 'defaultPaymentMethod', 'payments'));
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

    public function downloadInvoice($paymentId)
    {
        $payment = Payment::where('user_id', auth()->id())->where('id', $paymentId)->firstOrFail();
        $filename = storage_path('app/invoices/' . $payment->id . '.pdf');
        if (!file_exists($filename)) {
            abort(404);
        }
        return response()->download($filename);
    }
}
