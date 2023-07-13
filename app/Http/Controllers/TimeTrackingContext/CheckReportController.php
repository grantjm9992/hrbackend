<?php

namespace App\Http\Controllers\TimeTrackingContext;

use App\Http\Controllers\Controller;
use App\Models\TimeTrackingContext\Check;
use App\ValueObject\CheckStatus;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckReportController extends Controller
{
    public function hoursWorked(Request $request): JsonResponse
    {
        $user = Auth::user()->toArray();

        $checks = Check::query()
            ->where('user_id', $user['id'])
            ->where('status', CheckStatus::closed())
            ->where(
                'date_started',
                '>=',
                Carbon::now()
                    ->startOfWeek(1)
                    ->subDays(30)
                    ->setTime(0, 0, 0)
                    ->format('Y-m-d H:i:s')
            )->where(
                'date_started',
                '<',
                Carbon::now()
                    ->addWeek()
                    ->startOfWeek(1)
                    ->format('Y-m-d H:i:s')
            )->get()->toArray();

        $lastWeek = array_filter($checks, function ($check) {
            return $check['date_started'] <
                Carbon::now()
                    ->startOfWeek(1)
                    ->setTime(0, 0, 0)
                    ->format('Y-m-d H:i:s') && $check['date_started'] >=
                Carbon::now()
                    ->startOfWeek(1)
                    ->setTime(0, 0, 0);
        });
        $thisWeek = array_filter($checks, function ($check) {
            return $check['date_started'] >=
                Carbon::now()
                    ->startOfWeek(1)
                    ->setTime(0, 0, 0)
                    ->format('Y-m-d H:i:s');
        });

        return response()->json([
            'thisWeek' => $this->getTotalTimeForArrayOfChecks($thisWeek),
            'lastWeek' => $this->getTotalTimeForArrayOfChecks($lastWeek),
            'lastThirtyDays' => $this->getTotalTimeForArrayOfChecks($checks)
        ]);
    }

    private function getTotalTimeForArrayOfChecks(array $checks): int
    {
        $total = 0;
        foreach ($checks as $check) {
            $total += (int)Carbon::parse($check['date_ended'])->format('U') - (int)Carbon::parse($check['date_started'])->format('U');
        }
        return $total;
    }
}

