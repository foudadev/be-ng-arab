<?php

namespace App\Http\Requests\v1\Answer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AnswerAPIStoreFormRequest extends FormRequest
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
            'answer' => ['required', 'string', 'max:255'],
            'accepted' => ['required', 'integer', 'in:0,1'],
            'question_id' => ['required', 'string', 'exist:questions,id'],
        ];
    }
}
