<?php

namespace App\Http\Resources\V1\Auth;


use App\Http\Resources\V1\ModelResource;
use App\Http\Resources\V1\User\UserResource;

class LoginResource extends ModelResource
{
    /**
     * @var mixed
     */
    private string|null $token;

    /**
     * LoginResource constructor.
     * @param $resource
     * @param null $token
     */
    public function __construct($resource, $token = null)
    {
        parent::__construct($resource);

        $this->token = $token;
    }

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'user' => new UserResource($this->resource),
            'token' => $this->token
        ];
    }
}
