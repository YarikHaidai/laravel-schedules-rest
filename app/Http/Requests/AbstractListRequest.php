<?php

namespace App\Http\Requests;

abstract class AbstractListRequest extends Request
{
    /**
     * @return array
     */
    public function queryRules(): array
    {
        return [
            'skip' => ['numeric'],
            'take' => ['numeric'],
            'asc' => [],
            'order_by' => ['string', 'in:created_at,updated_at,' . implode(',', $this->orderByFields())]
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge($this->resourceRules(), $this->queryRules());
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'order_by.in' => 'order by field is invalid. List of valid values: created_at,updated_at,' . implode(',', $this->orderByFields())
        ];
    }

    abstract public function orderByFields(): array;

    abstract public function resourceRules(): array;
}
