<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects on dashboard.
     */
    public function index(): Response
    {
        $projects = Project::orderBy('order_index')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('dashboard/Projects', [
            'projects' => $projects,
        ]);
    }

    /**
     * Fetch public repositories of user 'umamumam' from GitHub API.
     */
    public function githubRepos()
    {
        $response = Http::get('https://api.github.com/users/umamumam/repos?per_page=100&sort=updated');

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data dari GitHub.'], 500);
        }

        $repos = collect($response->json())->map(function ($repo) {
            return [
                'id' => $repo['id'],
                'name' => $repo['name'],
                'html_url' => $repo['html_url'],
                'description' => $repo['description'] ?? '',
                'topics' => $repo['topics'] ?? [],
            ];
        });

        return response()->json($repos);
    }

    /**
     * Store a newly created project in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'github_id' => 'nullable|integer|unique:projects,github_id',
            'name' => 'nullable|string',
            'title' => 'required|string|max:255',
            'client' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'github_url' => 'nullable|url|nullable',
            'demo_url' => 'nullable|url|nullable',
            'tech' => 'nullable|array',
            'impact' => 'nullable|string',
            'wa_message' => 'nullable|string',
            'is_visible' => 'required|boolean',
            'order_index' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        Project::create($validated);

        return redirect()->back();
    }

    /**
     * Update the specified project in database.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'github_id' => 'nullable|integer|unique:projects,github_id,' . $project->id,
            'name' => 'nullable|string',
            'title' => 'required|string|max:255',
            'client' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'github_url' => 'nullable|url|nullable',
            'demo_url' => 'nullable|url|nullable',
            'tech' => 'nullable|array',
            'impact' => 'nullable|string',
            'wa_message' => 'nullable|string',
            'is_visible' => 'required|boolean',
            'order_index' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists and is stored locally
            if ($project->image_path && str_starts_with($project->image_path, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $project->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('projects', 'public');
            $validated['image_path'] = '/storage/' . $path;
        }

        $project->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified project from database.
     */
    public function destroy(Project $project)
    {
        // Delete image if it exists and is stored locally
        if ($project->image_path && str_starts_with($project->image_path, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $project->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $project->delete();

        return redirect()->back();
    }
}
