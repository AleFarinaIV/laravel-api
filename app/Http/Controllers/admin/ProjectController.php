<?php

namespace App\Http\Controllers\admin;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $types = Type::all();
        return view('admin.projects.index', compact('projects', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // Valida i dati
        $validatedData = $request->validated();
        
        // Genera lo slug
        $validatedData['slug'] = Project::generateSlug($validatedData['name']);

        if($request->hasFile('image_path')) {
            $path = Storage::disk('public')->put('image_path', $validatedData['image_path']);
            $validatedData['image_path'] = $path;
        }

        // Crea il progetto
        $project = Project::create($validatedData);


        if($request->has('technologies')) {
            $project->technologies()->attach($request->technologies);
        }
        
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validatedData = $request->validated();

        // Genera lo slug
        $validatedData['slug'] = Project::generateSlug($validatedData['name']);

        if($request->hasFile('image_path')) {
            if(!Str::startsWith($project->image_path, 'https')) {
                Storage::disk('public')->delete($project->image_path);
            }
            $path = Storage::disk('public')->put('image_path', $validatedData['image_path']);
            $validatedData['image_path'] = $path;
        }
    
        // Aggiorna il progetto con lo slug
        $project->update($validatedData);
        return redirect()->route('admin.projects.show', compact('project'))->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(!Str::startsWith($project->image_path, 'https')) {
            Storage::disk('public')->delete($project->image_path);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }
}
