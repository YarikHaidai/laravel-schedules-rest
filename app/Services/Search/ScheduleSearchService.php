<?php

namespace App\Services\Search;

use App\Models\Schedule;
use App\Services\Search\Abstract\AbstractSearchService;
use Illuminate\Database\Eloquent\Model;

class ScheduleSearchService extends AbstractSearchService
{
    /**
     * @var array|string[]
     */
    protected array $whereFilters = [
        'status'
    ];

    /**
     * @var array
     */
    protected array $scopeFilters = [
        'created_at_from',
        'created_at_to'
    ];

    /**
     * @return Model
     */
    public function baseModel(): Model
    {
        return new Schedule();
    }

}
