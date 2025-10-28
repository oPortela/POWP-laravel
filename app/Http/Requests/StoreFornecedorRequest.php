<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //Campos PWFORNECEDOR
            'cnpj' => 'required|string|size:14', //|unique:pwfornecedor,cnpj',
            'fornecedor' => 'required|string|max:255',
            'fantasia' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',//|unique:pwfornecedor, email',

            //Rule::unique('pwfornecedor')->ignore($supplierId, 'codfornecedor')

            //Campos PWENDERECO
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string|max:200',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:80',
            'cidade' => 'required|string|max:50',
            'estado' => 'nullable|string|size:2',
            
            //Campo PWCONTATO
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            
            //Campo adicional
            //'representante' => 'nullable|string|max:100'
        ];
    }
}
