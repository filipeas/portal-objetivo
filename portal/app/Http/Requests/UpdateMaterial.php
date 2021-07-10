<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterial extends FormRequest
{
    public function messages()
    {
        return [
            'pdf.*' => 'Você deve informar um PDF.',
            'doc.*' => 'Você deve informar um DOC.',
            'type_video.*' => 'Você deve informar o tipo do vídeo.',
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
            'pdf' => ['file', 'mimes:pdf', 'max:2048'],
            'doc' => ['file', 'mimes:docx', 'max:2048'],
            // 'link_video' => ['string'],
            'type_video' => ['required', 'string'],
        ];
    }
}
