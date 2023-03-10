<?php

namespace App\Services;

use App\Models\Constants\ScheduleConstants;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use App\Services\Search\ScheduleSearchService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ScheduleService
{
    /**
     * @var ScheduleRepository
     */
    private ScheduleRepository $repository;

    /**
     * @var ScheduleSearchService
     */
    private ScheduleSearchService $searchService;

    /**
     * @param ScheduleRepository $repository
     * @param ScheduleSearchService $search
     */
    public function __construct(ScheduleRepository $repository, ScheduleSearchService $search)
    {
        $this->repository = $repository;
        $this->searchService = $search;
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function search(Request $request): LengthAwarePaginator
    {
        return $this->searchService->search($request);
    }

    /**
     * @param Schedule $schedule
     * @return bool
     */
    public function isCanBeUpdatedOrRemoved(Schedule $schedule): bool
    {
        $availableHours = (strtotime($schedule->date_start) - strtotime('now')) / 3600;
        if (ScheduleConstants::AVAILABLE_TIME_REMOVE_UPDATE < $availableHours) {
            return true;
        }
        return false;
    }

    /**
     * @param string $dateStart
     * @param int $duration
     * @return string
     */
    private function _makeDateEnd(string $dateStart, int $duration): string
    {
        return Carbon::parse($dateStart)
            ->addMinutes($duration)
            ->format('Y-m-d H:i:s');
    }

    /**
     * @param Request $request
     * @return Schedule
     */
    public function make(Request $request): Model
    {
        $dateEnd = $this->_makeDateEnd($request->get('date_start'), $request->get('duration'));
        $request->merge(['date_end' => $dateEnd]);
        return $this->repository->make($request);
    }

    /**
     * @param Schedule $schedule
     * @return bool
     */
    public function store(Schedule $schedule): bool
    {
        return $this->repository->store($schedule);
    }

    /**
     * @param Schedule $schedule
     * @param Request $request
     * @return bool
     */
    public function update(Schedule $schedule, Request $request): bool
    {
        $dateEnd = $this->_makeDateEnd(
            $request->get('date_start', $schedule->date_start),
            $request->get('duration', $schedule->duration)
        );
        $request->merge(['date_end' => $dateEnd]);

        return $this->repository->updateAttributes($schedule, $request->all());
    }
}
