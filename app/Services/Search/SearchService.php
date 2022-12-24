<?php

namespace App\Services\Search;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SearchService
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var QueryBuilder
     */
    protected QueryBuilder $query;

    /**
     * @var array
     */
    protected array $whereFilters = [];

    /**
     * @var array
     */
    protected array $likeFilters = [];

    /**
     * @var array
     */
    protected array $relatedLikeFilters = [];

    /**
     * @var array
     */
    protected array $relatedWhereFilters = [];

    /**
     * @var array
     */
    protected array $scopeFilters = [];

    /**
     * @return array
     */
    protected function setAllowedFilters(): array
    {
        $this->whereFilters[] = $this->model->getKeyName();

        $allowedFilters = $this->likeFilters;

        foreach ($this->whereFilters as $item) {
            $allowedFilters[] = AllowedFilter::exact($item);
        }

        foreach ($this->relatedLikeFilters as $key => $relation) {
            $relation = is_array($relation) ? $relation : [$relation];
            $related = array_map(function ($item) use ($key) {
                return $key . '.' . $item;
            }, $relation);
            $allowedFilters = array_merge($allowedFilters, $related);
        }

        foreach ($this->relatedWhereFilters as $key => $relation) {
            $relation = is_array($relation) ? $relation : [$relation];
            $related = array_map(function ($item) use ($key) {
                return AllowedFilter::exact($key . '.' . $item);
            }, $relation);

            $allowedFilters = array_merge($allowedFilters, $related);
        }

        foreach ($this->scopeFilters as $filter) {
            $allowedFilters[] = AllowedFilter::scope($filter);
        }

        return $allowedFilters;
    }

    /**
     * @return $this
     */
    protected function applyAllowedFilters(): SearchService
    {
        $allowedFilters = $this->setAllowedFilters();
        $this->query = $this->query->allowedFilters($allowedFilters);

        return $this;
    }

    /**
     * @return $this
     */
    protected function applySearchTermSearch(): SearchService
    {
        $term = strtolower($this->request->get('search_term', ''));
        if ( empty($term) ) {
            return $this;
        }

        $filters = array_keys($this->request->get('filter', []));
        $likeSearchFields = array_diff($this->likeFilters, $filters);
        $whereSearchFields = array_diff($this->whereFilters, $filters);

        $this->query = $this->query->where(function ($query) use ($term, $likeSearchFields, $whereSearchFields) {
            foreach ($likeSearchFields as $field) {
                $query->orWhereRaw("LOWER($field) LIKE LOWER(?)", ["%{$term}%"]);
            }

            foreach ($whereSearchFields as $field) {
                $query->orWhereRaw("LOWER($field) = LOWER(?)", ["{$term}"]);
            }
        });

        return $this;
    }

    /**
     * @return LengthAwarePaginator
     */
    protected function get()
    {
        $orderBy = $this->request->get('order_by', 'created_at');
        $sortBy = $this->model->getTable() . '.' . $orderBy;
        $asc = (bool)$this->request->get('asc', false);
        $this->query = $asc ? $this->query->orderBy($sortBy) : $this->query->orderByDesc($sortBy);

        return $this->query->paginate(
            $this->request->get('take'),
            ['*'],
            'page',
            $this->request['page']
        );
    }
}
