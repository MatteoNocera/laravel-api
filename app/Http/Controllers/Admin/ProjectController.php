<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Technology;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->paginate(5);
        //dd($projects);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {


        $project = new Project();

        $val_data = $request->validated();

        if ($request->has('cover_image')) {

            $cover_image_path = Storage::put('placeholders', $request->cover_image);

            /* if (!is_null($project->cover_image) && Storage::fileExists($project->cover_image)) {
                    Storage::delete($project->cover_image);
                } */
            $val_data['cover_image'] = $cover_image_path;
        }

        $val_data['slug'] = Project::generateSlug($val_data['title'], '-');

        //dd($request->technologies);
        $project = Project::create($val_data);



        $project->technologies()->attach($request->technologies);



        return to_route('admin.projects.index', compact('project'))->with('message', 'New Project Created ✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        $trashed_projects = Project::onlyTrashed()->get();

        return view('admin.projects.show', ['project', $project], compact('project', 'trashed_projects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {



        $types = Type::all();

        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        //dd($request);



        $val_data = $request->validated();

        //dd($val_data);

        if ($request->has('cover_image')) {
            $path = Storage::put('placeholders', $request->cover_image);

            if (!is_null($project->cover_image) && Storage::fileExists($project->cover_image)) {
                Storage::delete($project->cover_image);
            }

            $val_data['cover_image'] = $path;
        }




        if (!Str::is($project->getOriginal('title'), $request->title)) {
            $val_data['slug'] = $project->generateSlug($request->title);
        }

        $project->update($val_data);

        $project->technologies()->sync($request->technologies);

        return to_route('admin.projects.index')->with('message', 'Project updated successfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        /* Controllare se c'è la foto nel public se si cancellala */
        /* if (!is_null($project->cover_image)) {
            Storage::delete($project->cover_image);
        } */

        if (Auth::id() === 1) {
            $project->delete();
        }
        return to_route('admin.projects.index')->with('message', 'Delete succesfully ✅');
    }

    public function trashed()
    {
        $projects = Project::onlyTrashed()->get();

        return view('admin.projects.trashed', compact('projects'));
    }

    public function restore($id)
    {
        if (Auth::id() === 1) {
            $project = Project::onlyTrashed()->find($id);

            $project->restore();
        }
        return to_route('admin.projects.index')->with('message', 'Restore succesfully ✅');
    }

    public function forceDelete($id)
    {
        $project = Project::onlyTrashed()->find($id);

        if (Auth::id() === 1) {
            # code...
            $project->technologies()->detach();

            if (!is_null($project->cover_image) && Storage::fileExists($project->cover_image)) {
                Storage::delete($project->cover_image);
            };

            $project->forceDelete();
        }

        return to_route('admin.trashed')->with('message', 'Total delete succesfully ✅');
    }
}
