<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:191',
            'description' => 'required|string|min:3|max:500',
            'status' => 'required|in:pendente,finalizada'
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
            'title.required' => 'O campo Título é obrigatório',
            'title.min' => 'O campo Título deve conter pelo menos 3 caracteres',
            'title.max' => 'O campo Título deve conter no máximo 191 caracteres',
            'description.required' => 'O campo Descrição é obrigatório',
            'description.min' => 'O campo Descrição deve conter pelo menos 3 caracteres',
            'description.max' => 'O campo Descrição deve conter no máximo 500 caracteres',
            'status.required' => 'O campo Status é obrigatório',
            'status.in' => 'O status deve ser PENDENTE ou FINALIZADA',
        ];
    }
}
