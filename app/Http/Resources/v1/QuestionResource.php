<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request):array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'category' => $this->question_category->name,
            'level' => $this->level,
            'status' => $this->status,
            'resource' => $this->resource,
            'answers'=>AnswerResource::collection($this->answers)
        ];
    }
}
