<?php

namespace App\Http\Requests\V1\Schedule;

use App\Http\Requests\AbstractStoreRequest;
use Illuminate\Support\Facades\Auth;

class ScheduleStoreRequest extends AbstractStoreRequest
{
    use ScheduleBasicRequest;

    /**
     * @return array
     */
    public function basicRules(): array
    {
        dd(Auth::check());

        return $this->scheduleRules();
    }

    /**
     * @return array
     */
    public function required(): array
    {
        return [
            'title',
            'date_start',
            'duration'
        ];
    }
}
