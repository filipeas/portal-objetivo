<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdministrador extends FormRequest
{
    public function messages()
    {
        return [
            'name.*' => 'Você deve informar pelo menos 3 caracteres e no máximo 50 caracteres no campo NOME',
            'lastname.*' => 'Você deve informar pelo menos 3 caracteres e no máximo 50 caracteres no campo SOBRENOME',
            'email.*' => 'Você deve informar um email válido.',
            'password.*' => 'Você deve informar uma senha entre 6 e 255 caracteres.',
            'c_password.*' => 'As senhas não condizem.',
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
            'name' => ['required', 'min:3', 'max: 50'],
            'lastname' => ['required', 'min:3', 'max: 50'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'max:255'],
            'c_password' => ['required', 'same:password'],
        ];
    }
}
