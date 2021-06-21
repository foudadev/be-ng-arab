<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'category' => $this->category ? $this->category->name : null,
            'level' => $this->level,
            'status' => $this->status,
            'answering_time' => $this->answering_time,
            'degree' => $this->degree,
            'used_hint_count' => $this->used_hint_count,
            'skipped_count' => $this->skipped_count,
        ];
    }

}
