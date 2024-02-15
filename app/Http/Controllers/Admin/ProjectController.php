<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $new_project = new Project();

        $new_project->fill($data);
        $new_project->slug = Str::slug($data['name']);

        if (isset($data['img'])) {
            $new_project->img = Storage::put('uploads', $data['img']);
        }

        $new_project->save();

        if (isset($data['technologies'])) {
            $new_project->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.projects.index')->with('message', "Progetto $new_project->name aggiunto correttamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
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
        $data = $request->validated();

        $project->slug = Str::of($data['name'])->slug('-');
        if (isset($data['img'])) {
            if (isset($project->img)) {
                Storage::delete($project->img);
            }
            $project->img = Storage::put('uploads', $data['img']);
        }

        $project->update($data);

        if (isset($data['technologies'])) {
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->sync([]);
        }

        return redirect()->route('admin.projects.show', $project)->with('message', "Progetto $project->name modificato correttamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->technologies()->detach();
        $project_name = $project->name;
        if ($project->img) {
            Storage::delete($project->img);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "Progetto $project_name cancellato correttamente");
    }
}
