<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMatricula extends FormRequest
{
    public function messages()
    {
        return [
            'aluno.*' => 'Você deve informar um aluno válido.',
            'curso.*' => 'Você deve informar um curso válido.',
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
            'aluno' => ['required', 'exists:users,id'],
            'curso' => ['required', 'exists:cursos,id'],
        ];
    }
}
