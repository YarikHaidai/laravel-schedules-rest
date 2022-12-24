<?php

namespace App\Http\Requests\V1\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['email', 'required'],
            'password' => ['string', 'required']
        ];
    }
}
