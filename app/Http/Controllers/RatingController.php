<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request)
    {
//        $user = auth()->user();
//
//        // Determine if the rating is for a Post or a Product
//        $model = ($type === 'post') ? Post::findOrFail($id) : Product::findOrFail($id);
//
//        // Check if user has already rated
//        $existingRating = Rating::where('rateable_type', get_class($model))
//            ->where('rateable_id', $id)
//            ->where('user_id', $user->id)
//            ->first();
//
//        if ($existingRating) {
//            return response()->json(['message' => 'You have already rated this item'], 400);
//        }
//
//        // Create the rating
//        $rating = new Rating([
//            'rating' => $request->rating,
//            'user_id' => $user->id,
//        ]);
//
//        $model->ratings()->save($rating);
//
//        return response()->json(['message' => 'Rating added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
