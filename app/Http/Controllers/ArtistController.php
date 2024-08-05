<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Services\FileHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = $this->applyFilters(Artist::class, 'name');

        return response()->json(['data' => $this->response($artists)], Response::HTTP_OK);
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
        $data['avatar'] = FileHandler::store($request->avatar, 'artists/avatars/');
        $data['wallpaper'] = FileHandler::store($request->wallpaper, 'artists/wallpapers/');

        $artist = Artist::create($data);

        return response()->json(['data' => $artist], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        return response()->json(['data' => $artist], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'new_avatar' => ['nullable', 'image'],
            'new_wallpaper' => ['nullable', 'image'],
        ]);

        $data = $request->only(['name', 'bio']);

        if ($request->file('new_avatar')) {
            $data['new_avatar'] = FileHandler::update($request->new_avatar, 'artists/avatars/', $artist->avatar);
        }

        if ($request->file('new_wallpaper')) {
            $data['new_wallpaper'] = FileHandler::update($request->new_wallpaper, 'artists/wallpapers/', $artist->wallpaper);
        }

        $artist->update($data);
        $artist->save();

        return response()->json(['data' => $artist], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
