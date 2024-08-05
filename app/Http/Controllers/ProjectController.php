<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use App\Services\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
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
    public function store(ProjectStoreRequest $request)
    {
        $project = DB::transaction(function () use ($request){
            $projectData = $request->except(['genres', 'authors', 'artists', 'image']);
            $projectData['slug'] = Str::slug($request->get('title')) . '-' . rand(10000, 99999);

            $project = Project::create($projectData);

            $project->genres()->attach($request->get('genres'));
            $project->authors()->attach($request->get('authors'));
            $project->artists()->attach($request->get('artists'));

            return $project->load(['genres', 'authors', 'artists']);
        });

        return response()->json(['data' => $project], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->with(['genres', 'authors', 'artists'])->first();

        if(!$project)
        {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $project], Response::HTTP_OK);
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
