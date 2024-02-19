<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        request()->validate([
            'key' => ['nullable', 'string', 'min:3']
        ]);

        if (request()->key) {
            $projects = Project::where('name', 'LIKE', '%' . request()->key . '%')->with('type', 'technologies')->paginate(10);
        } else {
            $projects = Project::with('type', 'technologies')->paginate(10);
        }

        if ($projects) {
            return response()->json([
                'success' => true,
                'results' => $projects,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => [],
            ]);
        }
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();
        return response()->json([
            'success' => true,
            'result' => $project,
        ]);
    }
}
