<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->applyFilters(Genre::class, 'name');

        return response()->json(['data' => $this->response($query)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('genres')]
        ]);

        $genre = Genre::create($request->only('name'));

        return response()->json(['data' => $genre], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return response()->json(['data' => $genre], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => ['required', 'string','max:255', Rule::unique('genres')->ignore($genre->id)]
        ]);

        $genre->update($request->only('name'));

        return response()->json(['data' => $genre], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
