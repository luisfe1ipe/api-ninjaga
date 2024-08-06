<?php

namespace App\Http\Controllers;

use App\Jobs\SendRequestChapterNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RequestChapterController extends Controller
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
            'chapter' => ['string', 'max:255'],
            'volume' => ['string', 'max:255'],
            'project_id' => ['required', Rule::exists('projects', 'id')],
        ]);

        $data = $request->only(['chapter', 'volume', 'project_id']);

        $requestChapter = $request->user()->requestChapters()->create($data);

        SendRequestChapterNotification::dispatch($requestChapter);

        return response()->json(['message' => 'Chapter request created successfully.'], Response::HTTP_OK);
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
