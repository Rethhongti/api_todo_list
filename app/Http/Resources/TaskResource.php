<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'todo' => $this->todo,
            'isCompleted' => $this->is_completed_to_bool,
            'createAt' => Carbon::createFromDate($this->created_at)->format('Y-m-d'),
        ];
    }
}
