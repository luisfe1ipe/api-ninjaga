<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\FileHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = $this->applyFilters(Author::class, 'name');

        return response()->json(['data' => $this->response($authors)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'avatar' => ['required', 'image'],
            'wallpaper' => ['required', 'image'],
        ]);

        $data = $request->only(['name', 'bio']);
        $data['avatar'] = FileHandler::store($request->avatar, 'authors/avatars/');
        $data['wallpaper'] = FileHandler::store($request->wallpaper, 'authors/wallpapers/');

        $author = Author::create($data);

        return response()->json(['data' => $author], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return response()->json(['data' => $author], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'new_avatar' => ['nullable', 'image'],
            'new_wallpaper' => ['nullable', 'image'],
        ]);

        $data = $request->only(['name', 'bio']);

        if ($request->file('new_avatar')) {
            $data['new_avatar'] = FileHandler::update($request->new_avatar, 'authors/avatars/', $author->avatar);
        }

        if ($request->file('new_wallpaper')) {
            $data['new_wallpaper'] = FileHandler::update($request->new_wallpaper, 'authors/wallpapers/', $author->wallpaper);
        }

        $author->update($data);
        $author->save();

        return response()->json(['data' => $author], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
