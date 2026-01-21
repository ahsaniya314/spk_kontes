<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Models\Rating;
use App\Models\Alternative;
use App\Models\Criterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RatingController extends Controller
{
    public function __construct()
    {
        // Authorization is handled in FormRequests and individual methods
    }

    /**
     * Display a listing of ratings for the authenticated juri.
     */
    public function index()
    {
        Gate::authorize('input-rating');
        $ratings = Rating::where('user_id', auth()->id())
            ->with(['criterion.category', 'alternative'])
            ->paginate(10);
        
        return view('ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new rating.
     */
    public function create()
    {
        Gate::authorize('input-rating');
        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();
        
        return view('ratings.create', compact('alternatives', 'criteria'));
    }

    /**
     * Store a newly created rating in storage.
     */
    public function store(StoreRatingRequest $request)
    {
        // Check if rating already exists for this juri, criterion, and alternative
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('criterion_id', $request->criterion_id)
            ->where('alternative_id', $request->alternative_id)
            ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update([
                'value' => $request->value,
            ]);
            
            return redirect()->route('ratings.index')
                ->with('success', 'Penilaian berhasil diperbarui.');
        }

        // Create new rating
        Rating::create([
            'criterion_id' => $request->criterion_id,
            'alternative_id' => $request->alternative_id,
            'user_id' => auth()->id(),
            'value' => $request->value,
        ]);

        return redirect()->route('ratings.index')
            ->with('success', 'Penilaian berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified rating.
     */
    public function edit(Rating $rating)
    {
        Gate::authorize('input-rating');
        // Ensure the rating belongs to the authenticated user
        if ($rating->user_id !== auth()->id()) {
            abort(403);
        }

        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();
        
        return view('ratings.edit', compact('rating', 'alternatives', 'criteria'));
    }

    /**
     * Update the specified rating in storage.
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $rating->update($request->validated());

        return redirect()->route('ratings.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    /**
     * Remove the specified rating from storage.
     */
    public function destroy(Rating $rating)
    {
        Gate::authorize('input-rating');
        // Ensure the rating belongs to the authenticated user
        if ($rating->user_id !== auth()->id()) {
            abort(403);
        }

        $rating->delete();

        return redirect()->route('ratings.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}
