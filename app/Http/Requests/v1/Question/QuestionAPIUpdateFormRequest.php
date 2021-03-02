<?php

namespace App\Http\Requests\v1\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuestionAPIUpdateFormRequest extends FormRequest
{
    //todo: implement role
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => ['required', 'string'],
            'level' => ['required', 'string', 'in:junior,senior,expert'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
            'resource_link' => ['nullable', 'string'],
            'hint' => ['nullable', 'string'],
            'answers' => ['nullable'],
            'question_category_id' => ['required', 'string'],
        ];
    }
}
