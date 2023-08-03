<?php

namespace App\Http\Controllers\AcademyContext;

use App\Http\Controllers\Controller;
use App\Models\AcademyContext\Teacher;
use App\Models\CoreContext\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TeacherController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();
        $teachers = Teacher::query()
            ->select(
                'users.name',
                'users.surname',
                'users.email',
                'teachers.id',
                'teachers.user_id',
                'teachers.colour',
                'teachers.text_colour'
            )->join('users', 'users.id', '=', 'teachers.user_id')
            ->where('users.company_id', $user['company_id'])
            ->get()->all();

        return response()->json(['data' => $teachers]);
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|string',
            'colour' => 'required|string',
            'text_colour' => 'required|string',
        ]);

        /** @var User $user */
        $user = User::find($request->user_id);
        if (null === $user) {
            throw new NotFoundHttpException('User not found');
        }

        if (!in_array('teacher', $user->getUserRoleArray())) {
            throw new \Exception('User cannot be used as teacher');
        }

        Teacher::create($request->toArray());
        return response()->json();
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'colour' => 'required|string',
            'text_colour' => 'required|string',
        ]);

        $teacher = Teacher::find($id);
        if (null === $teacher) {
            throw new NotFoundHttpException('Teacher not found');
        }
        $teacher->update($request->toArray());
        return response()->json();
    }

    public function delete(string $id): JsonResponse
    {
        $teacher = Teacher::find($id);
        if (null === $teacher) {
            throw new NotFoundHttpException('Teacher not found');
        }
        $teacher->destroy();
        return response()->json();
    }
}
