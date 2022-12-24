<?php

namespace App\Http\Requests\V1\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'filter.date_start' => ['date_format:Y-m-d H:i:s'],
            'filter.date_end'   => ['date_format:Y-m-d H:i:s', 'after:filter.date_start']
        ];
    }
}
