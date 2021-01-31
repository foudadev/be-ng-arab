<?php

namespace App\Http\Requests\v1\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuestionAPIStoreFormRequest extends FormRequest
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
            'question' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'in:junior,senior,expert'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
            'resource' => ['nullable', 'string'],
            'question_category_id' => ['required', 'string', 'exist:question_categories,id'],
        ];
    }
}
