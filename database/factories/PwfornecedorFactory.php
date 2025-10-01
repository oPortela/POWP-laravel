<?php

namespace Database\Factories;

use App\Models\Pwfornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pwfornecedor>
 */
class PwfornecedorFactory extends Factory
{
    protected $model = Pwfornecedor::class;

    public function definition(): array
    {
        return [
            'nome'          => $this->faker->company,
            'fantasia'      => $this->faker->companySuffix,
            'cnpj'          => $this->faker->numerify('##############'),
            'dtcadastro'    => $this->faker->date(),
            'email'         => $this->faker->companyEmail,
            'codendereco'   => 1, // depois pode virar outra factory
            'codtelefone'   => 1, // idem
            'representante' => $this->faker->name,
        ];
    }
}
