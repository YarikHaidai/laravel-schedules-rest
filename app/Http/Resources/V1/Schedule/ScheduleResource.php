<?php

namespace App\Http\Resources\V1\Schedule;

use App\Http\Resources\V1\ModelResource;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $description
 * @property Carbon $date_start
 * @property Carbon $date_end
 * @property numeric $duration
 * @property Carbon $created_at
 *
 * @property User $user
 */
class ScheduleResource extends ModelResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'date_start'  => $this->date_start,
            'date_end'    => $this->date_end,
            'duration'    => $this->duration,
            'user'        => $this->user ? new UserResource($this->user): null,
            'created_at'  => $this->created_at
        ];
    }
}
