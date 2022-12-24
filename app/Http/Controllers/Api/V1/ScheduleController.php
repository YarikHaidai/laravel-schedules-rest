<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Schedule\ScheduleStoreRequest;
use App\Http\Requests\V1\Schedule\ScheduleUpdateRequest;
use App\Http\Resources\V1\Schedule\ScheduleResource;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Symfony\Component\HttpFoundation\Response as ResponseApi;

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
     * @param ScheduleUpdateRequest $request
     * @param Schedule $schedule
     * @return ScheduleResource|ResponseApi
     *
     * @group Schedule
     * @authenticated
     * @apiResource App\Http\Resources\Schedule\ScheduleResource
     * @apiResourceModel App\Models\Schedule
     */
    public function update(ScheduleUpdateRequest $request, Schedule $schedule): ScheduleResource|ResponseApi
    {
        $isCanRemove = $this->service->isCanBeUpdatedOrRemoved($schedule);
        if (!$isCanRemove) {
            return response()->json(['message' => 'Can`t be updated!'], ResponseApi::HTTP_BAD_REQUEST);
        }
        $this->service->update($schedule, $request);

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
     * @param Schedule $schedule
     * @return ResponseApi
     *
     * @group Schedule
     * @authenticated
     * @apiResource App\Http\Resources\Schedule\ScheduleResource
     * @apiResourceModel App\Models\Schedule
     */
    public function destroy(Schedule $schedule): ResponseApi
    {
        $isCanRemove = $this->service->isCanBeUpdatedOrRemoved($schedule);
        if (!$isCanRemove) {
            return response()->json(['message' => 'Can`t be removed!'], ResponseApi::HTTP_BAD_REQUEST);
        }

        $schedule->delete();

        return response()->json();
    }
}
