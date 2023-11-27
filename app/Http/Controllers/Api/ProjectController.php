<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        /* $projects = Project::orderByDesc('id')->paginate(5); */
        /* $projects = Project::all(); */
        $projects = Project::with('type', 'technologies')->orderByDesc('id')->paginate(5);


        return response()->json([
            'status' => 'success',
            'result' => $projects
        ]);
    }

    public function show($slug)
    {
        $project = Project::with('technologies', 'type')->where('slug', $slug)->first();



        if ($project) {
            return response()->json([
                'success' => true,
                'result' => $project
            ]);
        } else {
            return response()->json([
                'success' => false,
                'result' => 'Ops, page not found'
            ]);
        };

        return response()->json([
            'success' => true,
            'result' => $project
        ]);
    }

    public function latests()
    {
        return response()->json([
            'success' => true,
            'result' => Project::with(['type', 'technologies'])->orderByDesc('id')->take(3)->get()
        ]);
    }
};
