<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            //Campos PWCLIENTE
            'cliente' => 'required|string|max:255',
            'fantasia' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'obs' => 'nullable|string|max:250',
            'bloqueio' => 'required|string|size:1',
            'motivo_bloq' => 'nullable|string',
            'tipopessoa' => 'required|string|size:1|in:F,J',

            //Campos PWCLIENTE_FISICO
            'cpf' => 'nullable|string|size:11',
            'rg' => 'nullable|string|max:20',
            'dt_nascimento' => 'nullable|date',

            //Campos PWCLIENTE_JURIDICO
            'cnpj' => 'nullable|string|size:14',
            'inscricaoestadual' => 'nullable|string|max:20',
            'dtabertura' => 'nullable|date',

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
        ];
    }
}