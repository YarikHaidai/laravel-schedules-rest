<?php

namespace App\Http\Requests\V1\Schedule;

use App\Rules\V1\IsCanStoreRule;

trait ScheduleBasicRequest
{
    /**
     * @return array
     */
    public function scheduleRules(): array
    {
        return [
            'title'        => ['string', 'max:190'],
            'description'  => ['string', 'nullable'],
            'date_start'   => ['date_format:Y-m-d H:i:s', 'after_or_equal:now', new IsCanStoreRule()],
            'duration'     => ['numeric', 'min:10'],
        ];
    }
}
