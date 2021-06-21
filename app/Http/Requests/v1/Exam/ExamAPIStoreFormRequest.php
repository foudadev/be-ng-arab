<?php

namespace App\Http\Requests\v1\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExamAPIStoreFormRequest extends FormRequest {
    //todo: implement role

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'question_category_id' => ['required', 'string'],
            'level' => ['required', 'string', 'in:junior,mid-senior,senior,expert'],
        ];
    }

}
