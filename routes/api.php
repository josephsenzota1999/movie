<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminMoviesController;
use App\Http\Controllers\EditorMovieController;
use App\Http\Controllers\MovieRatingController;
use App\Http\Controllers\MovieRecommendationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Routes without authentication
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

// Routes requiring authentication using the 'api' guard
// Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Add new movie (accessible by 'api' guard)
    
        Route::post('/admin/movies', [AdminMoviesController::class, 'store']);


    // Update movie details (accessible by 'api' guard)
        Route::put('editor/movies/{id}', [EditorMovieController::class, 'update']);
    

    // Rate a movie (accessible by 'api' guard)
    Route::post('rate-movie', [MovieRatingController::class, 'rateMovie']);

    // Get user's ratings (accessible by 'api' guard)
    Route::get('user-ratings', [MovieRatingController::class, 'getUserRatings']);
// });

// Public routes accessible without authentication
Route::get('movie-recommendations', [MovieRecommendationController::class, 'index']);
