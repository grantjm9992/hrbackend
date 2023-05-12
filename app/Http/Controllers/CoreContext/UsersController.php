<?php declare(strict_types=1);

namespace App\Http\Controllers\CoreContext;

use App\Http\Controllers\Controller;
use App\Models\CoreContext\User;
use App\Models\TimeTrackingContext\Clients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
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
        $client = User::find($id);

        return new JsonResponse([
            'message' => 'success',
            'data' => $client,
        ]);
    }

    public function delete(string $id): JsonResponse
    {
        User::destroy([$id]);

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

        $client = User::find($id);
        $client->update([
            'name' => $request->name,
            'description' => $request->description,
            'active' => $request->active,
            'role_id' => $request->role ?? null
        ]);

        return new JsonResponse([
            'message' => 'success',
        ]);
    }

    public function listAll(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();
        $clients = User::query()
            ->where('company_id', $user['company_id'])
            ->orderBy('name');

        if ($request->query->get('name')) {
            $clients->where('name', 'LIKE', "%" . $request->query->get('name') . "%");
        }

        $clients = $clients->get()->toArray();

        return new JsonResponse([
            'message' => 'success',
            'data' => $clients,
        ]);
    }
}
