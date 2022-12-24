<?php

namespace App\Http\Requests\V1\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:190'],
            'description' => ['string'],
            'duration' => ['numeric', 'min:10'],
            'date_start' => ['date_format:Y-m-d H:i:s', 'after_or_equal:now']
        ];
    }
}
