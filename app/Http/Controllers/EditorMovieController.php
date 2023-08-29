<?php
namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorMovieController extends Controller
{
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'genre' => 'string',
            'release_date' => 'date',
            'duration' => 'integer',
        ]);

        // Find the movie by ID
        $movie = Movie::findOrFail($id);

        // Update the movie details
        $movie->update($validatedData);

        return response()->json(['message' => 'Movie details updated successfully', 'data' => $movie]);
    }
}
