<?php

namespace App\Rules\V1;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class IsCanStoreRule implements DataAwareRule, Rule
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        $dateEnd = Carbon::parse($this->data['date_start'])
            ->addMinutes($this->data['duration']);
        $this->data['date_end'] = $dateEnd->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isExist = Schedule::where([
            'date_start' => $this->data['date_start'],
            'date_end'   => $this->data['date_end']
        ])->exists();

        if ($isExist) {
            // Disable duplicate entry for all users
            return false;
        }

        if (!Auth::check()) {
            // Unauthorized user creation is prohibited if time overlaps
            return !Schedule::whereBetween('date_start', [$this->data['date_start'], $this->data['date_end']])
                ->orWhereBetween('date_end', [$this->data['date_start'], $this->data['date_end']])
                ->exist();
        }

        // Authorized user is allowed to cross dates
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
