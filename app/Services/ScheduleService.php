<?php

namespace App\Services;

use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleService extends ScheduleRepository
{
    /**
     * @param Request $request
     * @param array $except
     * @return Schedule
     */
    public function make(Request $request, array $except = []): Model
    {
        $duration = $request->get('duration');
        $dateStart = $request->get('date_start');
        $dateEnd = Carbon::parse($dateStart)->addMinutes($duration);
        $request->merge([
            'date_end' => $dateEnd->format('Y-m-d H:i:s'),
            'user_id' => Auth::check() ? Auth::user()->id : null,
        ]);
        return parent::make($request);
    }
}
