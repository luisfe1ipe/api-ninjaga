<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = $this->applyFilters(Type::class, 'name');

        return response()->json(['data' => $this->response($types)], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('types')]
        ]);

        $type = Type::create($request->only('name'));

        return response()->json(['data' => $type], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return response()->json(['data' => $type], Response::HTTP_OK);
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
