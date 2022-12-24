<?php

namespace App\Http\Requests\V1\Schedule;

use App\Rules\V1\Schedule\IsCanStoreRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ScheduleStoreRequest extends FormRequest
{
    /**
     * @return array
     */
    public function validationData(): array
    {
        $this->merge(['user_id' => Auth::check() ? Auth::id() : null]);
        return $this->all();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => ['string', 'max:190', 'required'],
            'description' => ['string', 'nullable'],
            'duration'    => ['numeric', 'min:10', 'required'],
            'date_start'  => ['date_format:Y-m-d H:i:s', 'required', 'after_or_equal:now', new IsCanStoreRule()]
        ];
    }

}
