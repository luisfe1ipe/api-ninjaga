<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectIndexRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Services\FileHandler;
use App\Services\FilterProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectIndexRequest $request)
    {
        $request->validated();

        $query = $this->applyFilters(Project::class, 'title');

        $query = FilterProjects::filter($query, $request);

        $projects = $query->with(['genres']);

        return response()->json(['data' => $this->response($projects)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        $project = DB::transaction(function () use ($request) {
            $projectData = $request->except(['genres', 'authors', 'artists', 'image']);
            $projectData['slug'] = Str::slug($request->get('title')) . '-' . rand(10000, 99999);

            $project = Project::create($projectData);

            $project->genres()->attach($request->get('genres'));
            $project->authors()->attach($request->get('authors'));
            $project->artists()->attach($request->get('artists'));

            return $project;
        });

        $project->image = FileHandler::store($request->image, 'projects/images/');
        $project->save();

        return response()->json(['data' => $project], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->with(['genres', 'authors', 'artists'])->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $project], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        DB::transaction(function () use ($request, $project) {
            $projectData = $request->except(['genres', 'authors', 'artists', 'image']);

            if ($request->has('title')) {
                $projectData['slug'] = Str::slug($request->get('title')) . '-' . rand(10000, 99999);
            }

            $project->update($projectData);

            if ($request->has('genres')) {
                $project->genres()->sync($request->get('genres'));
            }

            if ($request->has('authors')) {
                $project->authors()->sync($request->get('authors'));
            }

            if ($request->has('artists')) {
                $project->artists()->sync($request->get('artists'));
            }

            // Atualização da imagem, se for fornecida
            if ($request->hasFile('image')) {
                $project->image = FileHandler::update($request->file('image'), 'projects/images/', $project->image);
                $project->save();
            }
        });

        return response()->json(['data' => $project->fresh()], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
