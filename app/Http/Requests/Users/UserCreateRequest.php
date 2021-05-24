<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|string|min:3|max:255',
            'email'          => 'required|email|min:3|max:255',
            'password'       => 'required|confirmed|min:8',
            'cpf_cnpj'       => 'required|cpf_cnpj',
            'user_type_enum' => 'required|integer|in:1,2',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required'           => 'Nome é obrigatório',
            'email.required'          => 'E-mail é obrigatório',
            'email.email'             => 'Informe um e-mail válido',
            'password'                => 'Senha é obrigatório',
            'password.min'            => 'Senha precisa ter no mínimo 8 dígitos',
            'password.confirmed'      => 'Senhas não conferem',
            'cpf_cnpj.required'       => 'CPF/CNPJ é obrigatório',
            'cpf_cnpj.cpf_cnpj'       => 'Informe um CPF/CNPJ válido',
            'user_type_enum.required' => 'Tipo de usuário é obrigatório',
            'user_type_enum.integer'  => 'Tipo de usuário precisa ser um inteiro',
            'user_type_enum.in'       => 'Tipo de usuário inválido',
        ];
    }
}
