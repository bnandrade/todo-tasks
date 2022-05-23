<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:6',
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
            'email.required' => 'O campo Email é obrigatório',
            'email.email' => 'Email inválido',
            'password.required' => 'O campo Password é obrigatório',
            'password.min' => 'O password deve ter pelo menos 6 caracteres'
        ];
    }
}
