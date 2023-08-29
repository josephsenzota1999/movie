<?php

namespace App\Http\Controllers; // Add the correct namespace

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieRatingController extends Controller
{
    public function rateMovie(Request $request)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|between:1,5',
        ]);

        $user = $request->user();
        $movie = Movie::find($validatedData['movie_id']);

        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        // Check if the user has already rated the movie
        $existingRating = Rating::where('user_id', $user->id)
            ->where('movie_id', $movie->id)
            ->first();

        if ($existingRating) {
            // Update the existing rating
            $existingRating->update(['rating' => $validatedData['rating']]);
        } else {
            // Create a new rating
            Rating::create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
                'rating' => $validatedData['rating'],
            ]);
        }

        return response()->json(['message' => 'Movie rated successfully']);
    }

    public function getUserRatings(Request $request)
    {
        $user = $request->user();
        $ratings = Rating::where('user_id', $user->id)->get();

        return response()->json(['ratings' => $ratings]);
    }
}
