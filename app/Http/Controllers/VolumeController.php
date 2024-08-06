<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class VolumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->applyFilters(Volume::class, 'name');

        if($request->filled('project_id'))
        {
            $query = $query->where('project_id', $request->project_id);
        }

        $query = $query->with(['project']);

        return response()->json(['data' => $this->response($query)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required', 'max:255'],
            'date' => ['nullable', 'date'],
            'project_id' => ['required', Rule::exists('projects', 'id')],
        ]);

        $data = $request->only(['name', 'date', 'project_id']);

        $volume = Volume::create($data);

        return response()->json(['data' => $volume], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Volume $volume)
    {
        $volume = $volume->with(['project'])->get();

        return response()->json(['data' => $volume], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Volume $volume)
    {
        $request->validate([
            'name' => ['string', 'required', 'max:255'],
            'date' => ['nullable', 'date'],
            'project_id' => ['required', Rule::exists('projects', 'id')],
        ]);

        $data = $request->only(['name', 'date', 'project_id']);

        $volume->update($data);
        $volume->save();

        return response()->json(['data' => $volume], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
