<?php

namespace App\Services;

use App\Repositories\Interfaces\ClienteRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class ClienteService
{
    protected $repository;

    public function __construct(ClienteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listClientes(int $page, int $perPage)
    {
        return $this->repository->getAll($page, $perPage);
    }

    public function getCliente(string $id)
    {
        $cliente = $this->repository->findById($id);
        
        if (!$cliente) return null;

        // Normalização dos dados (aquela lógica de array[0])
        if (!empty($cliente['pwclientefisico'][0])) {
            $cliente['pwclientefisico'] = $cliente['pwclientefisico'][0];
        }
        if (!empty($cliente['pwclientejuridico'][0])) {
            $cliente['pwclientejuridico'] = $cliente['pwclientejuridico'][0];
        }

        return $cliente;
    }

    public function createCliente(array $data)
    {
        try {
            // 1. Cria Endereço
            $endereco = $this->repository->create('pwendereco', [
                'logradouro' => $data['logradouro'],
                'numero' => $data['numero'],
                'cep' => $data['cep'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
            ]);

            // 2. Cria Telefone
            $telefone = $this->repository->create('pwtelefone', [
                'telefone' => $data['telefone'],
                'celular' => $data['celular'],
            ]);

            // 3. Cria Cliente Base
            $clienteData = [
                'cliente' => $data['cliente'],
                'fantasia' => $data['fantasia'] ?? '',
                'dtcadastro' => now()->format('Y-m-d'),
                'tipopessoa' => $data['tipopessoa'],
                'email' => $data['email'],
                'codendereco' => $endereco['codendereco'],
                'codtelefone' => $telefone['codtelefone'],
                'obs' => $data['obs'] ?? '',
                'bloqueio' => $data['bloqueio'] ?? 'N',
                'motivo_bloq' => $data['motivo_bloq'] ?? ''
            ];
            
            $novoCliente = $this->repository->create('pwcliente', $clienteData);
            $codCliente = $novoCliente['codcliente'];

            // 4. Cria Específico (Físico ou Jurídico)
            if ($data['tipopessoa'] == 'F') {
                $this->repository->create('pwclientefisico', [
                    'codcli' => $codCliente,
                    'cpf' => $data['cpf'],
                    'rg' => $data['rg'],
                    'dt_nascimento' => $data['dt_nascimento'],
                ]);
            } elseif ($data['tipopessoa'] == 'J') {
                $this->repository->create('pwclientejuridico', [
                    'codcli' => $codCliente,
                    'cnpj' => $data['cnpj'],
                    'inscricaoestadual' => $data['inscricaoestadual'],
                    'dtabertura' => $data['dtabertura'],
                ]);
            }

            return $novoCliente;

        } catch (Exception $e) {
            Log::error('Service Error: ' . $e->getMessage());
            throw $e; // Repassa o erro para o controller tratar o response
        }
    }

    public function updateCliente(string $id, array $data)
    {
        $clienteAtual = $this->repository->findById($id);
        if (!$clienteAtual) return null;

        // Atualiza auxiliares
        $this->repository->update('pwendereco', 'codendereco', $clienteAtual['codendereco'], [
            'logradouro' => $data['logradouro'],
            'numero' => $data['numero'],
            'cep' => $data['cep'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'estado' => $data['estado'],
        ]);

        $this->repository->update('pwtelefone', 'codtelefone', $clienteAtual['codtelefone'], [
            'telefone' => $data['telefone'],
            'celular' => $data['celular'],
        ]);

        // Atualiza Cliente
        $clienteAtualizado = $this->repository->update('pwcliente', 'codcliente', $id, [
            'cliente' => $data['cliente'],
            'fantasia' => $data['fantasia'] ?? '',
            'tipopessoa' => $data['tipopessoa'],
            'email' => $data['email'],
            'obs' => $data['obs'] ?? '',
            'bloqueio' => $data['bloqueio'] ?? 'N',
            'motivo_bloq' => $data['motivo_bloq'] ?? ''
        ]);

        // Atualiza Específico
        if ($data['tipopessoa'] == 'F') {
            $this->repository->update('pwclientefisico', 'codcli', $id, [
                'cpf' => $data['cpf'],
                'rg' => $data['rg'],
                'dt_nascimento' => $data['dt_nascimento'],
            ]);
        } elseif ($data['tipopessoa'] == 'J') {
            $this->repository->update('pwclientejuridico', 'codcli', $id, [
                'cnpj' => $data['cnpj'],
                'inscricaoestadual' => $data['inscricaoestadual'],
                'dtabertura' => $data['dtabertura'],
            ]);
        }

        return $clienteAtualizado;
    }

    public function deleteCliente(string $id)
    {
        $cliente = $this->repository->findById($id);
        if (!$cliente) return false;

        // Ordem de deleção (filhos primeiro, depois pai, se não tiver cascade no banco)
        $tableEspec = ($cliente['tipopessoa'] == 'F') ? 'pwclientefisico' : 'pwclientejuridico';
        
        $this->repository->delete($tableEspec, 'codcli', $id);
        $this->repository->delete('pwcliente', 'codcliente', $id);
        $this->repository->delete('pwendereco', 'codendereco', $cliente['codendereco']);
        $this->repository->delete('pwtelefone', 'codtelefone', $cliente['codtelefone']);

        return true;
    }
}