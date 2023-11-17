<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Type;

class DashboardController extends Controller
{
    public function index(User $user)
    {
        $total_projects = Project::all()->count();
        $total_users = User::all()->count();
        $total_types = Type::all()->count();
        $projects = Project::all()->take(-3)->sortByDesc('id');

        return view('admin.dashboard', compact('user', 'total_projects', 'total_users', 'projects', 'total_types'));
    }
}
