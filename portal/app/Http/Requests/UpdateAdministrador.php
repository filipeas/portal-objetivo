<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdministrador extends FormRequest
{
    public function messages()
    {
        return [
            'name.*' => 'Você deve informar pelo menos 3 caracteres e no máximo 50 caracteres no campo NOME',
            'lastname.*' => 'Você deve informar pelo menos 3 caracteres e no máximo 50 caracteres no campo SOBRENOME',
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
        ];
    }
}
