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
        $projects = Project::all();

        return response()->json([
            'status' => 'success',
            'result' => $projects
        ]);
    }
};
