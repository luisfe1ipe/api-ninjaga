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
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
