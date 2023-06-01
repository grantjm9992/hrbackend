<?php declare(strict_types=1);

namespace App\Http\Controllers\TimeTrackingContext;

use App\Http\Controllers\Controller;
use App\Models\TimeTrackingContext\Projects;
use App\Services\JiraConnectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function __construct(private readonly JiraConnectService $jiraConnectService)
    {
    }

    public function create(Request $request): JsonResponse
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|string',
            'client_id' => 'required|string',
        ]);

        $project = Projects::create([
            'name' => $request->name,
            'client_id' => $request->client_id,
            'company_id' => $user['company_id'],
            'active' => true,
        ]);

        return new JsonResponse([
            'message' => 'success',
            'data' => [
                'id' => $project->id
            ]
        ]);
    }

    public function find(string $id): JsonResponse
    {
        $project = Projects::find($id);

        return new JsonResponse([
            'message' => 'success',
            'data' => $project,
        ]);
    }

    public function listAll(Request $request): JsonResponse
    {
        $projects = Projects::query()
            ->with('tasks.assignedTo')
            ->orderBy('name')
            ->get()
            ->toArray();

        return new JsonResponse([
            'message' => 'success',
            'data' => $projects
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'client_id' => 'required|string',
            'active' => 'required|boolean',
        ]);

        $project = Projects::find($id);
        $project->update([
            'name' => $request->name,
            'client_id' => $request->client_id,
            'active' => $request->active,
        ]);

        return new JsonResponse([
            'message' => 'success'
        ]);
    }

    public function getJiraProjects(Request $request): JsonResponse
    {
        $jiraProjects = $this->jiraConnectService->__invoke('issue');

        return response()->json($jiraProjects);
    }

    public function delete(string $id): JsonResponse
    {
        Projects::destroy([$id]);

        return new JsonResponse([
            'message' => 'success'
        ]);
    }
}