<?php

namespace App\Services\Search\Abstract;

use App\Services\Search\SearchService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

abstract class AbstractSearchService extends SearchService
{
    public function __construct()
    {
        $this->model = $this->baseModel();
    }

    /**
     * @return Model
     */
    abstract public function baseModel(): Model;

    /**
     * @param Request $request
     * @return LengthAwarePaginator|QueryBuilder
     */
    public function search(Request $request): LengthAwarePaginator|QueryBuilder
    {
        return $this
            ->handleSearch($request)
            ->get();
    }

    /**
     * @param Request $request
     * @return $this
     */
    protected function handleSearch(Request $request): AbstractSearchService
    {
        $this->request = $request;

        $this->setBaseQuery()
            ->applyAllowedFilters()
            ->applySearch();

        return $this;
    }

    /**
     * @return AbstractSearchService
     */
    protected function applySearch(): AbstractSearchService
    {
        return $this->applySearchTermSearch();
    }

    /**
     * @return $this
     */
    protected function setBaseQuery(): AbstractSearchService
    {
        $this->query = QueryBuilder::for($this->model, $this->request);

        return $this;
    }
}
