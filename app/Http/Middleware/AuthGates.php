<?php

namespace App\Http\Middleware;

use App\Models\Feature;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $parent_user_id = auth()->user()->parent_user_id ?? auth()->id();
            $userFeatures = Feature::select('features.name', 'feature_plan.max_amount')
                ->join('feature_plan', 'feature_plan.feature_id', '=', 'features.id')
                ->join('plans', 'feature_plan.plan_id', '=', 'plans.id')
                ->join('subscriptions', 'plans.stripe_price_id', '=', 'subscriptions.stripe_price')
                ->where('subscriptions.user_id', $parent_user_id)
                ->where(function($query) {
                    return $query->whereNull('subscriptions.ends_at')
                        ->orWhere('subscriptions.ends_at', '>', now()->toDateTimeString());
                })
                ->get();
            foreach ($userFeatures as $feature) {
                Gate::define($feature->name, function() { return true; });

                if (!is_null($feature->max_amount)) {
                    Gate::define($feature->name . '_create', function () use ($feature) {
                        $method = $feature->name;
                        if (!method_exists(auth()->user(), $method)) {
                            return true;
                        }

                        return auth()->user()->{$method}()->count() < $feature->max_amount;
                    });
                }
            }
        }
        return $next($request);
    }
}
