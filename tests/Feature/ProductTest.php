<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\pwfornecedor; // <- usa seu model real

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        // Criar fornecedor antes
        $fornecedor = pwfornecedor::factory()->create();

        // Agora cadastrar produto
        $response = $this->post('/produtos', [
            'descricao'   => 'Produto Teste',
            'codfornec'   => $fornecedor->codfornecedor,
            'embalagem'   => 'Caixa',
            'ean'         => '1234567890123',
            'dtcadastro'  => now()->toDateString(),
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('pwproduto', [
            'descricao' => 'Produto Teste',
            'codfornec' => $fornecedor->codfornecedor
        ]);
    }
}
