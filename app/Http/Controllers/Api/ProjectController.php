<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::with('type', 'technologies')->paginate(6);
        return response()->json([
            'success' => true,
            'results' => $projects
        ]);
    }

    public function show($slug) {
        
        // recupero un progetto con un determinato slug
        $project = Project::with('type', 'technologies')->where('slug', $slug)->get();

        // controllo che il progetto esista e non sia null
        if($project) {
            return response()->json([
                'success' => true,
                'result' => $project
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
