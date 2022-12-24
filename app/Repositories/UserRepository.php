<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * LogRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

//    /**
//     * @param Request $request
//     * @return LengthAwarePaginator
//     */
//    public function search(Request $request): LengthAwarePaginator
//    {
//        return (new UserSearchService())->search($request);
//    }
}
