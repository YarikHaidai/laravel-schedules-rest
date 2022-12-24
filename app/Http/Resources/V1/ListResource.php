<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ListResource extends ResourceCollection
{
    public static $wrap = 'list';

    /**
     * @param $request
     * @return Collection
     */
    public function toArray($request): Collection
    {
        return $this->collection;
    }
}
