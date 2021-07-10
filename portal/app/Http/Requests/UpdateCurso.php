<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurso extends FormRequest
{
    public function messages()
    {
        return [
            'name.*' => 'Você deve informar pelo menos 3 caracteres e no máximo 50 caracteres no campo NOME',
            // 'cover.*' => 'Você deve informar uma capa.',
            'start_date.*' => 'Você deve informar uma data de início do curso.',
            'end_date.*' => 'Você deve informar uma data de término do curso.',
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
            'name' => ['required', 'min:3', 'max:50'],
            // 'cover' => ['string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
}
