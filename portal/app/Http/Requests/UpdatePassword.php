<?php

namespace App\Http\Requests;

use App\Rules\ValidCurrentUserPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
{
    public function messages()
    {
        return [
            'c_password.*' => 'Você deve informar sua senha atual.',
            'password.*' => 'Você deve informar uma nova senha de no mínimo 6 caracteres e no máximo 255.',
        ];
    }

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
            'c_password' => ['required', new ValidCurrentUserPassword()],
            'password' => ['required', 'min:6', 'max:255'],
        ];
    }
}
