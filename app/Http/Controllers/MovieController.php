<?php

namespace App\Http\Controllers;

use App\Helper\CommonHelper;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::query()->get();

        return Inertia::render('Movie/Index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        return Inertia::render('Movie/Create');
    }

    public function save(MovieRequest $request)
    {
        $inputs = $request->validated();

        if ($request->file('image')) {
            $inputs['image'] = CommonHelper::uploadFile($request->file('image'), 'movie');
        }
        Movie::query()->create($inputs);

        return redirect()->route('movies')->with('message', 'Movie created successfully');
    }

    public function edit(Movie $movie)
    {
        return response()->json($movie);
    }

    public function update(Movie $movie, MovieRequest $request)
    {
        $inputs = $request->validated();
        if ($request->file('image')) {
            $inputs['image'] = CommonHelper::uploadFile($request->file('image'), 'movie', $movie->image);
        }
        $movie->update($inputs);

        return redirect()->route('movies')->with('message', 'Movie updated successfully');
    }

    public function delete(Movie $movie)
    {
        CommonHelper::removeOldFile('public/movie/'.$movie->image);
        $movie->delete();

        return redirect()->route('movies')->with('message', 'Movie deleted successfully');
    }
}
