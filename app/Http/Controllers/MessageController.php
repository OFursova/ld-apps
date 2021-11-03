<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Listing;
use App\Models\Message;
use App\Notifications\ListingMessageNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessageRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMessageRequest $request)
    {
        $listing = Listing::with('user')->findOrFail($request->listing_id);
        $sentMessages = Message::where('user_id', auth()->id())->where('created_at', '>', now()->subMinute())->count();

        if ($sentMessages < 5) {
            Message::create($request->validated());

            Notification::route('mail', $listing->user->email)
                ->notify(new ListingMessageNotification(auth()->user()->name, auth()->user()->email, $listing->title, $request->message));
        }

        return redirect()->route('listings.index')->with('message', 'Message sent successfully!');
    }

}
