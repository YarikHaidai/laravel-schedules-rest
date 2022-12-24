<?php

namespace App\Services\Search;

use App\Models\Schedule;
use App\Services\Search\Abstract\AbstractSearchService;
use Illuminate\Database\Eloquent\Model;

class ScheduleSearchService extends AbstractSearchService
{
    /**
     * @var array
     */
    protected array $scopeFilters = [
        'date_start',
        'date_end'
    ];

    /**
     * @return Model
     */
    public function baseModel(): Model
    {
        return new Schedule();
    }
}
