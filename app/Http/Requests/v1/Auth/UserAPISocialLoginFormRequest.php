<?php

namespace  App\Http\Requests\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserAPISocialLoginFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'provider_id' => ['required', 'string', 'max:255'],
            'provider_type' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'profile_url' => ['nullable', 'string', 'max:255'],
        ];
    }
}
