<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\User;
use App\ValueObject\CheckStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();

        $checks = Check::query()
            ->where('company_id', $user['company_id'])
            ->get()
            ->all();

        return new JsonResponse([
            'message' => 'success',
            'data' => $checks
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $check = Check::find($id);

        return new JsonResponse([
            'message' => 'success',
            'data' => $check
        ]);
    }

    public function getCalendarForTeam(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();
        $this->validate($request, [
            'date_from' => 'required|string',
            'date_to' => 'required|string',
        ]);

        $users = User::query()
            ->where('company_id', $user['company_id'])
            ->get()
            ->all();

        $returnArray = [];
        foreach ($users as $user_) {
            $checks = Check::query()
                ->where('user_id', $user_['id'])
                ->where('date_started', '>=', $request->date_from)
                ->where('date_ended', '<=', $request->date_to)
                ->get()
                ->all();
            $returnArray[] = [
                'user' => $user_,
                'checks' => $checks,
            ];
        }

        return new JsonResponse([
            'message' => 'success',
            'data' => $returnArray,
        ]);
    }

    public function getCalendarForUser(string $userId, Request $request): JsonResponse
    {
        $this->validate($request, [
            'date_from' => 'required|string',
            'date_to' => 'required|string',
        ]);

        $checks = Check::query()
            ->where('user_id', $userId)
            ->where('date_started', '>=', $request->date_from)
            ->where('date_ended', '<=', $request->date_to)
            ->get()
            ->all();

        return new JsonResponse([
            'message' => 'success',
            'data' => $checks,
        ]);
    }
    public function create(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();

        $this->validate($request, [
            'user_id' => 'required|string',
            'status' => 'required|string',
            'check_type_id' => 'required|string',
            'summary' => 'string',
            'task_id' => 'string',
            'project_id' => 'string',
            'client_id' => 'string',
            'date_started' => 'required|string',
            'date_ended' => 'required|string',
        ]);

        $request->company_id = $user['company_id'];

        Check::create($request->toArray());

        return new JsonResponse([
            'message' => 'success',
        ]);
    }

    public function checkIn(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();

        $check = Check::query()
            ->where('user_id', $user['id'])
            ->where('status', CheckStatus::open())
            ->first();

        if (!is_null($check)) {
            return new JsonResponse([
                'message' => 'error',
                'errors' => [
                    [
                        'message' => 'User already checked in'
                    ]
                ]
            ], 400);
        }

        $this->validate($request, [
            'check_type_id' => 'string',
            'task_id' => 'string',
            'project_id' => 'string',
            'client_id' => 'string',
            'date_started' => 'required|string',
        ]);

        Check::create([
            'user_id' => $user['id'],
            'company_id' => $user['company_id'],
            'status' => CheckStatus::open(),
            'check_type_id' => $request->check_type_id,
            'task_id' => $request->task_id,
            'project_id' => $request->project_id,
            'client_id' => $request->client_id,
            'date_started' => $request->date_started,
        ]);

        return new JsonResponse([
            'message' => 'success',
        ]);
    }

    public function checkOut(Request $request): JsonResponse
    {
        $this->validate($request, [
            'date_ended' => 'required|string',
        ]);

        $user = Auth::user()->toArray();
        $check = Check::query()
            ->where('user_id', $user['id'])
            ->where('status', CheckStatus::open())
            ->first();

        if ($check === null) {
            return new JsonResponse([
                'message' => 'error',
                'errors' => [
                    [
                        'message' => 'No open check found for user',
                    ],
                ],
            ], 401);
        }

        $check->close($request->date_ended);

        return new JsonResponse([
            'message' => 'success'
        ]);
    }
}
