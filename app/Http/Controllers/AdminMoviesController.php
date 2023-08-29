<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMoviesController extends Controller
{

    public function store(Request $request)
    {
       
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string',
            'release_date' => 'required|date',
            'duration' => 'required|integer',
        ]);

        // Create a new movie
        $movie = Movie::create($validatedData);

        return response()->json(['message' => 'Movie created successfully', 'data' => $movie], 201);
    }
}

