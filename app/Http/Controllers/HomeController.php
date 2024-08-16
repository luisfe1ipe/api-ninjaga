<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function mostView()
    {
        $mostView = Project::orderBy('views', 'desc')
            ->inRandomOrder()
            ->limit(10)
            ->with(['genres', 'authors', 'artists'])
            ->get();

        return response()->json(['data' => $mostView], Response::HTTP_OK);
    }
}
