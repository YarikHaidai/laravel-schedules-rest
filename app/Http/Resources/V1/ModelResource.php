<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    protected array $fullModelRoutes = [];

    public ?array $errors = null;
    public static $wrap = 'model';

    /**
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'errors' => $this->errors ?? json_decode('{}'),
        ];
    }

    /**
     * @param $json
     * @return array|mixed
     */
    protected function jsonToArray($json)
    {
        if ( is_array($json) ) {
            return $json;
        }

        if ( is_string($json) ) {
            $stdClass = json_decode($json);
            return json_decode(json_encode($stdClass), true);
        }

        return $json;
    }

    /**
     * @return bool
     */
    protected function showFullData(): bool
    {
        return collect($this->fullModelRoutes)
            ->contains(request()->route()->getName());
    }
}
