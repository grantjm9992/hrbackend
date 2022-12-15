<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string',
        ]);

        $client = Clients::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => $user['company_id'],
            'active' => true,
        ]);

        return new JsonResponse([
            'message' => 'success',
            'data' => [
                'id' => $client->id
            ],
        ]);
    }

    public function find(string $id): JsonResponse
    {
        $client = Clients::find($id);

        return new JsonResponse([
            'message' => 'success',
            'data' => $client,
        ]);
    }

    public function delete(string $id): JsonResponse
    {
        Clients::destroy([$id]);

        return new JsonResponse([
            'message' => 'success'
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string',
            'active' => 'required|boolean',
        ]);

        $client = Clients::find($id);
        $client->update([
            'name' => $request->name,
            'description' => $request->description,
            'active' => $request->active,
        ]);

        return new JsonResponse([
            'message' => 'success',
        ]);
    }

    public function listAll(Request $request): JsonResponse
    {
        $clients = Clients::query()
            ->with('projects')
            ->orderBy('name')
            ->get()
            ->toArray();

        return new JsonResponse([
            'message' => 'success',
            'data' => $clients,
        ]);
    }
}
