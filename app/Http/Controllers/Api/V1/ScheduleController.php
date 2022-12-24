<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Schedule\ScheduleStoreRequest;
use App\Http\Resources\V1\Schedule\ScheduleResource;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * @var ScheduleService
     */
    private ScheduleService $service;

    /**
     * ScheduleController constructor.
     * @param ScheduleService $service
     */
    public function __construct(ScheduleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ScheduleStoreRequest $request
     * @return ScheduleResource
     *
     * @group Schedule
     * @authenticated
     * @apiResource App\Http\Resources\Schedule\ScheduleResource
     * @apiResourceModel App\Models\Schedule
     */
    public function store(ScheduleStoreRequest $request): ScheduleResource
    {
        $schedule = $this->service->make($request);
        $this->service->store($schedule);

        return new ScheduleResource($schedule);
    }

    /**
     * @param Schedule $schedule
     * @return ScheduleResource
     *
     * @group Schedule
     * @authenticated
     * @apiResource App\Http\Resources\Schedule\ScheduleResource
     * @apiResourceModel App\Models\Schedule
     */
    public function show(Schedule $schedule): ScheduleResource
    {
        return new ScheduleResource($schedule);
    }

    /**
     * @param Schedule $Schedule
     * @return ScheduleResource
     *
     * @group Schedule
     * @authenticated
     * @apiResource App\Http\Resources\Schedule\ScheduleResource
     * @apiResourceModel App\Models\Schedule
     */
    public function destroy(Schedule $Schedule): ScheduleResource
    {
        $Schedule->delete();

        return new ScheduleResource($Schedule);
    }
}
