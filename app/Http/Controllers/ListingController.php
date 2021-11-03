<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Jobs\SendRegisteredUserNotification;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Listing;
use App\Models\Size;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $listings = Listing::with(['categories', 'sizes', 'colors', 'user.city'])
            ->when(request('title'), function ($query) {
                $query->where('title', 'LIKE', '%' . request('title') . '%');
            })
            ->when(request('category'), function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('id', request('category'));
                });
            })
            ->when(request('size'), function ($query) {
                $query->whereHas('sizes', function ($query) {
                    $query->where('id', request('size'));
                });
            })
            ->when(request('color'), function ($query) {
                $query->whereHas('colors', function ($query) {
                    $query->where('id', request('color'));
                });
            })
            ->when(request('city'), function ($query) {
                $query->whereHas('user.city', function ($query) {
                    $query->where('id', request('city'));
                });
            })
            ->when(request('saved'), function ($query) {
                $query->whereHas('savedUsers', function ($query) {
                    $query->where('id', auth()->id());
                });
            })
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $cities = City::all();

        return view('listings.index', compact('listings', 'categories', 'sizes', 'colors', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

//        SendRegisteredUserNotification::dispatch(auth()->user());

        return view('listings.create', compact('categories', 'sizes', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreListingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreListingRequest $request)
    {
        $listing = auth()->user()->listings()->create($request->validated());

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->attach($request->categories);
        $listing->sizes()->attach($request->sizes);
        $listing->colors()->attach($request->colors);

        return redirect()->route('listings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Listing $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Listing $listing
     * @return Application|Factory|View
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        $listing->load('categories', 'sizes', 'colors');

        $media = $listing->getMedia('listings');
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('listings.edit', compact('listing', 'media', 'categories', 'sizes', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreListingRequest $request
     * @param Listing $listing
     * @return RedirectResponse
     */
    public function update(StoreListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->validated());

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile('photo' . $i)) {
                $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
            }
        }

        $listing->categories()->sync($request->categories);
        $listing->sizes()->sync($request->sizes);
        $listing->colors()->sync($request->colors);

        return redirect()->route('listings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Listing $listing
     * @return RedirectResponse
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()->route('listings.index');
    }

    public function deletePhoto($listingId, $photoId)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($listingId);

        $photo = $listing->getMedia('listings')->where('id', $photoId)->first();

        if ($photo) {
            $photo->delete();
        }

        return redirect()->route('listings.edit', $listingId);
    }
}
