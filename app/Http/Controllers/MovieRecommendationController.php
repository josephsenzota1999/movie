<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class MovieRecommendationController extends Controller
{
    public function index(Request $request)
    {
        // Get the user for whom we want to generate recommendations
        $userId = $request->input('user_id'); // You can adjust how you pass the user ID
        
        // Set a limit for the number of recommendations
        $limit = $request->input('limit', 10);

        // Fetch movies that the user has rated
        $userRatings = Rating::where('user_id', $userId)->pluck('movie_id', 'rating');

        // Find users who have also rated those movies
        $similarUsers = Rating::whereIn('movie_id', $userRatings)
            ->where('user_id', '!=', $userId)
            ->distinct()
            ->pluck('user_id');

        // Find movies that similar users have rated highly
        $recommendedMovies = DB::table('ratings')
            ->whereIn('user_id', $similarUsers)
            ->whereNotIn('movie_id', array_keys($userRatings->toArray())) // Exclude movies the user has already rated
            ->select('movie_id', DB::raw('AVG(rating) as avg_rating'))
            ->groupBy('movie_id')
            ->orderBy('avg_rating', 'desc')
            ->limit($limit)
            ->get();

        // Fetch the details of the recommended movies
        $movieIds = $recommendedMovies->pluck('movie_id');
        $recommendedMoviesDetails = Movie::whereIn('id', $movieIds)->get();

        // Return the movie recommendations
        return response()->json(['recommendations' => $recommendedMoviesDetails]);
    }
}


