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
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string',
        ]);

        Clients::create([
            'name' => $request->name,
            'description' => $request->description,
            'companyId' => $user['companyId'],
            'active' => true,
        ]);

        return new JsonResponse(['message' => 'success']);
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

    public function listAll(Request $request): JsonResponse
    {
        $clients = Clients::where()
            ->orderBy('name', 'ASC')
            ->get()
            ->toArray();

        return new JsonResponse([
            'message' => 'success',
            'data' => $clients,
        ]);
    }
}
