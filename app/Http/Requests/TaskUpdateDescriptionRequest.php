<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskUpdateDescriptionRequest extends FormRequest
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
            'description' => 'required|string|min:3|max:500'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Erro de validação',
            'data'      => $validator->errors()
        ]));
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O campo Descrição é obrigatório',
            'description.min' => 'O campo Descrição deve conter pelo menos 3 caracteres',
            'description.max' => 'O campo Descrição deve conter no máximo 500 caracteres',
        ];
    }
}
