<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\ModelResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $created_at
 */
class UserResource extends ModelResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->created_at
        ];
    }
}
