<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class TransactionCreateRequest extends FormRequest
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

            'payer' => 'required|integer|exists:users,id',
            'payee' => 'required|integer|exists:users,id',
            'value' => 'required|numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'payer.required' => 'Pagador é obrigatório',
            'payer.integer'  => 'Pagador precisa ser inteiro',
            'payer.exists'   => 'Pagador não encontrado',
            'payee.required' => 'Beneficiário é obrigatório',
            'payee.integer'  => 'Beneficiário precisa ser inteiro',
            'payee.exists'   => 'Beneficiário não encontrado',
            'value.required' => 'Valor é obrigatório',
            'value.numeric'  => 'Valor precisa ser númerico',
        ];
    }
}
