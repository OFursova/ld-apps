<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\RegisterStepTwoController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::group(['middleware' => ['registration_completed']], function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    Route::get('register-step2', [RegisterStepTwoController::class, 'create'])->name('register-step2.create');
    Route::post('register-step2', [RegisterStepTwoController::class, 'store'])->name('register-step2.post');

    Route::get('listings/{listingId}/photos/{photoId}/delete', [ListingController::class, 'deletePhoto'])->name('listings.deletePhoto');
    Route::resource('listings', ListingController::class);
    Route::resource('messages', MessageController::class)->only(['create', 'store']);

    Route::get('billings', [BillingController::class, 'index'])->name('billings.index');
    Route::get('coupon', [CheckoutController::class, 'checkCoupon'])->name('coupon');
    Route::get('{planId}/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('cancel', [BillingController::class, 'cancel'])->name('cancel');
    Route::get('resume', [BillingController::class, 'resume'])->name('resume');

    Route::resource('payment-methods', PaymentMethodController::class);
    Route::get('payment-methods/default/{methodId}', [PaymentMethodController::class, 'markDefault'])->name('payment-methods.markDefault');
    Route::get('invoice/download/{paymentId}', [BillingController::class, 'downloadInvoice'])->name('invoices.download');

    Route::resource('tasks', TaskController::class);
    Route::resource('members', MembersController::class);

    Route::resource('communities', CommunityController::class);
    Route::resource('communities.posts', CommunityPostController::class);
});

Route::get('invitation/{invitation_token}', [MembersController::class, 'invitation'])->name('invitation');
Route::post('invitation/confirm', [MembersController::class, 'confirmInvitation'])->name('invitation.confirm');

Route::stripeWebhooks('stripe-webhook'); // the same endpoint as in Stripe Dashboards + don't forget to make it an exception in VerifyCsrfToken
