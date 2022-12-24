<?php

namespace App\Services\Search;

use App\Models\User;
use App\Services\Search\Abstract\AbstractSearchService;

class UserSearchService extends AbstractSearchService
{
    /**
     * @var array|string[]
     */
    protected array $likeFilters = [
        'name',
        'surname',
        'email'
    ];

    /**
     * @return User
     */
    public function baseModel(): User
    {
        return new User();
    }
}
